<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: <?php echo get_field('facebook_app_id', 'option'); ?>,
            cookie: true,
            xfbml: true,
            version: <?php echo get_field('facebook_api_version', 'option'); ?>
        });

        FB.AppEvents.logPageView();

    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>