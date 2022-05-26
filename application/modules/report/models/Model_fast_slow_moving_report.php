<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_fast_slow_moving_report extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function dd_branch()
    {
        $query = $this->db->query("SELECT 0 as branch_id, 'Semua Cabang' as branch_code, '' as branch_name UNION ALL SELECT branch_id, branch_code, branch_name FROM tblbranch");
        return $query;
    }
    
    function dd_branch_only($id)
    {
        $query = $this->db->query("SELECT * FROM tblbranch where branch_id='$id'");
        return $query;
    }
    
    function dd_item()
    {
        $query = $this->db->query("SELECT * FROM tblitem");
        return $query;
    }
    
    function get_header($startperiod,$endperiod){
        $query = $this->db->query("SELECT '$startperiod' as startperiod, '$endperiod' as endperiod");
        return $query->row();
    }

	function get_report_array($startperiod,$endperiod,$branchid,$itemid){
        $whereall = "";
        if($itemid > 0){
            $whereall = $whereall . " WHERE a.item_id = '$itemid' ";
        }

        $query = "SELECT b.item_name,  "
                . "FROM tblsales_det a inner join tblitem b on a.item_id=b.item_id "
                . "left join tblstock_flow c on  "
                . $whereall
                . "order by b.stock_category_name, a.barcode";
        $data = $this->db->query($query);
        return $data->result_array();
    }
    
	function get_report($startperiod,$endperiod,$branchid,$itemid){
        $whereall = "";
        if($itemid > 0){
            $whereall = $whereall . " WHERE a.item_id = '$itemid' ";
        }

        $query = "SELECT b.stock_category_name, a.barcode, a.item_name, c.unit_code, a.total_qty, "
                . "d.public_price, 0 as disc, 0 as tax, (a.total_qty*d.public_price) as total "
                . "FROM tblitem a inner join tblstock_category b on a.stock_category_id = b.stock_category_id "
                . "inner join tblunit c on a.unit_id = c.unit_id "
                . "inner join tblitem_price d on a.item_id = d.item_id and d.start_period<= '$startperiod' and d.end_period >= '$endperiod' "
                . $whereall
                . "order by b.stock_category_name, a.barcode";
        $data = $this->db->query($query);
        return $data;
    }
}