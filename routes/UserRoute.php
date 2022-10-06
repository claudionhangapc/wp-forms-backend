<?php

namespace Routes;

use Controllers\UserController;
use Schema\UserSchema;
use WP_Error;

class UserRoute
{

    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /*
     *
     */

    public function login()
    {

        register_rest_route(
            $this->name,
            '/user/login',
            array(
                array(
                    'methods' => 'POST',
                    'callback' => array(new UserController, 'login'),
                    'permission_callback' => '__return_true',
                    'args' => (new UserSchema())->login(),
                ),

            )
        );

    }

    public function user()
    {

        register_rest_route(
            $this->name,
            '/user',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new UserController, 'user'),
                    'permission_callback' => '__return_true',
                ),

            )
        );

    }

    /*
     *
     */

    public function initRoutes()
    {
        $this->login();
        $this->user();
    }

}