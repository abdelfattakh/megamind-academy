<script src="{{asset('frontend/js/popper.min.js?v'. config('app.version'))}}"></script>
<script src="{{asset('frontend/js/jquery-3.6.1.min.js?v'. config('app.version'))}}"></script>
<script src="{{asset('frontend/js/bootstrap.js?v'. config('app.version'))}}"></script>
<script src="{{asset('frontend/js/owl.carousel.min.js?v'. config('app.version'))}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/slick.min.js?v'. config('app.version'))}}"></script>


<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

@if(config('app.env') =='production')
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-83JQ6PZ9HP"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-83JQ6PZ9HP');
    </script>

    <!-- Meta Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '5831796473597595');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://www.facebook.com/tr?id=5831796473597595&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Meta Pixel Code -->

    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "104535134247809");
        chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml            : true,
                version          : 'v16.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endif
