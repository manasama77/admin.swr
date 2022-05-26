<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_summary_sales_report extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function dd_user()
    {
        $query = $this->db->query("SELECT * FROM tbluser a INNER JOIN tbluser_group b ON a.user_group_id=b.user_group_id WHERE b.is_cashier=1");
        return $query;
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

    function get_header($startperiod, $endperiod)
    {
        $query = $this->db->query("SELECT '$startperiod' as startperiod, '$endperiod' as endperiod");
        return $query->row();
    }

    function get_report_array($startperiod, $endperiod, $userid, $branchid)
    {
        $whereall = "";
        if ($userid > 0) {
            $whereall = $whereall . " AND a.creator_id = '$userid'";
        }

        if ($branchid > 0) {
            $whereall = $whereall . " AND a.branch_id = '$branchid'";
        }

        $query = "SELECT * FROM ( "
            . "SELECT a.branch_id, b.fullname as cashier_name, a.sales_number, a.created_date as sales_date, c.branch_code, c.branch_name, a.total_price, a.total_disc, a.total_transaction "
            . "FROM tblsales a LEFT JOIN tbluser b ON a.creator_id = b.user_id "
            . "LEFT JOIN tblbranch c ON a.branch_id = c.branch_id "
            . "WHERE DATE(a.created_date) >='$startperiod' AND DATE(a.created_date)<='$endperiod' " . $whereall
            . "UNION ALL "
            . "SELECT a.branch_id, b.fullname as cashier_name, a.sales_exchange_number as sales_number, a.created_date as sales_date, c.branch_code, c.branch_name, a.total_transaction as total_price, 0 as total_disc, a.total_transaction "
            . "FROM tblsales_exchange a LEFT JOIN tbluser b ON a.creator_id = b.user_id "
            . "LEFT JOIN tblbranch c ON a.branch_id = c.branch_id "
            . "WHERE DATE(a.created_date) >='$startperiod' AND DATE(a.created_date) <='$endperiod' " . $whereall
            . ") a ORDER BY branch_id, sales_date";
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function get_report($startperiod, $endperiod, $userid, $branchid)
    {
        $whereall = "";
        if ($userid > 0) {
            $whereall = $whereall . " AND b.user_id = '$userid'";
        }

        if ($branchid > 0) {
            $whereall = $whereall . " AND a.branch_id = '$branchid'";
        }

        $query = "SELECT * FROM ( "
            . "SELECT a.branch_id, b.fullname as cashier_name, a.sales_number, a.created_date as sales_date, c.branch_code, c.branch_name, a.total_price, a.total_disc, a.total_transaction "
            . "FROM tblsales a LEFT JOIN tbluser b ON a.creator_id = b.user_id "
            . "LEFT JOIN tblbranch c ON a.branch_id = c.branch_id "
            . "WHERE DATE(a.created_date)>='$startperiod' AND DATE(a.created_date)<='$endperiod' " . $whereall
            . "UNION ALL "
            . "SELECT a.branch_id, b.fullname as cashier_name, a.sales_exchange_number as sales_number, a.created_date as sales_date, c.branch_code, c.branch_name, a.total_transaction as total_price, 0 as total_disc, a.total_transaction "
            . "FROM tblsales_exchange a LEFT JOIN tbluser b ON a.creator_id = b.user_id "
            . "LEFT JOIN tblbranch c ON a.branch_id = c.branch_id "
            . "WHERE DATE(a.created_date)>='$startperiod' AND DATE(a.created_date)<='$endperiod' " . $whereall
            . ") a ORDER BY branch_id, sales_date";
        $data = $this->db->query($query);
        return $data;
    }
}
