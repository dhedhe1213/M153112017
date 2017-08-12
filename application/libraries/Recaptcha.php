<?php (! defined('BASEPATH')) and exit('No direct script access allowed');

/**
 * CodeIgniter Recaptcha library
 *
 * @package CodeIgniter
 * @author  Bo-Yi Wu <appleboy.tw@gmail.com>
 * @link    https://github.com/appleboy/CodeIgniter-reCAPTCHA
 */
class Recaptcha
{
    /**
     * ci instance object
     *
     */
    private $_ci;

    /**
     * reCAPTCHA site up, verify and api url.
     *
     */


    const sign_up_url = 'https://www.google.com/recaptcha/admin';
    const site_verify_url = 'https://www.google.com/recaptcha/api/siteverify';
    const api_url = 'https://www.google.com/recaptcha/api.js';

    /**
     * constructor
     *
     * @param string $config
     */

//    Site Key & Secret key ada di Config
//6LfnGSEUAAAAAGW6Z9XgdDAfiLUqKrE_IfDviGAM sitekey bukan Local
//6LfnGSEUAAAAAIRCoyOBxgYNVP50I1MWZjkuO0F2 secreetkeybukanlocal

//6Lcc5w8UAAAAAFyQZUxROghr747Ctt5zQVviKy2T site key localhost
//6Lcc5w8UAAAAAHgz0EJu9GCD3G7l6frQKQe8G27C secreet key localhost

    public function __construct()
    {
        $this->_ci = & get_instance();
        $this->_siteKey = "6LfnGSEUAAAAAGW6Z9XgdDAfiLUqKrE_IfDviGAM";
        $this->_secretKey = "6LfnGSEUAAAAAIRCoyOBxgYNVP50I1MWZjkuO0F2";
        $this->_language = "id";

        if (empty($this->_siteKey) or empty($this->_secretKey)) {
            die("To use reCAPTCHA you must get an API key from <a href='"
                .self::sign_up_url."'>".self::sign_up_url."</a>");
        }
    }

    /**
     * Submits an HTTP GET to a reCAPTCHA server.
     *
     * @param array $data array of parameters to be sent.
     *
     * @return array response
     */
    private function _submitHTTPGet($data)
    {
        $url = self::site_verify_url.'?'.http_build_query($data);
        $response = file_get_contents($url);

        return $response;
    }

    /**
     * Calls the reCAPTCHA siteverify API to verify whether the user passes
     * CAPTCHA test.
     *
     * @param string $response response string from recaptcha verification.
     * @param string $remoteIp IP address of end user.
     *
     * @return ReCaptchaResponse
     */
    public function verifyResponse($response, $remoteIp = null)
    {
        $remoteIp = (!empty($remoteIp)) ? $remoteIp : $this->_ci->input->ip_address();

        // Discard empty solution submissions
        if (empty($response)) {
            return array(
                'success' => false,
                'error-codes' => 'missing-input',
            );
        }

        $getResponse = $this->_submitHttpGet(
            array(
                'secret' => $this->_secretKey,
                'remoteip' => $remoteIp,
                'response' => $response,
            )
        );

        // get reCAPTCHA server response
        $responses = json_decode($getResponse, true);

        if (isset($responses['success']) and $responses['success'] == true) {
            $status = true;
        } else {
            $status = false;
            $error = (isset($responses['error-codes'])) ? $responses['error-codes']
                : 'invalid-input-response';
        }

        return array(
            'success' => $status,
            'error-codes' => (isset($error)) ? $error : null,
        );
    }

    /**
     * Render Script Tag
     *
     * onload: Optional.
     * render: [explicit|onload] Optional.
     * hl: Optional.
     * see: https://developers.google.com/recaptcha/docs/display
     *
     * @param array parameters.
     *
     * @return scripts
     */
    public function getScriptTag(array $parameters = array())
    {
        $default = array(
            'render' => 'onload',
            'hl' => $this->_language,
        );

        $result = array_merge($default, $parameters);

        $scripts = sprintf('<script type="text/javascript" src="%s?%s" async defer></script>',
            self::api_url, http_build_query($result));

        return $scripts;
    }

    /**
     * render the reCAPTCHA widget
     *
     * data-theme: dark|light
     * data-type: audio|image
     *
     * @param array parameters.
     *
     * @return scripts
     */
    public function getWidget(array $parameters = array())
    {
        $default = array(
            'data-sitekey' => $this->_siteKey,
            'data-theme' => 'light',
            'data-type' => 'image',
        );

        $result = array_merge($default, $parameters);

        $html = '';
        foreach ($result as $key => $value) {
            $html .= sprintf('%s="%s" ', $key, $value);
        }

        return '<div class="g-recaptcha" '.$html.'></div>';
    }
}
