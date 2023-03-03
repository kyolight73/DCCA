<?php

namespace Botble\CustomField\Http\Controllers;

use Assets;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\CustomField\Actions\CreateCustomFieldAction;
use Botble\CustomField\Actions\DeleteCustomFieldAction;
use Botble\CustomField\Actions\ExportCustomFieldsAction;
use Botble\CustomField\Actions\ImportCustomFieldsAction;
use Botble\CustomField\Actions\UpdateCustomFieldAction;
use Botble\CustomField\Forms\CustomFieldForm;
use Botble\CustomField\Http\Requests\CreateFieldGroupRequest;
use Botble\CustomField\Http\Requests\UpdateFieldGroupRequest;
use Botble\CustomField\Repositories\Interfaces\FieldGroupInterface;
use Botble\CustomField\Repositories\Interfaces\FieldItemInterface;
use Botble\CustomField\Tables\CustomFieldTable;
use CustomField;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CustomFieldController extends BaseController
{
    protected FieldGroupInterface $fieldGroupRepository;

    protected FieldItemInterface $fieldItemRepository;

    public function __construct(FieldGroupInterface $fieldGroupRepository, FieldItemInterface $fieldItemRepository)
    {
        $this->fieldGroupRepository = $fieldGroupRepository;
        $this->fieldItemRepository = $fieldItemRepository;
    }

    public function index(CustomFieldTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/custom-field::base.page_title'));

        Assets::addScriptsDirectly('vendor/core/plugins/custom-field/js/import-field-group.js')
            ->addScripts(['blockui']);

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/custom-field::base.form.create_field_group'));

        Assets::addStylesDirectly([
            'vendor/core/plugins/custom-field/css/custom-field.css',
            'vendor/core/plugins/custom-field/css/edit-field-group.css',
        ])
            ->addScriptsDirectly('vendor/core/plugins/custom-field/js/edit-field-group.js')
            ->addScripts(['jquery-ui']);

        return $formBuilder->create(CustomFieldForm::class)->renderForm();
    }

    public function store(CreateFieldGroupRequest $request, CreateCustomFieldAction $action, BaseHttpResponse $response)
    {
        $result = $action->run($request->input());

        $hasError = false;
        $message = trans('core/base::notices.create_success_message');
        if ($result['error']) {
            $hasError = true;
            $message = Arr::first($result['messages']);
        }

        return $response
            ->setError($hasError)
            ->setPreviousUrl(route('custom-fields.index'))
            ->setNextUrl(route('custom-fields.edit', $result['data']['id']))
            ->setMessage($message);
    }

    public function edit(int $id, FormBuilder $formBuilder, Request $request)
    {
        Assets::addStylesDirectly([
            'vendor/core/plugins/custom-field/css/custom-field.css',
            'vendor/core/plugins/custom-field/css/edit-field-group.css',
        ])
            ->addScriptsDirectly('vendor/core/plugins/custom-field/js/edit-field-group.js')
            ->addScripts(['jquery-ui']);

        $fieldGroup = $this->fieldGroupRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $fieldGroup));

        page_title()->setTitle(trans('plugins/custom-field::base.form.edit_field_group') . ' "' . $fieldGroup->title . '"');

        $fieldGroup->rules_template = CustomField::renderRules();

        return $formBuilder->create(CustomFieldForm::class, ['model' => $fieldGroup])->renderForm();
    }

    public function update(
        int $id,
        UpdateFieldGroupRequest $request,
        UpdateCustomFieldAction $action,
        BaseHttpResponse $response
    ) {
        $result = $action->run($id, $request->input());

        $message = trans('core/base::notices.update_success_message');
        if ($result['error']) {
            $response->setError();
            $message = Arr::first($result['messages']);
        }

        return $response
            ->setPreviousUrl(route('custom-fields.index'))
            ->setMessage($message);
    }

    public function destroy(int $id, BaseHttpResponse $response, DeleteCustomFieldAction $action)
    {
        try {
            $action->run($id);

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response, DeleteCustomFieldAction $action)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $action->run($id);
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function getExport(ExportCustomFieldsAction $action, $id = null)
    {
        $ids = [];

        if (! $id) {
            foreach ($this->fieldGroupRepository->all() as $item) {
                $ids[] = $item->id;
            }
        } else {
            $ids[] = $id;
        }

        $json = $action->run($ids)['data'];

        return response()->json($json, 200, [
            'Content-type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="export-field-group.json"',
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function postImport(ImportCustomFieldsAction $action, Request $request)
    {
        $json = (array)$request->input('json_data', []);

        return $action->run($json);
    }
}
