@php
    use Illuminate\Support\Facades\Auth;
    // dd($page);
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
<section id="slide-wrap">
    <div class="owl-carousel">
        <div>
            <img src="https://labartisan.net/demo/constol/assets/images/banner/bg/01.jpg">
            <div class="container text-banner">
                <div class="banner__area">
                    <div class="row">
                        <div class="col-xl-6 col-lg-9 col-12">
                            <div class="banner__content">
                                <h6>Innovative business solution</h6>
                                <h2>The right people for your team</h2>
                                <div class="banner__btngroup d-flex align-items-center">
                                    <a href="#" class="lab-btn">View all services</a>
                                    <a href="https://www.youtube.com/embed/YjhrligRTbE" data-rel="lightcase"
                                        class="video__btn d-flex align-items-center">
                                        <i class="fas fa-play-circle ms-4"></i>
                                        <span class="ms-2" style="font-weight: 700;font-size: 16px;">How we work</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <img src="https://labartisan.net/demo/constol/assets/images/banner/bg/01-d2.jpg">
            <div class="container text-banner">
                <div class="banner__area">
                    <div class="row">
                        <div class="offset-lg-3 offset-xl-6 col-xl-6 col-lg-9 col-12">
                            <div class="banner__content">
                                <h6>Innovative business solution</h6>
                                <h2>The right people for your team</h2>
                                <div class="banner__btngroup d-flex align-items-center">
                                    <a href="#" class="lab-btn">View all services</a>
                                    <a href="https://www.youtube.com/embed/YjhrligRTbE" data-rel="lightcase"
                                        class="video__btn d-flex align-items-center">
                                        <i class="fas fa-play-circle ms-4"></i>
                                        <span class="ms-2" style="font-weight: 700;font-size: 16px;">How we work</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- @if (Auth::user()->hasAnyPermisisons(['posts.edit', 'posts.delete']))
<img src="https://imageio.forbes.com/specials-images/imageserve/63fdf8aec0873cb20907b7f6/elden-ring/960x0.jpg?height=399&width=711&fit=bounds" alt="Elden">
@else
You don't have permission to edit a post
@endif --}}
{{-- @if(Auth::user()->hasPermission('posts.publish'))
<div>1</div>
@endif --}}

<div class="about padding-tb">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 col-12">
                <div class="about__content">
                    <h6>Who we are</h6>
                    <h2>Excellent IT services for <br> your success</h2>
                    <p>We are proud to offer top rangen comprehen employmen services such and aser payroll and benefts adminitration management asstance with global business range employment employer compliance.</p>
                    <p>We are proud to offer top rangen comprehen employmen services such and aser payroll and benefts adminitration management asstance with global business range employment employer compliance.</p>
                    <a href="#" class="lab-btn mt-3">Book a consultation</a>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="about__thumb">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="thumb">
                                <img src="https://labartisan.net/demo/constol/assets/images/about/01.jpg" alt="about" class="w-100">
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="thumb">
                                <img src="https://labartisan.net/demo/constol/assets/images/about/02.jpg" alt="about" class="w-100">
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="thumb thumb--content">
                                <h4>Corporate <br> Ethics Program</h4>
                                <img src="https://labartisan.net/demo/constol/assets/images/about/icon/03.png" alt="about icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endif
