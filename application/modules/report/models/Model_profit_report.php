<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_profit_report extends CI_Model
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

        if ($branchid > 0) {
            $whereall = $whereall . " AND a.branch_id = '$branchid'";
        }

        if ($itemid > 0) {
            $whereall = $whereall . " AND d.item_id = '$itemid' ";
        }

        $query = "SELECT * FROM ( "
            . "SELECT c.branch_code, c.branch_name, b.item_id, d.barcode, d.item_name, a.sales_number as trans_number, e.qty_now, (e.qty_now * e.buy_price) as tot_hpp, (e.qty_now * e.sell_price) as tot_sell_price, ((e.sell_price - e.buy_price) * e.qty_now) as profit, ( (e.qty_now * e.sell_price) * 10 / 100 ) AS pajak, a.created_date "
            . "FROM tblsales a inner join tblsales_det b on a.sales_id=b.sales_id "
            . "inner join tblbranch c on a.branch_id=c.branch_id "
            . "inner join tblitem d on b.item_id=d.item_id "
            . "inner join ( "
            . "select a.branch_id, a.item_id, a.qty_now, b.price as buy_price, a.price as sell_price, a.reff_trx "
            . "from tblstock_flow a left join tblstock_flow b on a.reff_id=b.stock_flow_id "
            . "where a.flow_type=2 and a.flow_date>='$startperiod' AND DATE_FORMAT(a.flow_date,'%Y-%m-%d')<='$endperiod' and left(a.reff_trx,3)='POS' "
            . ") e on a.sales_number=e.reff_trx and b.item_id=e.item_id "
            . "where a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' " . $whereall
            . "UNION ALL "
            . "SELECT c.branch_code, c.branch_name, b.item_exchange, d.barcode, d.item_name, a.sales_exchange_number as trans_number, e.qty_now, (e.qty_now * e.buy_price) as tot_hpp, (e.qty_now * e.sell_price) as tot_sell_price, ((e.sell_price - e.buy_price) * e.qty_now) as profit, ( (e.qty_now * e.sell_price) * 10 / 100 ) AS pajak, a.created_date "
            . "FROM tblsales_exchange a inner join tblsales_exchange_det b on a.sales_exchange_id=b.sales_exchange_id "
            . "inner join tblbranch c on a.branch_id=c.branch_id "
            . "inner join tblitem d on b.item_exchange=d.item_id "
            . "inner join ( "
            . "select a.branch_id, a.item_id, a.qty_now, b.price as buy_price, c.sell_price, a.reff_trx "
            . "from tblstock_flow a left join tblstock_flow b on a.reff_id=b.stock_flow_id "
            . "left join (select reff_trx, sum(price) as sell_price from tblstock_flow where flow_date>='$startperiod' AND DATE_FORMAT(flow_date,'%Y-%m-%d')<='$endperiod' group by reff_trx) c on a.reff_trx=c.reff_trx "
            . "where a.flow_type=2 and a.flow_date>='$startperiod' AND DATE_FORMAT(a.flow_date,'%Y-%m-%d')<='$endperiod' and left(a.reff_trx,3)='EXC' "
            . ") e on a.sales_exchange_number=left(e.reff_trx,13) and b.item_exchange=e.item_id "
            . "where a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' " . $whereall
            . ") a order by branch_code, created_date ";
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function get_report($startperiod, $endperiod, $branchid, $itemid)
    {
        $whereall = "";

        if ($branchid > 0) {
            $whereall = $whereall . " AND a.branch_id = '$branchid'";
        }

        if ($itemid > 0) {
            $whereall = $whereall . " AND b.item_id = '$itemid' ";
        }

        $query = "SELECT c.branch_code, c.branch_name, d.barcode, d.item_name, e.qty_now, (e.qty_now * e.buy_price) as tot_hpp, (e.qty_now * e.sell_price) as tot_sell_price, ((e.sell_price - e.buy_price) * e.qty_now) as profit, ( (e.qty_now * e.sell_price) * 10 / 100 ) AS pajak "
            . "FROM tblsales a inner join tblsales_det b on a.sales_id=b.sales_id "
            . "inner join tblbranch c on a.branch_id=c.branch_id "
            . "inner join tblitem d on b.item_id=d.item_id "
            . "inner join ( "
            . "select a.branch_id, a.item_id, a.flow_date, a.qty_now, b.price as buy_price, a.price as sell_price, a.reff_trx "
            . "from tblstock_flow a left join tblstock_flow b on a.reff_id=b.stock_flow_id "
            . "where a.flow_type=2 and a.flow_date>='$startperiod' AND DATE_FORMAT(a.flow_date,'%Y-%m-%d')<='$endperiod' and left(a.reff_trx,3)='POS' "
            . ") e on a.sales_number=e.reff_trx and b.item_id=e.item_id "
            . "where a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' " . $whereall
            . "order by a.branch_id, b.item_id ";
        $data = $this->db->query($query);
        return $data;
    }

    /*
    created by: adam pm
    created at: 2022-04-01
    */
    public function get_report_adam($from, $to, $branch_id, $item_id)
    {
        $sql = "
        SELECT
            tblbranch.branch_code,
            tblbranch.branch_name,
            tblsales_det.item_id,
            tblitem.barcode,
            tblitem.item_name,
            tblsales.sales_number AS trans_number,
            tblsales_det.qty AS qty_now,
            (
                (
                SELECT
                    tblitem_price.buying_price 
                FROM
                    tblitem_price 
                WHERE
                    tblitem_price.item_id = tblsales_det.item_id 
                    AND tblitem_price.start_period <= date( tblsales_det.created_date ) 
                    LIMIT 1 
                ) * tblsales_det.qty 
            ) AS tot_hpp,
            tblsales_det.subtotal AS tot_sell_price,
            (
                (
                    tblsales_det.subtotal - (
                    SELECT
                        tblitem_price.buying_price 
                    FROM
                        tblitem_price 
                    WHERE
                        tblitem_price.item_id = tblsales_det.item_id 
                        AND tblitem_price.start_period <= date( tblsales_det.created_date ) 
                        LIMIT 1 
                    ) * tblsales_det.qty 
                ) 
            ) AS profit,
            ( tblsales_det.subtotal * 10 / 100 ) AS pajak,
            tblsales.created_date 
        FROM
            tblsales_det
            LEFT JOIN tblsales ON tblsales.sales_id = tblsales_det.sales_id
            RIGHT JOIN tblitem ON tblitem.item_id = tblsales_det.item_id
            LEFT JOIN tblbranch ON tblbranch.branch_id = tblsales.branch_id 
        WHERE
            DATE( tblsales.created_date ) BETWEEN '$from' 
            AND '$to' 
        ORDER BY
            tblsales.sales_number ASC
        ";
        $query = $this->db->query($sql);

        $data = [];

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key) {
                $nest['branch_code']    = $key->branch_code;
                $nest['branch_name']    = $key->branch_name;
                $nest['item_id']        = $key->item_id;
                $nest['barcode']        = $key->barcode;
                $nest['item_name']      = $key->item_name;
                $nest['trans_number']   = $key->trans_number;
                $nest['qty_now']        = $key->qty_now;
                $nest['tot_hpp']        = $key->tot_hpp;
                $nest['tot_sell_price'] = $key->tot_sell_price;
                $nest['profit']         = $key->profit;
                $nest['pajak']          = $key->pajak;
                $nest['created_date']   = $key->created_date;
                array_push($data, $nest);
            }
        }
        return $data;
    }
}
