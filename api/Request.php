<?php

namespace ReviewApi;

class Request
{
    private function authenticate($request)
    {
        $auth_header = $request->get_header('authorization');
        if (! $auth_header) {
            return new \WP_Error('authorization_header_missing', 'Authorization header is missing', array('status' => 401));
        }

        list($type, $credentials) = explode(' ', $auth_header, 2);
        if (strtolower($type) !== 'basic') {
            return new \WP_Error('authorization_header_invalid', 'Authorization header is invalid', array('status' => 401));
        }

        $decoded_credentials = base64_decode($credentials);

        list($username, $password) = explode(':', $decoded_credentials, 2);

        $user = wp_authenticate($username, $password);

        if (is_wp_error($user)) {
            return new \WP_Error('rest_forbidden', esc_html__('Invalid credentials.'), array('status' => 403));
        }

        return true;
    }
}
