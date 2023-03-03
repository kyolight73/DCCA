<?php

namespace Botble\Member\Http\Controllers;

use Assets;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Blog\Models\Post;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Botble\Blog\Repositories\Interfaces\TagInterface;
use Botble\Blog\Services\StoreCategoryService;
use Botble\Blog\Services\StoreTagService;
use Botble\Member\Forms\PostForm;
use Botble\Member\Http\Requests\PostRequest;
use Botble\Member\Models\Member;
use Botble\Member\Repositories\Interfaces\MemberActivityLogInterface;
use Botble\Member\Repositories\Interfaces\MemberInterface;
use Botble\Member\Tables\PostTable;
use EmailHandler;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RvMedia;
use SeoHelper;

class PostController extends Controller
{
    protected MemberInterface $memberRepository;

    protected PostInterface $postRepository;

    protected MemberActivityLogInterface $activityLogRepository;

    public function __construct(
        Repository $config,
        MemberInterface $memberRepository,
        PostInterface $postRepository,
        MemberActivityLogInterface $memberActivityLogRepository
    ) {
        $this->memberRepository = $memberRepository;
        $this->postRepository = $postRepository;
        $this->activityLogRepository = $memberActivityLogRepository;

        Assets::setConfig($config->get('plugins.member.assets', []));
    }

    public function index(PostTable $postTable)
    {
        SeoHelper::setTitle(trans('plugins/blog::posts.posts'));

        return $postTable->render('plugins/member::table.base');
    }

    public function create(FormBuilder $formBuilder)
    {
        SeoHelper::setTitle(trans('plugins/member::member.write_a_post'));

        return $formBuilder->create(PostForm::class)->renderForm();
    }

    public function store(
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {
        $this->processRequestData($request);

        /**
         * @var Post $post
         */
        $post = $this->postRepository->createOrUpdate(
            array_merge($request->except('status'), [
                'author_id' => auth('member')->id(),
                'author_type' => Member::class,
                'status' => BaseStatusEnum::PENDING,
            ])
        );

        event(new CreatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        $this->activityLogRepository->createOrUpdate([
            'action' => 'create_post',
            'reference_name' => $post->name,
            'reference_url' => route('public.member.posts.edit', $post->id),
        ]);

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        EmailHandler::setModule(MEMBER_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'post_name' => $post->name,
                'post_url' => route('posts.edit', $post->id),
                'post_author' => $post->author->name,
            ])
            ->sendUsingTemplate('new-pending-post');

        return $response
            ->setPreviousUrl(route('public.member.posts.index'))
            ->setNextUrl(route('public.member.posts.edit', $post->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int $id, FormBuilder $formBuilder, Request $request)
    {
        $post = $this->postRepository->getFirstBy([
            'id' => $id,
            'author_id' => auth('member')->id(),
            'author_type' => Member::class,
        ]);

        if (! $post) {
            abort(404);
        }

        event(new BeforeEditContentEvent($request, $post));

        SeoHelper::setTitle(trans('plugins/blog::posts.edit') . ' "' . $post->name . '"');

        return $formBuilder
            ->create(PostForm::class, ['model' => $post])
            ->renderForm();
    }

    public function update(
        int $id,
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {
        $post = $this->postRepository->getFirstBy([
            'id' => $id,
            'author_id' => auth('member')->id(),
            'author_type' => Member::class,
        ]);

        if (! $post) {
            abort(404);
        }

        $this->processRequestData($request);

        $post->fill($request->except('status'));

        $this->postRepository->createOrUpdate($post);

        event(new UpdatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        $this->activityLogRepository->createOrUpdate([
            'action' => 'update_post',
            'reference_name' => $post->name,
            'reference_url' => route('public.member.posts.edit', $post->id),
        ]);

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('public.member.posts.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    protected function processRequestData(Request $request): Request
    {
        if ($request->hasFile('image_input')) {
            $result = RvMedia::handleUpload($request->file('image_input'), 0, 'members');
            if (! $result['error']) {
                $file = $result['data'];
                $request->merge(['image' => $file->url]);
            }
        }

        $shortcodeCompiler = shortcode()->getCompiler();

        $request->merge([
            'content' => $shortcodeCompiler->strip(
                $request->input('content'),
                $shortcodeCompiler->whitelistShortcodes()
            ),
        ]);

        $except = [
            'status',
            'is_featured',
        ];

        foreach ($except as $item) {
            $request->request->remove($item);
        }

        return $request;
    }

    public function destroy(int $id, BaseHttpResponse $response)
    {
        $post = $this->postRepository->getFirstBy([
            'id' => $id,
            'author_id' => auth('member')->id(),
            'author_type' => Member::class,
        ]);

        if (! $post) {
            abort(404);
        }

        $this->postRepository->delete($post);

        $this->activityLogRepository->createOrUpdate([
            'action' => 'delete_post',
            'reference_name' => $post->name,
        ]);

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function getAllTags(TagInterface $tagRepository)
    {
        return $tagRepository->pluck('name');
    }
}
