<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_sales_hist extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

	public function get_all(){
        $query = $this->db->query("SELECT DISTINCT b.branch_name, d.fullname as cashier_name, a.sales_id, a.sales_number, a.created_date as sales_date, a.total_price, a.total_disc, a.total_transaction, case when a.payment_type=1 then 'Tunai' when a.payment_type=2 then 'Kartu Debit' when a.payment_type=3 then 'Kartu Kredit' when a.payment_type=4 then 'Transfer' end as payment_type
        FROM tblsales a LEFT JOIN tblbranch b ON a.branch_id=b.branch_id LEFT JOIN tbluser d ON a.creator_id=d.user_id");
        return $query;
	}
	
    function get_by_id_master($salesnumber){
        $query = $this->db->query("SELECT b.branch_name, c.fullname as cashier, a.sales_number, a.created_date as sales_date, a.total_price, a.total_disc, a.total_transaction, 
        case when a.payment_type=1 then 'Tunai' when a.payment_type=2 then 'Kartu Debit' when a.payment_type=3 then 'Kartu Kredit' when a.payment_type=4 then 'Transfer' end as payment_type, CONCAT('(',IFNULL(d.bank_code,''),') ',IFNULL(d.bank_name,'')) as bank, a.card_holder, a.card_number, a.payment, a.exchange, a.notes
        FROM tblsales a LEFT JOIN tblbranch b ON a.branch_id=b.branch_id LEFT JOIN tbluser c ON a.creator_id=c.user_id LEFT JOIN tblbank d ON a.bank_id=d.bank_id
        WHERE a.sales_number='$salesnumber'");
        return $query->row_array();
    }

	function get_by_id_detail($salesnumber){
        $query = $this->db->query("SELECT c.item_name, b.price, b.disc, b.extra_disc, b.qty, b.subtotal 
        FROM tblsales a INNER JOIN tblsales_det b ON a.sales_id=b.sales_id INNER JOIN tblitem c ON b.item_id=c.item_id WHERE a.sales_number='$salesnumber'");
        return $query->result_array();
    }
	
    function get_header($salesnumber){
        $query = $this->db->query("SELECT a.sales_number, a.created_date as sales_date, a.total_price, a.total_disc, a.total_transaction, case when a.payment_type=1 then 'TUNAI' when a.payment_type=1 then 'DEBIT' when a.payment_type=1 then 'KARTU KREDIT' when a.payment_type=4 then 'Transfer' end as payment_type, a.payment, a.exchange, b.branch_name, b.branch_address, c.fullname as cashier_name
        FROM tblsales a LEFT JOIN tblbranch b ON a.branch_id=b.branch_id LEFT JOIN tbluser c ON a.creator_id=c.user_id WHERE a.sales_number='$salesnumber'");
        return $query->row();
    }

	function get_report($salesnumber){
        $query = $this->db->query("SELECT c.item_name, b.price, (b.disc+b.extra_disc)*b.qty as disc, b.qty, (b.price * b.qty) as subtotal 
        FROM tblsales a INNER JOIN tblsales_det b ON a.sales_id=b.sales_id INNER JOIN tblitem c ON b.item_id=c.item_id WHERE a.sales_number='$salesnumber'");
        return $query;
    }
}