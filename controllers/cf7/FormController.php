<?php

namespace Controllers\CF7;

use Models\CF7\FormModel;
use Plugins\Helpers\Pagination;
use WP_Error;

class FormController
{   
    private $formModel;

    private $number_of_records_per_page;
    
    private $paginationHelper;
    
    public function __construct()
    {
        $this->formModel = new FormModel();
        $this->paginationHelper = new Pagination();
        $this->number_of_records_per_page = $this->paginationHelper->getNumberofRecordsPerPage();
    }

    /**
     * CF7 forms.
     *
     * @return object $form CF7 form.
     */
    public function formByID($request)
    {   
        $id = $request["id"];

        $form =  $this->formModel->formByID($id);

        return rest_ensure_response($form); 
    }


    /**
     * CF7 forms.
     *
     * @return array $forms GF forms.
     */
    public function forms()
    {   
        $count = $this->formModel->mumberItems();

        $offset = 0;

        $forms =  $this->formModel->forms($offset, $this->number_of_records_per_page);

        $forms_results =  $this->paginationHelper->prepareDataForRestWithPagination($count, $forms);

        return rest_ensure_response($forms_results); 
    }

    /**
     * CF7 forms.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return array $forms CF7 forms.
     */
    public function formsPagination($request)
    {   
        $page = $request['page_number'];

        $count = $this->formModel->mumberItems();

        $offset = $this->paginationHelper->getOffset($page, $count);

        $forms =  $this->formModel->forms($offset, $this->number_of_records_per_page);

        $forms_results =  $this->paginationHelper->prepareDataForRestWithPagination($count, $forms);
 
        return rest_ensure_response($forms_results);
    }

    /**
     * CF7 forms.
     *
     * @param WP_REST_Request $request The request.
     * 
     * @return array $forms CF7 forms.
     */
    public function searchForms($request)
    {   
        $post_name = urldecode($request['post_name']);

        $count = $this->formModel->mumberItemsByPostTitle($post_name);

        $offset = $this->paginationHelper->getOffset(1, $count);
        
        $forms =  $this->formModel->searchForms($post_name, $offset, $this->number_of_records_per_page);

        $forms_results =  $this->paginationHelper->prepareDataForRestWithPagination($count, $forms);

        return rest_ensure_response($forms_results); 

    }
}
