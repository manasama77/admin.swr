<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_summary_recap_stock_report extends CI_Model
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
        $whereall = "";
        if ($itemid > 0) {
            $whereall = " WHERE a.item_id = '$itemid'";
        }

        if ($branchid > 0) {
            if (strlen($whereall) > 0) {
                $whereall = $whereall . " AND a.branch_id = '$branchid'";
            } else {
                $whereall = $whereall . " WHERE a.branch_id = '$branchid'";
            }
        }

        $query = "SELECT a.stock_category_name, a.item_id, a.barcode, a.item_code, a.item_name, a.branch_id, a.branch_code, a.branch_name, IFNULL(b.begining_qty_in,0)-IFNULL(c.begining_qty_out,0)+IFNULL(d.begining_qty_adj,0) as begining_qty, "
            . "IFNULL(e.qty_in,0)+IFNULL(g.qty_adj_plus,0) as stock_in, IFNULL(f.qty_out,0)+IFNULL(h.qty_adj_minus,0) as stock_out, "
            . "(IFNULL(b.begining_qty_in,0)+IFNULL(c.begining_qty_out,0)+IFNULL(d.begining_qty_adj,0))+(IFNULL(e.qty_in,0)+IFNULL(g.qty_adj_plus,0))-(IFNULL(f.qty_out,0)+IFNULL(h.qty_adj_minus,0)) as total_qty "
            . "FROM ( "
            . "SELECT b.stock_category_name, a.item_id, a.barcode, a.item_code, a.item_name, c.branch_id, c.branch_code, c.branch_name "
            . "FROM tblitem a "
            . "INNER JOIN tblstock_category b ON a.stock_category_id = b.stock_category_id "
            . "CROSS JOIN tblbranch c "
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
            . "SELECT branch_id, item_id, SUM(case when adj_type = 1 then adj_number when adj_type = 2 then adj_number*(-1) end) as begining_qty_adj "
            . "FROM tblstock_adj "
            . "WHERE DATE_FORMAT(created_date,'%Y-%m-%d')<'$startperiod' "
            . "GROUP BY branch_id, item_id "
            . ") d ON a.item_id = d.item_id AND a.branch_id = d.branch_id "
            . "LEFT JOIN ( "
            . "SELECT a.branch_id, b.item_id, SUM(b.qty) as qty_in "
            . "FROM tblstock_in a INNER JOIN tblstock_in_det b ON a.stock_in_id = b.stock_in_id "
            . "WHERE a.status = 1 AND a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' "
            . "GROUP BY a.branch_id, b.item_id "
            . ") e ON a.item_id = e.item_id AND a.branch_id = e.branch_id "
            . "LEFT JOIN ( "
            . "SELECT a.branch_id, b.item_id, SUM(b.qty) as qty_out "
            . "FROM tblstock_out a INNER JOIN tblstock_out_det b ON a.stock_out_id = b.stock_out_id "
            . "WHERE a.status = 1 AND a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' "
            . "GROUP BY a.branch_id, b.item_id "
            . ") f ON a.item_id = f.item_id AND a.branch_id = f.branch_id "
            . "LEFT JOIN ( "
            . "SELECT branch_id, item_id, SUM(adj_number) as qty_adj_plus "
            . "FROM tblstock_adj "
            . "WHERE adj_type = 1 AND created_date>='$startperiod' AND DATE_FORMAT(created_date,'%Y-%m-%d')<='$endperiod' "
            . "GROUP BY branch_id, item_id "
            . ") g ON a.item_id = g.item_id AND a.branch_id = g.branch_id "
            . "LEFT JOIN ( "
            . "SELECT branch_id, item_id, SUM(adj_number) as qty_adj_minus "
            . "FROM tblstock_adj "
            . "WHERE adj_type = 2 AND created_date>='$startperiod' AND DATE_FORMAT(created_date,'%Y-%m-%d')<='$endperiod' "
            . "GROUP BY branch_id, item_id "
            . ") h ON a.item_id = h.item_id AND a.branch_id = h.branch_id "
            . $whereall
            . "ORDER BY a.stock_category_name, a.item_code, a.branch_name";
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function get_report($startperiod, $endperiod, $branchid, $itemid)
    {
        $whereall = "";
        if ($itemid > 0) {
            $whereall = " WHERE a.item_id = '$itemid'";
        }

        if ($branchid > 0) {
            if (strlen($whereall) > 0) {
                $whereall = $whereall . " AND a.branch_id = '$branchid'";
            } else {
                $whereall = $whereall . " WHERE a.branch_id = '$branchid'";
            }
        }

        $query = "SELECT a.stock_category_name, a.item_id, a.barcode, a.item_code, a.item_name, a.branch_id, a.branch_code, a.branch_name, IFNULL(b.begining_qty_in,0)-IFNULL(c.begining_qty_out,0)+IFNULL(d.begining_qty_adj,0) as begining_qty, "
            . "IFNULL(e.qty_in,0)+IFNULL(g.qty_adj_plus,0) as stock_in, IFNULL(f.qty_out,0)+IFNULL(h.qty_adj_minus,0) as stock_out, "
            . "(IFNULL(b.begining_qty_in,0)+IFNULL(c.begining_qty_out,0)+IFNULL(d.begining_qty_adj,0))+(IFNULL(e.qty_in,0)+IFNULL(g.qty_adj_plus,0))-(IFNULL(f.qty_out,0)+IFNULL(h.qty_adj_minus,0)) as total_qty "
            . "FROM ( "
            . "SELECT b.stock_category_name, a.item_id, a.barcode, a.item_code, a.item_name, c.branch_id, c.branch_code, c.branch_name "
            . "FROM tblitem a "
            . "INNER JOIN tblstock_category b ON a.stock_category_id = b.stock_category_id "
            . "CROSS JOIN tblbranch c "
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
            . "SELECT branch_id, item_id, SUM(case when adj_type = 1 then adj_number when adj_type = 2 then adj_number*(-1) end) as begining_qty_adj "
            . "FROM tblstock_adj "
            . "WHERE DATE_FORMAT(created_date,'%Y-%m-%d')<'$startperiod' "
            . "GROUP BY branch_id, item_id "
            . ") d ON a.item_id = d.item_id AND a.branch_id = d.branch_id "
            . "LEFT JOIN ( "
            . "SELECT a.branch_id, b.item_id, SUM(b.qty) as qty_in "
            . "FROM tblstock_in a INNER JOIN tblstock_in_det b ON a.stock_in_id = b.stock_in_id "
            . "WHERE a.status = 1 AND a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' "
            . "GROUP BY a.branch_id, b.item_id "
            . ") e ON a.item_id = e.item_id AND a.branch_id = e.branch_id "
            . "LEFT JOIN ( "
            . "SELECT a.branch_id, b.item_id, SUM(b.qty) as qty_out "
            . "FROM tblstock_out a INNER JOIN tblstock_out_det b ON a.stock_out_id = b.stock_out_id "
            . "WHERE a.status = 1 AND a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' "
            . "GROUP BY a.branch_id, b.item_id "
            . ") f ON a.item_id = f.item_id AND a.branch_id = f.branch_id "
            . "LEFT JOIN ( "
            . "SELECT branch_id, item_id, SUM(adj_number) as qty_adj_plus "
            . "FROM tblstock_adj "
            . "WHERE adj_type = 1 AND created_date>='$startperiod' AND DATE_FORMAT(created_date,'%Y-%m-%d')<='$endperiod' "
            . "GROUP BY branch_id, item_id "
            . ") g ON a.item_id = g.item_id AND a.branch_id = g.branch_id "
            . "LEFT JOIN ( "
            . "SELECT branch_id, item_id, SUM(adj_number) as qty_adj_minus "
            . "FROM tblstock_adj "
            . "WHERE adj_type = 2 AND created_date>='$startperiod' AND DATE_FORMAT(created_date,'%Y-%m-%d')<='$endperiod' "
            . "GROUP BY branch_id, item_id "
            . ") h ON a.item_id = h.item_id AND a.branch_id = h.branch_id "
            . $whereall
            . "ORDER BY a.stock_category_name, a.item_code, a.branch_name";
        $data = $this->db->query($query);
        return $data;
    }
}
