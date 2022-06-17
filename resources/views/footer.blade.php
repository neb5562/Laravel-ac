@guest
<!-- ================ Subscribe section start ================= -->

<section class="subscribe-position">
    <div class="container">
        <div class="subscribe text-center">
            <h3 class="subscribe__title">გამოიწერე სიახლეები</h3>
            <p>იყავი პირველი, გაიგე ახალი პროდუქციისა თუ რეცეპტის შესახებ!</p>
            <div id="mc_embed_signup">
                <form action="{{ route('emailSubscribe') }}" method="post" class="subscribe-form form-inline mt-5 pt-1">
                    @csrf
                    <div class="form-group ml-sm-auto">
                        <label>
                            <input class="form-control mb-1" type="email" name="email" placeholder="ელ.ფოსტის მისამართი" required>
                        </label>
                    </div>
                    <button class="button button-subscribe mr-auto mb-1" type="submit">გამოწერა</button>

                </form>
            </div>

        </div>
    </div>
</section>
<!-- ================ Subscribe section end ================= -->
@endguest
<footer class="footer">
    <div class="footer-area">
        <div class="container">
            <div class="row section_gap">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget tp_widgets">
                        <h4 class="footer_title large_title">Our Mission</h4>
                        <p>
                            So seed seed green that winged cattle in. Gathering thing made fly you're no
                            divided deep moved us lan Gathering thing us land years living.
                        </p>
                        <p>
                            So seed seed green that winged cattle in. Gathering thing made fly you're no divided deep moved
                        </p>
                    </div>
                </div>
                <div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6">
                    <div class="single-footer-widget tp_widgets">
                        <h4 class="footer_title">სწრაფი ლინკები</h4>
                        <ul class="list">
                            <li><a title="მთვარი გვერდი" href="{{ route('home') }}">მთვარი გვერდი</a></li>
                            @guest
                            <li><a title="მაღაზია" href="{{ route('login') }}">ავტორიზაცია</a></li>
                            @endguest
                            <li><a title="მაღაზია" href="{{ route('shop') }}">მაღაზია</a></li>
                            <li><a title="ბლოგი" href="{{ route('blog') }}">ბლოგი</a></li>
                            @auth
                            <li><a title="პირადი გვერდი" href="{{ route('user.profile') }}">პირადი გვერდი</a></li>
                            @endauth
                            <li><a title="კონფიდენციალურობა" href="{{ route('privacy') }}">კონფიდენციალურობა</a></li>
                            <li><a title="კონტაქტი" href="{{ route('contact') }}">კონტაქტი</a></li>
                            <li><a title="ხშირად დასმული კითხვები" href="{{ route('faq') }}">ხ.დ.კ</a></li>
                        </ul>
                    </div>
                </div>
                {{--
                   <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="single-footer-widget instafeed">
                        <h4 class="footer_title">Gallery</h4>
                        <ul class="list instafeed d-flex flex-wrap">
                            <li><img src="{{ asset('images/gallery/r1.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('images/gallery/r2.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('images/gallery/r3.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('images/gallery/r5.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('images/gallery/r7.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('images/gallery/r8.jpg') }}" alt=""></li>
                        </ul>
                    </div>
                </div>
                --}}

                <div class="offset-lg-1 col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget tp_widgets">
                        <h4 class="footer_title">Contact Us</h4>
                        <div class="ml-40">
                            <p class="sm-head">
                                <span class="fa fa-location-arrow"></span>
                                Head Office
                            </p>
                            <p>123, Main Street, Your City</p>

                            <p class="sm-head">
                                <span class="fa fa-phone"></span>
                                Phone Number
                            </p>
                            <p>
                                +123 456 7890 <br>
                                +123 456 7890
                            </p>

                            <p class="sm-head">
                                <span class="fa fa-envelope"></span>
                                Email
                            </p>
                            <p>
                                free@infoexample.com <br>
                                www.infoexample.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom"  @if( !isset($_COOKIE['acceptCookies'])) style="padding-bottom:60px!important;"  @endif  >
        <div class="container">
            <div class="row d-flex">
                <p class="col-lg-12 footer-text text-center">

                    {{ now()->year }} &copy;  {{ config('app.name') }}
                    <p style="margin: 0 auto;">
                        Developed by <a style="color:#ff2185;"  href="https://www.facebook.com/nebieridze.gia/" target="_blank">Gia Nebieridze</a>
                    </p>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('vendors/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendors/skrollr.min.js') }}"></script>
<script src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('vendors/nice-select/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('vendors/nouislider/nouislider.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/password.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.js"></script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ka_GE/sdk.js#xfbml=1&version=v10.0&appId=1059910634029188&autoLogAppEvents=1" nonce="S0qUnaqg"></script>
<script>


    $(function() {

        $('#reg_password').password({
            enterPass: 'პაროლი',
            shortPass: 'ძალიან მოკლეა',
            containsField: 'პაროლი არ უნდა შეიცავდეს მომხმარებლის სახელს',
            steps: {
                // Easily change the steps' expected score here
                13: 'პაროლი ძალიან სუსტია',
                33: 'სუსტია! რიცხვები და სიმბოლოებიც რომ შეურიო?',
                67: 'არაუშავს! მაგრამ მოდი რაიმე სიმბოლო დაუმატე მაგალითად @#$%',
                94: 'ძლიერი პაროლია!',
            },
            showPercent: false,
            showText: true, // shows the text tips
            animate: true, // whether or not to animate the progress bar on input blur/focus
            animateSpeed: 'fast', // the above animation speed
            field: false, // select the match field (selector or jQuery instance) for better password checks
            fieldPartialMatch: true, // whether to check for partials in field
            minimumLength: 4, // minimum password length (below this threshold, the score is 0)
            useColorBarImage: false, // use the (old) colorbar image
            customColorBarRGB: {
                red: [0, 240],
                green: [51, 204,51],
                blue: 10,
            } // set custom rgb color ranges for colorbar.
        });

        $(".progress").each(function() {

            var value = $(this).attr('data-value');
            var left = $(this).find('.progress-left .progress-bar');
            var right = $(this).find('.progress-right .progress-bar');

            if (value > 0) {
                if (value <= 50) {
                    right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                } else {
                    right.css('transform', 'rotate(180deg)')
                    left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
                }
            }

        })

        function percentageToDegrees(percentage) {

            return percentage / 100 * 360

        }

    });

    $(document).ready(function(){

        $("#globalmessagemodal").modal('show');

        $('a[href$="#AddAddressModal"]').on( "click", function() {
            $('#ModalAddress').modal('show');
        });

        $('a[href$="#ModalPasswordChange"]').on( "click", function() {
            $('#ModalPasswordChange').modal('show');
        });

    });
</script>
