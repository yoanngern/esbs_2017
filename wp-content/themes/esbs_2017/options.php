<?php
// create custom plugin settings menu
add_action( 'admin_menu', 'baw_create_menu' );

function baw_create_menu() {

	//create new top-level menu
	add_menu_page( 'Facebook', 'Facebook', 'administrator', __FILE__, 'baw_settings_page', plugins_url( '/images/icon.png', __FILE__ ) );

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'baw-settings-group', 'new_option_name' );
	register_setting( 'baw-settings-group', 'some_other_option' );
	register_setting( 'baw-settings-group', 'option_etc' );
}

function baw_settings_page() {
	?>



    <script>
        // initialize Account Kit with CSRF protection
        AccountKit_OnInteractive = function(){
            AccountKit.init(
                {
                    appId:"{{FACEBOOK_APP_ID}}",
                    state:"{{csrf}}",
                    version:"{{ACCOUNT_KIT_API_VERSION}}",
                    fbAppEventsEnabled:true,
                    redirect:"{{REDIRECT_URL}}"
                }
            );
        };

        // login callback
        function loginCallback(response) {
            if (response.status === "PARTIALLY_AUTHENTICATED") {
                var code = response.code;
                var csrf = response.state;
                // Send code to server to exchange for access token
            }
            else if (response.status === "NOT_AUTHENTICATED") {
                // handle authentication failure
            }
            else if (response.status === "BAD_PARAMS") {
                // handle bad parameters
            }
        }


        // email form submission handler
        function emailLogin() {
            var emailAddress = document.getElementById("email").value;
            AccountKit.login(
                'EMAIL',
                {emailAddress: emailAddress},
                loginCallback
            );
        }
    </script>



    <div class="wrap">
        <h2>Facebook connect</h2>

        <table class="form-table">
            <tr valign="top">
                <th scope="row">E-mail</th>
                <td><input id="email"/></td>
            </tr>
        </table>

        <p class="submit">
            <button class="button-primary" onclick="emailLogin();"><?php _e( 'Login' ) ?></button>
        </p>


    </div>
<?php } ?>