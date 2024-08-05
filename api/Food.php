<?php

namespace ReviewApi;

final class Food extends \ReviewApi\Request implements \Review\Interface\ApiInterface
{

    function getFieldValidator() : string
    {
        return "alimento_id";
    }
    function create(\WP_REST_Request $request)
    {
        $auth_result = $this->authenticate($request);
        if (is_wp_error($auth_result)) {
            return $auth_result;
        }

        if ($request->has_param($this->getFieldValidator())) :
            return $this->createFood($request);
        endif;
    }

    private function createFood(\WP_REST_Request $request)
    {
        $args = array(
            'post_type' => \Review\WordPress\CustomPostType\Foods::getKey(),
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
        $fields = (new \Review\WordPress\Fields\Foods())->fields();
        foreach ($fields as $field) :
            $meta_input[$field->getId()] = $request->get_param($field->getId()) ?? null;
        endforeach;

        $post_title = $request->get_param('title');
        $post_title = strtr($post_title, ['.' => '', '  ' => ' ']);
        $post_excerpt = $request->get_param('description');
        $post_excerpt = strtr($post_excerpt, ['.' => '', '  ' => ' ']);

        $user = get_user_by('login', 'weslley');
        $post_author = $user->ID;

        $data = array(
            'post_type' => \Review\WordPress\CustomPostType\Foods::getKey(),
            'post_title' => $post_title,
            'post_excerpt' => $post_excerpt,
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
            return rest_ensure_response(["Food #{$post_id} - {$post_title} {$statusMsg} com sucesso!"]);
        } else {
            $statusMsg = $isNewRegister ? 'criar' : 'atualizar';
            return rest_ensure_response(new \WP_REST_Response('Erro ao {$statusMsg} Food: ' . $post_id->get_error_message(), 500));
        }
    }

    function get(\WP_REST_Request $request)
    {
        $auth_result = $this->authenticate($request);
        if (is_wp_error($auth_result)) {
            return $auth_result;
        }

        $post_id = $request->get_param('id');
        $food = (new \Review\Repository\Food())->getById($post_id);
        return rest_ensure_response($food);
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
        $auth_result = $this->authenticate($request);
        if (is_wp_error($auth_result)) {
            return $auth_result;
        }

        $args = array(
            'post_type' => \Review\WordPress\CustomPostType\Foods::getKey(),
            'posts_per_page' => 1,
        );

        $posts_query = new \WP_Query($args);

        if ($posts_query->have_posts()) {
            while ($posts_query->have_posts()) {
                $posts_query->the_post();
                $post_id = get_the_ID();
                wp_delete_post($post_id, true);
                wp_reset_postdata();
            }

            wp_reset_query();

            return rest_ensure_response('Todos os posts foram removidos com sucesso.');
        } else {
            return rest_ensure_response('Nenhum post encontrado para remover.');
        }
    }

    public function RestApiInit()
    {
        register_rest_route(
            'api/v1/food',
            '/add',
            array(
                'methods' => 'POST',
                'callback' => array($this, 'create'),
                'permission_callback' => '__return_true',
            )
        );

        register_rest_route(
            'api/v1/food',
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
            'api/v1/food',
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

        register_rest_route(
            'api/v1/food',
            '/delete',
            array(
                'methods' => 'GET',
                'callback' => array($this, 'delete'),
                'permission_callback' => '__return_true',
            )
        );
    }
}
