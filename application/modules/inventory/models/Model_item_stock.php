<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_item_stock extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT * FROM tblitem_stock a 
        INNER JOIN tblbranch b ON a.branch_id=b.branch_id 
        INNER JOIN tblitem c ON a.item_id=c.item_id
        INNER JOIN tblstock_category d ON c.stock_category_id=d.stock_category_id
        INNER JOIN tblunit e ON c.unit_id=e.unit_id");
        return $query;
	}
	
}