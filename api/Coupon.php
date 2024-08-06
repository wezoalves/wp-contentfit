<?php

namespace ReviewApi;

final class Coupon extends \ReviewApi\Request implements \Review\Interface\ApiInterface
{

    function getFieldValidator() : string
    {
        return \Review\WordPress\CustomPostType\Coupon::getKey() . "_promotionId";
    }
    function create(\WP_REST_Request $request)
    {
        $auth_result = $this->authenticate($request);

        if (is_wp_error($auth_result)) {
            return $auth_result;
        }

        if ($request->has_param($this->getFieldValidator())) :
            return $this->createItem($request);
        endif;
    }

    private function createItem(\WP_REST_Request $request)
    {

        $args = array(
            'post_type' => \Review\WordPress\CustomPostType\Coupon::getSlug(),
            'meta_key' => $this->getFieldValidator(),
            'meta_value' => $request->get_param($this->getFieldValidator()),
            'meta_compare' => '=',
            'numberposts' => 1,
        );
        $isNewRegister = true;
        $posts = get_posts($args);

        if ($posts && count($posts) > 0) {
            $post_id = $posts[0]->ID;
            $isNewRegister = false;
        }

        $meta_input = [];
        $fields = (new \Review\WordPress\Fields\Coupon())->fields();
        foreach ($fields as $field) :
            $meta_input[$field->getId()] = $request->get_param($field->getId()) ?? null;
        endforeach;


        $urlCupom = $meta_input['coupon_url'] ?? null;
        $urlCoupon = $this->getDomain($urlCupom);
        $store = (new \Review\Repository\Store())->getByDomain($urlCoupon);
        if(!$store){
            return rest_ensure_response(new \WP_REST_Response("store not found {$urlCoupon}", 500));
        }
        $meta_input['coupon_store'] = $store->getId();

        
        $post_title = $request->get_param('title');
        $post_title = ucfirst(mb_strtolower($post_title));
        $post_title = strtr($post_title, [
            "r$" => "R$ ",
            "off" => "OFF "
        ]);
        $post_content = $request->get_param('description');
        $post_author = (new \Review\Repository\User())->getUserDefault()->ID;

        $data = array(
            'post_type' => \Review\WordPress\CustomPostType\Coupon::getSlug(),
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_author' => $post_author,
            'meta_input' => $meta_input,
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed'
        );

        if ($isNewRegister) :
            $post_id = wp_insert_post($data);
        endif;

        if (! $isNewRegister) :
            $data['ID'] = $post_id;
            $post_id = wp_update_post($data);
        endif;

        foreach ($meta_input as $key => $metaValue) :
            if (is_array($metaValue)) {
                $metaValue = json_encode($metaValue);
            }
            add_post_meta($post_id, $key, $metaValue, true);
        endforeach;

        if (! is_wp_error($post_id)) {
            $statusMsg = $isNewRegister ? 'criado' : 'atualizado';
            return rest_ensure_response(["Coupon #{$post_id} - {$post_title} {$statusMsg} com sucesso!"]);
        } else {
            $statusMsg = $isNewRegister ? 'criar' : 'atualizar';
            return rest_ensure_response(new \WP_REST_Response('Erro ao {$statusMsg} Coupon: ' . $post_id->get_error_message(), 500));
        }
    }

    function get(\WP_REST_Request $request)
    {
        $auth_result = $this->authenticate($request);
        if (is_wp_error($auth_result)) {
            return $auth_result;
        }

        $post_id = $request->get_param('id');
        $item = (new \Review\Repository\Coupon())->getById($post_id);
        return rest_ensure_response($item);
    }

    function list(\WP_REST_Request $request)
    {
        $auth_result = $this->authenticate($request);
        if (is_wp_error($auth_result)) {
            return $auth_result;
        }

        $page = $request->get_param('page') ? absint($request->get_param('page')) : 1;
        $per_page = $request->get_param('per_page') ? absint($request->get_param('per_page')) : 20;
        $search_term = $request->get_param('search_term') ? sanitize_text_field($request->get_param('search_term')) : '';
        $foods = (new \Review\Repository\Food())->getAll(
            $per_page,
            $page,
            $search_term
        );
        return rest_ensure_response($foods);
    }

    function delete(\WP_REST_Request $request)
    {

    }

    public function RestApiInit()
    {
        register_rest_route(
            'api/v1/coupon',
            '/add',
            array(
                'methods' => 'POST',
                'callback' => array($this, 'create'),
                'permission_callback' => '__return_true',
            )
        );

        register_rest_route(
            'api/v1/coupon',
            '/get/(?P<id>\d+)',
            array(
                'methods' => 'GET',
                'callback' => array($this, 'get'),
                'permission_callback' => '__return_true',
                'args' => array(
                    'id' => array(
                        'validate_callback' => function ($param, $request, $key) {
                            return is_numeric($param);
                        },
                    ),
                ),
            )
        );

        register_rest_route(
            'api/v1/coupon',
            '/list',
            array(
                'methods' => 'GET',
                'callback' => array($this, 'list'),
                'permission_callback' => '__return_true',
                'args' => array(
                    'page' => array(
                        'validate_callback' => function ($param, $request, $key) {
                            return is_numeric($param);
                        },
                    ),
                    'per_page' => array(
                        'validate_callback' => function ($param, $request, $key) {
                            return is_numeric($param);
                        },
                    ),
                    'search_term' => array(
                        'validate_callback' => function ($param, $request, $key) {
                            return is_string($param);
                        },
                    ),
                ),
            )
        );
    }
}
