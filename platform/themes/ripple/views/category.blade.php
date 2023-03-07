@php Theme::set('section-name', $category->name) @endphp
<div class="row">
@if ($posts->count() > 0)
    @foreach ($posts as $post)
        <article class="post post__horizontal mb-40 clearfix col-md-4">
            <div class="post__thumbnail">
                <span class="post__created-at"><i class="ion-clock"></i>{{ $post->created_at->translatedFormat('M d, Y') }}</span>
                <img src="{{ RvMedia::getImageUrl($post->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}" loading="lazy"><a href="{{ $post->url }}" title="{{ $post->name }}" class="post__overlay"></a>
            </div>
            <div class="post__content-wrap">
                <header class="post__header">
                    <h3 class="post__title"><a href="{{ $post->url }}" title="{{ $post->name }}">{!! BaseHelper::clean($post->name) !!}</a></h3>
                    <div class="post__meta">
                        @if ($post->author->username)
                            <span class="post__author"><i class="ion-android-person"></i><span>{{ $post->author->name }}</span></span>
                        @endif
                        <span class="post-category"><i class="ion-cube"></i><a href="{{ $category->url }}">{!! BaseHelper::clean($category->name) !!}</a></span></div>
                </header>
                <div class="post__content">
                    <p data-number-line="2">{{ $post->description }}</p>
                </div>
            </div>
        </article>
    @endforeach
</div>
    <div class="page-pagination text-right">
        {!! $posts->links() !!}
    </div>
@else
    <div class="alert alert-warning">
        <p class="mb-0">{{ __('There is no data to display!') }}</p>
    </div>
@endif
