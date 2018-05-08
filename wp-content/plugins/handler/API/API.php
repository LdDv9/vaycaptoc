<?php
namespace VCT;


use WP_Error;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use WeDevs\ORM\Eloquent\Database as DB;


class API extends WP_REST_Controller {

    public static $_instance;

    public static function init()
    {
        if( !self::$_instance instanceof static)
        {
            self::$_instance = new static();
        }

        return self::$_instance;
    }


    public function __construct() {

        $this->namespace = 'wp/api/';
        add_action( 'rest_api_init', [ $this, "register_routes" ] );
    }

    public function register_routes() {
        register_rest_route( $this->namespace, '/guest-api', array(
            array(
                'methods'  => WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_guest' ),
                'args'     => array(
                    'access_token' => array(
                        'description' => __( 'Access Token of facebook' ),
                        'type'        => 'string',
                    ),
                ),
            ),
            'schema' => array( $this, 'get_public_item_schema' ),
        ) );
    }

    public function get_guest(){

        $DB = new DB();
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        $dataGuest = $DB->table('guests')->orderByDesc('created_at')->paginate(50,['*'],'page',$page);
        return $dataGuest;
    }

    /**
     * Create token jwt
     * @param $user
     *
     * @return mixed|void
     */
    public function generateToken( $user ) {
        /** Valid credentials, the user exists create the according Token */
        $issuedAt  = time();
        $notBefore = apply_filters( 'jwt_auth_not_before', $issuedAt, $issuedAt );
        $expire    = apply_filters( 'jwt_auth_expire', $issuedAt + ( DAY_IN_SECONDS * 7 ), $issuedAt );

        $token      = array(
            'iss'  => get_bloginfo( 'url' ),
            'iat'  => $issuedAt,
            'nbf'  => $notBefore,
            'exp'  => $expire,
            'data' => array(
                'user' => array(
                    'id' => $user->data->ID,
                ),
            ),
        );
        $secret_key = defined( 'JWT_AUTH_SECRET_KEY' ) ? JWT_AUTH_SECRET_KEY : false;
        /** Let the user modify the token data before the sign. */
        $token = JWT::encode( apply_filters( 'jwt_auth_token_before_sign', $token, $user ), $secret_key );

        /** The token is signed, now create the object with no sensible user data to the client*/
        $data = array(
            'token'             => $token,
            'user_email'        => $user->data->user_email,
            'user_nicename'     => $user->data->user_nicename,
            'user_display_name' => $user->data->display_name,
        );

        /** Let the user modify the data before send it back */
        return apply_filters( 'jwt_auth_token_before_dispatch', $data, $user );
    }

    /**
     * Refresh token by token old jwt
     *
     * @param WP_REST_Request $request Full details about the request.
     * @var $user WP_Error
     * @return array|WP_Error|WP_REST_Response
     */
    public function refresh_token( $request ) {
        if ( empty( $request['token'] ) ) {
            return [ 'status' => 'error', 'code' => 'token_empty' ];
        }

        $token = $request['token'];

        $arrToken = explode( '.', $token );

        $sDataUser = json_decode( base64_decode( $arrToken[1] ), 1 );

        $user_id = $sDataUser['data']['user']['id'];

        $user = get_user_by( 'id', $user_id );

        /** If the authentication fails return a error*/
        if ( is_wp_error( $user ) ) {
            /** @var $user WP_Error*/
            $error_code = $user->get_error_code();

            return new WP_Error(
                '[jwt_auth] ' . $error_code,
                $user->get_error_message( $error_code ),
                array(
                    'status' => 403,
                )
            );
        }

        /** Valid credentials, the user exists create the according Token */
        $issuedAt  = time();
        $notBefore = apply_filters( 'jwt_auth_not_before', $issuedAt, $issuedAt );
        $expire    = apply_filters( 'jwt_auth_expire', $issuedAt + ( DAY_IN_SECONDS * 7 ), $issuedAt );

        $token      = array(
            'iss'  => get_bloginfo( 'url' ),
            'iat'  => $issuedAt,
            'nbf'  => $notBefore,
            'exp'  => $expire,
            'data' => array(
                'user' => array(
                    'id' => $user->data->ID,
                ),
            ),
        );
        $secret_key = defined( 'JWT_AUTH_SECRET_KEY' ) ? JWT_AUTH_SECRET_KEY : false;
        /** Let the user modify the token data before the sign. */
        $token = JWT::encode( apply_filters( 'jwt_auth_token_before_sign', $token, $user ), $secret_key );

        /** The token is signed, now create the object with no sensible user data to the client*/
        $data = array(
            'token'             => $token,
            'user_email'        => $user->data->user_email,
            'user_nicename'     => $user->data->user_nicename,
            'user_display_name' => $user->data->display_name,
        );

        /** Let the user modify the data before send it back */
        return apply_filters( 'jwt_auth_token_before_dispatch', $data, $user );

    }

}
