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
                'methods'  => WP_REST_Server::ALLMETHODS,
                'callback' => array( $this, 'getGuest' )
            ),
            'schema' => array( $this, 'get_public_item_schema' ),
        ) );

        register_rest_route( $this->namespace, '/employees-api', array(
            array(
                'methods'  => WP_REST_Server::READABLE,
                'callback' => array( $this, 'getEmployees' )
            ),
            'schema' => array( $this, 'get_public_item_schema' ),
        ) );

        register_rest_route( $this->namespace, '/edit-guest', array(
            array(
                'methods'  => WP_REST_Server::EDITABLE,
                'callback' => array( $this, 'editGuest' )
            ),
            'schema' => array( $this, 'get_public_item_schema' ),
        ) );
    }

    /**
     * get data guest register
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getGuest(){
        $DB = new DB();
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $dataGuest = $DB->table('guests')->orderByDesc('created_at')->paginate(50,['*'],'page',$page);
        return $dataGuest;
    }

    /**
     * get data employees register recruitment
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getEmployees(){
        $DB = new DB();
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        $dataGuest = $DB->table('employees')->orderByDesc('created_at')->paginate(50,['*'],'page',$page);
        return $dataGuest;
    }

    /**
     * @return array
     */
    public function editGuest(){
        $guestId = !empty($_REQUEST['guestId']) ? $_REQUEST['guestId'] : '';
        if (!empty($guestId)) {
            $DB = new  DB();
            $guest = $DB->table('guests')->find($guestId);
            if (!empty($guest->id)) {
                $guestNote = !empty($_REQUEST['guestNote']) ? $_REQUEST['guestNote'] : '' ;
                $guestStatus = !empty($_REQUEST['guestStatus']) ? $_REQUEST['guestStatus'] : '' ;
                $DB->table('guests')->where('id',$guest->id)->update([
                        'note' => $guestNote,
                        'status' => $guestStatus
                    ]);
                return [
                    'status' => 'success',
                    'message' => 'Update guest success'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Not found guest'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Empty id guest'
            ];
        }
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
