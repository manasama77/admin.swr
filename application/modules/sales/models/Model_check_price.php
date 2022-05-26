<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_check_price extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function dd_item()
    {
        $query = $this->db->query("SELECT * FROM tblitem order by item_name");
        return $query;
    }
    
    function search_price($branchid,$itemid)
    {
        $query_exist1 = $this->db->query("SELECT count(0) as is_exist FROM tblitem_price WHERE item_id = '$itemid' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        $data_exist1 = $query_exist1->row_array();
        $is_exist1 = $data_exist1['is_exist'];

        if($is_exist1 > 0){
            $query = $this->db->query("SELECT start_period, selling_price FROM tblitem_price WHERE item_id = '$itemid' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') ORDER BY start_period desc LIMIT 1");
        }
        else{
            $query = $this->db->query("SELECT '' as start_period, 0 as selling_price ");
        }
            
        return $query->row_array();
    }
    
}