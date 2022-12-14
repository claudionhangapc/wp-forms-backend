<?php

namespace Models;

use WP_Query;

class FormModel
{   
    public  $post_type ;
    
    public  $table_name ;

    public function __construct($post_type, $table_name="posts")
    {
        $this->post_type = $post_type;

        $this->table_name = $table_name;
    }

    /**
	 * Get Forms 
     * 
     * @return object
	 */
    public function forms($offset, $number_of_records_per_page)
    {   
        if($this->table_name !== "posts"){
            return $this->formsFromCustomTable($offset, $number_of_records_per_page); 
        } 

        $posts =   new WP_Query(array(
            'post_type'      => $this->post_type,
            'posts_per_page' => $number_of_records_per_page,
            'paged'          => $offset,
            'post_status'    => array( 'publish' ),
        ));

        return $posts;
    }

    /**
	 * Get Forms 
     * 
     * @return object
	 */
    public function formsFromCustomTable($offset, $number_of_records_per_page)
    {
        global $wpdb;
        
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.$this->table_name." ORDER BY id DESC LIMIT ".$offset.",".$number_of_records_per_page,OBJECT);

        return  $results;
    }

    /**
	 * Get Forms 
     * 
     * @return array
	 */

     public function searchForms($post_title, $offset, $number_of_records_per_page)
     {
        $posts =   new WP_Query(array(
             'post_type'      => $this->post_type,
             'posts_per_page' => $number_of_records_per_page,
             'paged'          => $offset,
             'post_status'    => array( 'publish' ),
             's'              => $post_title
         ));
 
         return $posts;
     }

     /**
	 * Get Form chanel by id
     * 
     * @return object
	 */
    public function formByChannel($channel)
    {   
        global $wpdb;
        $forms = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.$this->table_name." WHERE post_name = '$channel' ",OBJECT);
        
        if(count($forms) > 0){
            return $forms[0];
        }

        return $forms;
    }
    
    /**
	 * Get number of Forms 
     * 
     * @return int
	 */
    public function mumberItems()
    {   
        if($this->table_name !== "posts"){
            return $this->mumberItemsFromCustomTable(); 
        } 

        global $wpdb;

        $results = $wpdb->get_results("SELECT count(*) as number_of_rows FROM ".$wpdb->prefix.$this->table_name." WHERE post_type = '$this->post_type' AND post_status = 'publish' ");
        
        $number_of_rows = intval( $results[0]->number_of_rows );
        
        return $number_of_rows ;    
    }
    /**
	 * Get number of Forms 
     * 
     * @return int
	 */
    public function mumberItemsFromCustomTable()
    {   
        global $wpdb;
        
        $results = $wpdb->get_results("SELECT count(*)  as number_of_rows FROM ".$wpdb->prefix.$this->table_name."");
        
        $number_of_rows = intval( $results[0]->number_of_rows );
        
        return $number_of_rows ;    
    }

    /**
	 * Get Forms 
     * 
     * @return int
	 */
    public function mumberItemsByPostTitle($post_title)
    {   
        $posts =   new WP_Query(array(
            'post_type'      => $this->post_type,
            'post_status'    => array( 'publish' ),
            's'              => $post_title
        ));
        
        return  $posts->found_posts;
    }

    /**
	 * Get Form chanel by id
     * 
     * @return string
	 */
    public function formChanelByID($id)
    {   
        global $wpdb;
        
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.$this->table_name." WHERE id = $id ",OBJECT);
        
        if(count($results) > 0){
            return $results[0]->post_name;
        }
        return "";    
    }

    /**
	 * Get Form by id 
     * 
     * @param int     $id The form ID.
     * 
     * @return array
	 */
    public function formByID($id)
    {   
        global $wpdb;
       
        $results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.$this->table_name." WHERE id = $id ", OBJECT);

        return $results;
    }

}
