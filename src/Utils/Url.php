<?php
namespace Review\Utils;

/**
 * Class Url
 *
 * A utility class for manipulating URLs, including adding and removing query parameters.
 *
 * @package Review\Utils
 */
final class Url
{
    /**
     * @var array $defaultUnwantedParams
     * Default query parameters that will be removed from URLs when using the clean() method.
     */
    private static array $defaultUnwantedParams = [
        'gclid',
        'utm_campaign',
        'utm_content',
        'utm_medium',
        'utm_source',
        'utm_term'
    ];

    /**
     * Cleans the provided URL by removing unwanted query parameters.
     *
     * This method removes the query parameters defined in the `$unwantedParams` array.
     * If `$unwantedParams` is empty, the default unwanted parameters are used.
     *
     * @param string $url The URL to be cleaned.
     * @param array $unwantedParams (optional) An array of query parameter keys to remove from the URL.
     * @return string The cleaned URL. If the resulting URL is invalid, the original URL is returned.
     */
    public static function clean($url, $unwantedParams = [])
    {
        // Use default unwanted parameters if none are provided
        $unwantedParams = !empty($unwantedParams) ? $unwantedParams : self::$defaultUnwantedParams;

        // Parse the URL and check if it has a valid host
        $base = parse_url($url);

        if (!isset($base['host'])) {
            return $url;
        }

        // Extract existing query parameters
        $queryParams = [];

        if (isset($base['query'])) {
            parse_str($base['query'], $queryParams);

            // Remove unwanted parameters
            foreach ($unwantedParams as $param) {
                unset($queryParams[$param]);
            }
        }

        // Sort query parameters by key for consistency
        ksort($queryParams);

        // Rebuild the URL
        $urlBase = (isset($base['scheme']) ? $base['scheme'] : 'https') . '://' . $base['host'] . ($base['path'] ?? '');
        $urlNew = $urlBase . (!empty($queryParams) ? '?' . http_build_query($queryParams) : '');

        // Validate and return the cleaned URL
        return filter_var($urlNew, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) ?: $url;
    }

    /**
     * Adds query parameters to the provided URL.
     *
     * This method allows you to add or override query parameters in the given URL.
     *
     * @param string $url The URL to which parameters will be added.
     * @param array $paramsAdd An associative array of query parameters to add to the URL.
     * @return string The updated URL with the added parameters. If the resulting URL is invalid, the original URL is returned.
     */
    public static function add($url, $paramsAdd = [])
    {
        // Parse the URL and check if it has a valid host
        $base = parse_url($url);

        if (!isset($base['host'])) {
            return $url;
        }

        // Extract existing query parameters
        $queryParams = [];
        if (isset($base['query'])) {
            parse_str($base['query'], $queryParams);
        }

        // Add or override parameters
        foreach ($paramsAdd as $key => $value) {
            $queryParams[$key] = $value;
        }

        // Sort query parameters by key for consistency
        ksort($queryParams);

        // Rebuild the URL
        $urlBase = (isset($base['scheme']) ? $base['scheme'] : 'https') . '://' . $base['host'] . ($base['path'] ?? '');
        $urlNew = $urlBase . (!empty($queryParams) ? '?' . http_build_query($queryParams) : '');

        // Validate and return the updated URL
        return filter_var($urlNew, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) ?: $url;
    }
}