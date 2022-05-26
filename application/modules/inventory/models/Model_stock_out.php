<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_stock_out extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function dd_branch()
    {
        $query = $this->db->query("SELECT * FROM tblbranch");
        return $query;
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT *, CASE WHEN status = 0 THEN 'Draft' WHEN status = 1 THEN 'Final' END as strstatus FROM tblstock_out a INNER JOIN tblbranch b ON a.branch_id=b.branch_id");
        return $query;
	}
	
	public function get_by_id_master($id){
        $query = $this->db->query("SELECT * FROM tblstock_out WHERE stock_out_id='$id'");
        return $query->row();
    }
	
	public function get_by_id_detail($id){
        $query = $this->db->query("SELECT b.item_code, b.barcode, b.item_name, a.qty 
        FROM tblstock_out_det a INNER JOIN tblitem b ON a.item_id = b.item_id
         WHERE a.stock_out_id='$id'");
        return $query->result();
    }
}