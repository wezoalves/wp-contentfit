<?php
/*
Plugin Name: WezoAlves - Content Fit
Description: Plugin para adicionar o Custom Post Type Tênis com campos personalizados para reviews de tênis.
Version: 1.0
Author: Weslley Alves
*/

require __DIR__ . '/vendor/autoload.php';

define("REVIEW_PATH_PLUGIN", plugin_dir_url(__FILE__));

(new \Review\WordPress\Init());