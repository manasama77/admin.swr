<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_member_trans_report extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function dd_member()
    {
        $query = $this->db->query("SELECT * FROM tblmember");
        return $query;
    }
    
    function get_header($startperiod,$endperiod){
        $query = $this->db->query("SELECT '$startperiod' as startperiod, '$endperiod' as endperiod");
        return $query->row();
    }

	function get_report_array($startperiod,$endperiod,$memberid){
        $whereall = "";
        if($memberid >= 0){
            $whereall = $whereall . " AND b.member_id = '$memberid'";
        }

        $query = "SELECT a.member_code, a.fullname, a.limit_transaction, a.current_limit, b.sales_number, b.sales_date, b.total_transaction, b.created_date "
                . "FROM tblmember a LEFT JOIN tblsales b ON a.member_id = b.member_id "
                . "WHERE b.created_date>='$startperiod' AND b.created_date<='$endperiod' " . $whereall
                . "ORDER BY a.member_code, b.sales_number";
        $data = $this->db->query($query);
        return $data->result_array();
    }
    
	function get_report($startperiod,$endperiod,$memberid){
        $whereall = "";
        if($memberid >= 0){
            $whereall = $whereall . " AND b.member_id = '$memberid'";
        }

        $query = "SELECT a.member_code, a.fullname, a.limit_transaction, a.current_limit, b.sales_number, b.sales_date, b.total_transaction, b.created_date "
                . "FROM tblmember a LEFT JOIN tblsales b ON a.member_id = b.member_id "
                . "WHERE b.created_date>='$startperiod' AND b.created_date<='$endperiod' " . $whereall
                . "ORDER BY a.member_code, b.sales_number";
        $data = $this->db->query($query);
        return $data;
    }
}