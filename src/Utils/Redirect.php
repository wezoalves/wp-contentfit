<?php

namespace Review\Utils;

final class Redirect
{
    public function getEndPoint()
    {
        return "/go/to/";
    }

    function custom_query_vars($vars)
    {
        $vars[] = 'custom_redirect';
        return $vars;
    }

    function custom_redirect()
    {
        $redirect_url = get_query_var('custom_redirect');
        $redirect_url = base64_decode($redirect_url);
        $redirect_url = urldecode($redirect_url);

        if ($redirect_url) {
            if (filter_var($redirect_url, FILTER_VALIDATE_URL)) {
                wp_redirect($redirect_url, 302, get_bloginfo('name') );
                exit;
            }else{
                echo('copie e cola o link no seu navegador para acessar o site');
                echo($redirect_url);
                die;
            }
        }
    }
}



//add_action('init', [new \Kupo\Setup\Redirect, 'register_redirect_endpoint']);

add_filter('query_vars', [new \Review\Utils\Redirect, 'custom_query_vars']);

add_action('template_redirect', [new \Review\Utils\Redirect, 'custom_redirect']);