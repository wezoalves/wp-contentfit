<?php

namespace ReviewApi;

class Request
{
    public function authenticate($request)
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

    public function getDomain($url)
    {
        // Parse a URL and return its components
        $parsedUrl = parse_url($url);
        if (! isset($parsedUrl['host'])) {
            return null;
        }

        // Extract the host part of the URL
        $host = $parsedUrl['host'];

        // Remove 'www.' from the beginning of the host if it exists
        $host = preg_replace('/^www\./', '', $host);

        // Split the host into parts
        $hostParts = explode('.', $host);
        $numParts = count($hostParts);

        // Check for common second-level domains in Brazil
        $secondLevelDomains = ['com.br', 'org.br', 'net.br'];

        // If the domain ends with a known second-level domain, ensure we keep the last three parts
        if ($numParts > 2 && in_array($hostParts[$numParts - 2] . '.' . $hostParts[$numParts - 1], $secondLevelDomains)) {
            $host = implode('.', array_slice($hostParts, -3));
        } else {
            // Otherwise, keep the last two parts
            $host = implode('.', array_slice($hostParts, -2));
        }

        return $host;
    }
}
