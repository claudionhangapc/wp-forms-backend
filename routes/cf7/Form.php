<?php

namespace Routes\CF7;

use Controllers\CF7\FormController;


class Form
{

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
	 * get all forms.
	 */
    public function forms()
    {
        register_rest_route(
            $this->name,
            '/cf7/forms',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new FormController, 'forms'),
                    'permission_callback' => '__return_true',
                ),
            )
        );
    }

    /**
	 * get forms by pagination.
	 */
    public function formsPagination()
    {
        register_rest_route(
            $this->name,
            '/cf7/forms/page/(?P<page_number>[0-9]+)',
            array(
                array(
                    'methods' => 'GET',
                    'callback' => array(new FormController, 'formsPagination'),
                    'permission_callback' => '__return_true',
                ),
            )
        );
    }


    /**
	 * Call all endpoints
	 */
    public function initRoutes()
    {
        $this->forms();
        $this->formsPagination();
    }

}