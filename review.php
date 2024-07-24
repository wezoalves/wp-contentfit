<?php
/*
Plugin Name: WezoAlves - Content Fit
Description: Plugin para adicionar o Custom Post Type Tênis com campos personalizados para reviews de tênis.
Version: 1.0
Author: Weslley Alves
*/


include ('src/Affiliate/Awin.php');

include ('api/Food.php');

include ('src/Domain/AffiliateOffer.php');
include ('src/Domain/BestOffer.php');

include ('src/Model/AffiliateProgram.php');
include ('src/Model/Field.php');
include ('src/Model/Food.php');
include ('src/Model/Offer.php');
include ('src/Model/Tenis.php');
include ('src/Model/TenisType.php');
include ('src/Model/ObjectType.php');

include ('src/Repository/Store.php');
include ('src/Repository/Tenis.php');
include ('src/Repository/Food.php');

include ('src/Store/CustomPostType.php');
include ('src/Store/Metaboxes.php');
include ('src/Store/Save.php');

include ('src/Tenis/CustomPostType.php');
include ('src/Tenis/Metaboxes.php');
include ('src/Tenis/Save.php');

include ('src/Utils/RatingTenis.php');
include ('src/Utils/TypeTenis.php');
include ('src/Utils/SchemaNutrition.php');

include ('src/WordPress/CustomPostType/Foods.php');
include ('src/WordPress/Fields.php');
include ('src/WordPress/Fields/Foods.php');



function getValueCPTReview($postId, $key, $type)
{
    return get_post_meta($postId, $type . '_' . $key, true);
}

/**
 * Add custom style to cpt review options
 * @param mixed $hook
 * @return void
 */
function cpt_review_admin_css($hook)
{
    global $typenow;

    if ($typenow == 'loja' || $typenow == 'tenis') {
        wp_enqueue_style('custom_admin_css', plugin_dir_url(__FILE__) . '/assets/css/cpt.css');
    }
}
add_action('admin_enqueue_scripts', 'cpt_review_admin_css');
