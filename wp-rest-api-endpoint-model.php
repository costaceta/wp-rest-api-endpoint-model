<?php

/**
 * Configure REST API Endpoint
 *
 * @package {package name here}
 */

if (!defined('ABSPATH')) {
    exit();
}

add_action('rest_api_init', function () {
    register_rest_route('api/v1', '/{my-route}', array(
        'methods'  => 'POST', // GET, POST
        'callback' => 'rest_get_data',
        'permission_callback' => function () {
            return current_user_can('read');
        }
    ));
});

function rest_get_data(WP_REST_Request $request)
{

    // Fields
    $nonce = $request->get_param("nonce");

    try {

        // Validate fields
        if (!wp_verify_nonce($nonce, 'wp_rest'))
            throw new Exception("seção inválida! recarregue a página ou logue novamente.");

        // Here put your logic

        // Return data if success
        $response = [
            'res'  => true,
            'msg'  => 'success to get data!',
            'data' => [],
        ];
    } catch (Exception $e) {

        // Return data if success
        $response = [
            'res' => false,
            'msg' => $e->getMessage(),
        ];
    }

    return new WP_REST_Response($response, 200);
}
