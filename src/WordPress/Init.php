<?php
namespace Review\WordPress;

final class Init
{
    public function __construct()
    {
        add_action('init', ['\Review\WordPress\CustomPostType\Foods', 'init']);
        add_action('init', ['\Review\WordPress\CustomPostType\Tenis', 'init']);
        add_action('init', ['\Review\WordPress\CustomPostType\Store', 'init']);
        add_action('init', ['\Review\WordPress\CustomPostType\Coupon', 'init']);
        
        add_action('admin_enqueue_scripts', ['\Review\WordPress\Init', 'styleCss']);
    }

    public static function styleCss($hook)
    {
        wp_enqueue_style('custom_admin_css', REVIEW_PATH_PLUGIN . '/assets/css/review-style.css');
    }
}
