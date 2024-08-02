<?php
namespace Review\WordPress;

final class Init
{
    public function __construct()
    {
        add_action('init', ['\Review\WordPress\CustomPostType\Foods', 'init']);
        add_action('init', ['\Review\WordPress\CustomPostType\Tenis', 'init']);
    }
}
