</div>
<footer class="page-footer pt-50" style="background: #021738 !important;">
    <div class="container">
        <div class="row">
<<<<<<< Updated upstream
            @if (theme_option('address') ||
                    theme_option('website') ||
                    theme_option('contact_email') ||
                    theme_option('site_description'))
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <aside class="widget widget--transparent widget__footer widget__about">
                        <div class="widget__header">
                            <h3 class="widget__title">{{ __('About us') }}</h3>
                        </div>
                        <div class="widget__content">
                            <p>{{ theme_option('site_description') }}</p>
                            <div class="person-detail">
                                @if (theme_option('address'))
                                    <p><i class="ion-home"></i>{{ theme_option('address') }}</p>
                                @endif
                                @if (theme_option('website'))
                                    <p><i class="ion-earth"></i><a
                                            href="{{ theme_option('website') }}">{{ theme_option('website') }}</a></p>
                                @endif
                                @if (theme_option('contact_email'))
                                    <p><i class="ion-email"></i><a
                                            href="mailto:{{ theme_option('contact_email') }}">{{ theme_option('contact_email') }}</a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </aside>
                </div>
=======
            @if (theme_option('address') || theme_option('website') || theme_option('contact_email') || theme_option('site_description'))
            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                <aside class="widget widget--transparent widget__footer widget__about">
                    <div class="widget__header">
                        <h3 class="widget__title">{{ __('About us') }}</h3>
                    </div>
                    <div class="widget__content footer__social">
                        <p>{{ theme_option('site_description') }}</p>
                        <ul class="social social--simple social--widget list--light">
                            <li>
                                <a href="https://facebook.com" target="_blank" title="Facebook">
                                    <i class="fab fa-facebook"></i>  <span>Facebook</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com" target="_blank" title="Twitter">
                                    <i class="fab fa-twitter"></i>  <span>Twitter</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://instagram.com" target="_blank" title="Github">
                                    <i class="fab fa-instagram"></i>  <span>Instagram</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://linkedin.com" target="_blank" title="Linkedin">
                                    <i class="fab fa-linkedin"></i>  <span>Linkedin</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
>>>>>>> Stashed changes
            @endif
            {!! dynamic_sidebar('footer_sidebar') !!}
        </div>
    </div>
    <div class="page-footer__bottom" style="background: #021738">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6 text-start">
                    <div class="page-copyright">
                        <p>{!! BaseHelper::clean(theme_option('copyright')) !!}</p>
                    </div>
                </div>
                @if (theme_option('social_links'))
                    <div class="col-md-4 col-sm-6 text-end">
                        <div class="page-footer__social">
                            <ul class="social social--simple">
                                @foreach (json_decode(theme_option('social_links'), true) as $socialLink)
                                    @if (count($socialLink) == 3)
                                        <li>
                                            <a href="{{ $socialLink[2]['value'] }}"
                                                title="{{ $socialLink[0]['value'] }}" target="_blank">
                                                <i class="hi-icon {{ $socialLink[1]['value'] }}"></i>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</footer>
<div id="back2top"><i class="fa fa-angle-up"></i></div>

<!-- JS Library-->
{!! Theme::footer() !!}

<script src="{{ asset('themes/ripple/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: false,
            margin: 10,
            autoplay: true,
            animateOut: 'fadeOut',
            autoplayTimeout: 5000,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        })
    });
</script>
</body>

</html>
<script>
    $(window).bind('scroll', function() {
        if ($(window).scrollTop() > 250) {
            $('.header-two-wrap').addClass('fixed');
            $('#header.header').addClass('d-none');
        } else {
            $('.header-two-wrap').removeClass('fixed');
            $('#header.header').removeClass('d-none');
        }
    });
</script>
<script>
    jQuery('body').append('<div style="" id="loadingDiv"><div class="loader"></div></div>');
    jQuery(window).on('load', function() {
        setTimeout(removeLoader, 200);
    });

    function removeLoader() {
        jQuery("#loadingDiv").fadeOut(200, function() {
            jQuery("#loadingDiv").remove();
        });
    }
</script>
<style>
    #loadingDiv {
        background: #000000c1;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9999999999999
    }

    .loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        width: 120px;
        height: 120px;
        margin: -50px 0 0 -50px;
        border: 16px solid #fff0;
        border-radius: 50%;
        border-top: 16px solid #ff4444;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 0.1s linear infinite;
        background: #fff0;
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }


    .animate-bottom {
        position: relative;
        -webkit-animation-name: animatebottom;
        -webkit-animation-duration: 1s;
        animation-name: animatebottom;
        animation-duration: 1s
    }

    @-webkit-keyframes animatebottom {
        from {
            bottom: -100px;
            opacity: 0
        }

        to {
            bottom: 0px;
            opacity: 1
        }
    }

    @keyframes animatebottom {
        from {
            bottom: -100px;
            opacity: 0
        }

        to {
            bottom: 0;
            opacity: 1
        }
    }
</style>
