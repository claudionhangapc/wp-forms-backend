<?php

namespace Controllers\GF;

use Models\GF\EntryModel;
use Plugins\Helpers\Pagination;
use WP_Error;

class EntryController
{   
    private $entryModel;

    private $number_of_records_per_page;

    public function __construct()
    {
        $this->entryModel = new EntryModel();
        $this->paginationHelper = new Pagination();
        $this->number_of_records_per_page = $this->paginationHelper->getNumberofRecordsPerPage();
    }

    /**
     * GF forms entry.
     *
     * @return array $forms GF forms.
     */
    public function entries()
    {   
        $count = $this->entryModel->mumberItems();

        $offset = 0;

        $entries =  $this->entryModel->entries($offset, $this->number_of_records_per_page);
        
        $entries_results = $this->paginationHelper->prepareDataForRestWithPagination($count, $entries);
 
        return rest_ensure_response($entries_results);
    }

    /**
     * GF forms entry.
     *
     * @return array $forms GF forms.
     */
    public function entryByID($request)
    {   
        $entry_id = $request['entry_id'];
        $entry =  $this->entryModel->entryByID($entry_id);
        return rest_ensure_response($entry);

    }

    /**
     * GF forms entries by id.
     *
     * @return array $forms GF forms.
     */
    public function entriesByFormID($request)
    {   
        $form_id = $request['form_id'];
        
        $page = $request['page_number'];

        $count = $this->entryModel->mumberItemsByFormID($form_id);
        
        $offset = $this->paginationHelper->getOffset($page, $count);

        $entries = $this->entryModel->entriesByFormID($form_id, $offset, $this->number_of_records_per_page);

        $entries_results = $this->paginationHelper->prepareDataForRestWithPagination($count, $entries);

        return rest_ensure_response($entries_results);
    }

    
}
