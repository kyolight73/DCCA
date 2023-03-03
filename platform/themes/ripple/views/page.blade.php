@php
    use Illuminate\Support\Facades\Auth;
@endphp
@if (!BaseHelper::isHomepage($page->id))
    @php
        Theme::set('section-name', SeoHelper::getTitle());
        $page->loadMissing('metadata');

        $bannerImage = $page->getMetaData('banner_image', true);

        if ($bannerImage) {
            Theme::set('breadcrumbBannerImage', RvMedia::getImageUrl($bannerImage));
        }

    @endphp
    <article class="post post--single">
        <div class="post__content">
            @if (defined('GALLERY_MODULE_SCREEN_NAME') && !empty($galleries = gallery_meta_data($page)))
                {!! render_object_gallery($galleries) !!}
            @endif
            {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, BaseHelper::clean($page->content), $page) !!}
        </div>
    </article>
@else
    @if (defined('GALLERY_MODULE_SCREEN_NAME') && !empty($galleries = gallery_meta_data($page)))
        {!! render_object_gallery($galleries) !!}
    @endif
    {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, BaseHelper::clean($page->content), $page) !!}
@endif
@if (BaseHelper::isHomepage($page->id))

{{-- @if (Auth::user()->hasAnyPermisisons(['posts.edit', 'posts.delete']))
<img src="https://imageio.forbes.com/specials-images/imageserve/63fdf8aec0873cb20907b7f6/elden-ring/960x0.jpg?height=399&width=711&fit=bounds" alt="Elden">
@else
You don't have permission to edit a post
@endif --}}
{{-- @if(Auth::user()->hasPermission('posts.publish'))
<div>1</div>
@endif --}}

@php
    echo '[featured-categories-posts title="456"][/featured-categories-posts]';
    echo '[blog-posts paginate="12"][/blog-posts]';
@endphp



@endif
