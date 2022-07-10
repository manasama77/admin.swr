<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_detail_recap_stock_report extends CI_Model
{

    public function __construct()
    {
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

    function get_header($startperiod, $endperiod)
    {
        $query = $this->db->query("SELECT '$startperiod' as startperiod, '$endperiod' as endperiod");
        return $query->row();
    }

    function get_report_array($startperiod, $endperiod, $branchid, $itemid)
    {
        $where = "";
        if ($itemid > 0) {
            $where = " WHERE a.item_id = '$itemid'";
        }

        if ($branchid > 0) {
            if ($where != "") {
                $where = $where . " AND a.branch_id = '$branchid'";
            } else {
                $where = " WHERE a.branch_id = '$branchid'";
            }
        }

        $query = "SELECT * FROM ( "
            . "SELECT a.branch_id, a.branch_code, a.branch_name, DATE_FORMAT('$startperiod', '%Y-%m-%d %T') as created_date, a.barcode, a.item_id, a.item_code, a.item_name, 'Stok Awal' as trans_type, '' as doc_number, IFNULL(b.begining_qty_in,0)-IFNULL(c.begining_qty_out,0)+IFNULL(d.begining_qty_adj,0) as qty "
            . "FROM ( "
            . "SELECT b.item_id, b.barcode, b.item_code, b.item_name, a.branch_id, a.branch_code, a.branch_name "
            . "FROM tblitem b "
            . "CROSS JOIN tblbranch a "
            . ") a "
            . "LEFT JOIN ( "
            . "SELECT a.branch_id, b.item_id, SUM(b.qty) as begining_qty_in "
            . "FROM tblstock_in a INNER JOIN tblstock_in_det b ON a.stock_in_id = b.stock_in_id "
            . "WHERE a.status = 1 AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<'$startperiod' "
            . "GROUP BY a.branch_id, b.item_id "
            . ") b ON a.item_id = b.item_id AND a.branch_id = b.branch_id "
            . "LEFT JOIN ( "
            . "SELECT a.branch_id, b.item_id, SUM(b.qty) as begining_qty_out "
            . "FROM tblstock_out a INNER JOIN tblstock_out_det b ON a.stock_out_id = b.stock_out_id "
            . "WHERE a.status = 1 AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<'$startperiod' "
            . "GROUP BY a.branch_id, b.item_id "
            . ") c ON a.item_id = c.item_id AND a.branch_id = c.branch_id "
            . "LEFT JOIN ( "
            . "SELECT b.branch_id, b.item_id, SUM(case when b.adj_type = 1 then b.adj_number when b.adj_type = 2 then b.adj_number*(-1) end) as begining_qty_adj "
            . "FROM tblstock_adj b "
            . "WHERE DATE_FORMAT(b.created_date,'%Y-%m-%d')<'$startperiod' "
            . "GROUP BY b.branch_id, b.item_id "
            . ") d ON a.item_id = d.item_id AND a.branch_id = d.branch_id "
            . "UNION ALL "
            . "SELECT d.branch_id, d.branch_code, d.branch_name, a.created_date, c.barcode, c.item_id, c.item_code, c.item_name, 'Stok Masuk' as trans_type, a.doc_number, b.qty "
            . "FROM tblstock_in a INNER JOIN tblstock_in_det b ON a.stock_in_id = b.stock_in_id "
            . "INNER JOIN tblitem c ON b.item_id = c.item_id "
            . "INNER JOIN tblbranch d ON a.branch_id = d.branch_id "
            . "WHERE a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' AND a.status = 1 "
            . "UNION ALL "
            . "SELECT d.branch_id, d.branch_code, d.branch_name, a.created_date, c.barcode, c.item_id, c.item_code, c.item_name, 'Stok Keluar' as trans_type, a.doc_number, (-1)*b.qty "
            . "FROM tblstock_out a INNER JOIN tblstock_out_det b ON a.stock_out_id = b.stock_out_id "
            . "INNER JOIN tblitem c ON b.item_id = c.item_id "
            . "INNER JOIN tblbranch d ON a.branch_id = d.branch_id "
            . "WHERE a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' AND a.status = 1 "
            . "UNION ALL "
            . "SELECT c.branch_id, c.branch_code, c.branch_name, b.created_date, a.barcode, a.item_id, a.item_code, a.item_name, 'Penyesuaian Stok' as trans_type, '' as doc_number, CASE WHEN b.adj_type = 1 THEN b.adj_number WHEN b.adj_type = 2 THEN (-1)*b.adj_number END as qty "
            . "FROM tblitem a INNER JOIN tblstock_adj b ON a.item_id = b.item_id AND b.adj_type = 1 "
            . "INNER JOIN tblbranch c ON b.branch_id = c.branch_id "
            . "WHERE b.created_date>='$startperiod' AND DATE_FORMAT(b.created_date,'%Y-%m-%d')<='$endperiod' "
            . ") a " . $where . " ORDER BY a.branch_name, a.item_code, a.created_date";
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function get_report($startperiod, $endperiod, $branchid, $itemid)
    {

        $whereall0 = "";
        if ($itemid > 0) {
            $whereall0 = $whereall0 . " AND b.item_id = '$itemid' ";
        }

        if ($branchid > 0) {
            $whereall0 = $whereall0 . " AND a.branch_id = '$branchid'";
        }

        $whereall1 = "";
        if ($itemid > 0) {
            $whereall1 = $whereall1 . " AND b.item_id = '$itemid' ";
        }

        if ($branchid > 0) {
            $whereall1 = $whereall1 . " AND b.branch_id = '$branchid'";
        }

        $query = "SELECT * FROM ( "
            . "SELECT a.branch_code, a.branch_name, DATE_FORMAT('$startperiod', '%Y-%m-%d %T') as created_date, a.barcode, a.item_code, a.item_name, 'Stok Awal' as trans_type, '' as doc_number, IFNULL(b.begining_qty_in,0)-IFNULL(c.begining_qty_out,0)+IFNULL(d.begining_qty_adj,0) as qty "
            . "FROM ( "
            . "SELECT b.item_id, b.barcode, b.item_code, b.item_name, a.branch_id, a.branch_code, a.branch_name "
            . "FROM tblitem b "
            . "CROSS JOIN tblbranch a "
            . ") a "
            . "LEFT JOIN ( "
            . "SELECT a.branch_id, b.item_id, SUM(b.qty) as begining_qty_in "
            . "FROM tblstock_in a INNER JOIN tblstock_in_det b ON a.stock_in_id = b.stock_in_id "
            . "WHERE a.status = 1 AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<'$startperiod' " . $whereall0
            . "GROUP BY a.branch_id, b.item_id "
            . ") b ON a.item_id = b.item_id AND a.branch_id = b.branch_id "
            . "LEFT JOIN ( "
            . "SELECT a.branch_id, b.item_id, SUM(b.qty) as begining_qty_out "
            . "FROM tblstock_out a INNER JOIN tblstock_out_det b ON a.stock_out_id = b.stock_out_id "
            . "WHERE a.status = 1 AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<'$startperiod' " . $whereall0
            . "GROUP BY a.branch_id, b.item_id "
            . ") c ON a.item_id = c.item_id AND a.branch_id = c.branch_id "
            . "LEFT JOIN ( "
            . "SELECT b.branch_id, b.item_id, SUM(case when b.adj_type = 1 then b.adj_number when b.adj_type = 2 then b.adj_number*(-1) end) as begining_qty_adj "
            . "FROM tblstock_adj b "
            . "WHERE DATE_FORMAT(b.created_date,'%Y-%m-%d')<'$startperiod' " . $whereall1
            . "GROUP BY b.branch_id, b.item_id "
            . ") d ON a.item_id = d.item_id AND a.branch_id = d.branch_id "
            . "UNION ALL "
            . "SELECT d.branch_code, d.branch_name, a.created_date, c.barcode, c.item_code, c.item_name, 'Stok Masuk' as trans_type, a.doc_number, b.qty "
            . "FROM tblstock_in a INNER JOIN tblstock_in_det b ON a.stock_in_id = b.stock_in_id "
            . "INNER JOIN tblitem c ON b.item_id = c.item_id "
            . "INNER JOIN tblbranch d ON a.branch_id = d.branch_id "
            . "WHERE a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' AND a.status = 1 " . $whereall0
            . "UNION ALL "
            . "SELECT d.branch_code, d.branch_name, a.created_date, c.barcode, c.item_code, c.item_name, 'Stok Keluar' as trans_type, a.doc_number, (-1)*b.qty "
            . "FROM tblstock_out a INNER JOIN tblstock_out_det b ON a.stock_out_id = b.stock_out_id "
            . "INNER JOIN tblitem c ON b.item_id = c.item_id "
            . "INNER JOIN tblbranch d ON a.branch_id = d.branch_id "
            . "WHERE a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' AND a.status = 1 " . $whereall0
            . "UNION ALL "
            . "SELECT c.branch_code, c.branch_name, b.created_date, a.barcode, a.item_code, a.item_name, 'Penyesuaian Stok' as trans_type, '' as doc_number, CASE WHEN b.adj_type = 1 THEN b.adj_number WHEN b.adj_type = 2 THEN (-1)*b.adj_number END as qty "
            . "FROM tblitem a INNER JOIN tblstock_adj b ON a.item_id = b.item_id AND b.adj_type = 1 "
            . "INNER JOIN tblbranch c ON b.branch_id = c.branch_id "
            . "WHERE b.created_date>='$startperiod' AND DATE_FORMAT(b.created_date,'%Y-%m-%d')<='$endperiod' " . $whereall1
            . ") a ORDER BY a.branch_name, a.item_code, a.created_date";
        $data = $this->db->query($query);
        return $data;
    }
}
