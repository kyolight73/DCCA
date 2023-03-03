<?php

namespace Botble\RequestLog\Http\Controllers;

use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\RequestLog\Repositories\Interfaces\RequestLogInterface;
use Botble\RequestLog\Tables\RequestLogTable;
use Exception;
use Illuminate\Http\Request;

class RequestLogController extends BaseController
{
    use HasDeleteManyItemsTrait;

    protected RequestLogInterface $requestLogRepository;

    public function __construct(RequestLogInterface $requestLogRepository)
    {
        $this->requestLogRepository = $requestLogRepository;
    }

    public function getWidgetRequestErrors(Request $request, BaseHttpResponse $response)
    {
        $limit = (int)$request->input('paginate', 10);
        $limit = $limit > 0 ? $limit : 10;

        $requests = $this->requestLogRepository
            ->advancedGet([
                'order_by' => ['created_at' => 'DESC'],
                'paginate' => [
                    'per_page' => $limit,
                    'current_paged' => (int)$request->input('page', 1),
                ],
            ]);

        return $response
            ->setData(view('plugins/request-log::widgets.request-errors', compact('requests', 'limit'))->render());
    }

    public function index(RequestLogTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/request-log::request-log.name'));

        return $dataTable->renderTable();
    }

    public function destroy(Request $request, int $id, BaseHttpResponse $response)
    {
        try {
            $log = $this->requestLogRepository->findOrFail($id);
            $this->requestLogRepository->delete($log);

            event(new DeletedContentEvent(REQUEST_LOG_MODULE_SCREEN_NAME, $request, $log));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems(
            $request,
            $response,
            $this->requestLogRepository,
            REQUEST_LOG_MODULE_SCREEN_NAME
        );
    }

    public function deleteAll(BaseHttpResponse $response)
    {
        $this->requestLogRepository->getModel()->truncate();

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
