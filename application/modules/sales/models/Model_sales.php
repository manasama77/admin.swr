<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sales extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function dd_bank()
    {
        $query = $this->db->query("SELECT * FROM tblbank");
        return $query;
    }

    function dd_item()
    {
        $query = $this->db->query("SELECT * FROM tblitem order by item_name");
        return $query;
    }

    function last_trans_number()
    {
        $query = $this->db->query("SELECT SUBSTRING(sales_number,10,4) as last_number 
        FROM tblsales 
        WHERE sales_id = (SELECT max(sales_id) FROM tblsales WHERE YEAR(created_date)=YEAR(NOW()) AND MONTH(created_date)=MONTH(NOW()))");
        return $query->row();
    }

    function validate_logincode($logincode)
    {
        $query = $this->db->query("SELECT * FROM tbluser WHERE login_code = '$logincode' and status=1");
        return $query->row();
    }

    function item_name($branchid, $barcode)
    {
        $query = $this->db->query("SELECT a.item_id,a.stock_category_id,a.item_name,b.qty 
        FROM tblitem a INNER JOIN tblitem_stock b ON a.item_id=b.item_id 
        WHERE b.branch_id = '$branchid' AND a.barcode = '$barcode'");
        return $query->row();
    }

    function check_setting()
    {
        $query = $this->db->query("SELECT * FROM tblcompany_setting");
        return $query->row();
    }

    function item_price($id, $branchid)
    {
        $query_exist1 = $this->db->query("SELECT count(0) as is_exist FROM tblitem_price WHERE item_id = '$id' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        $data_exist1 = $query_exist1->row_array();
        $is_exist1 = $data_exist1['is_exist'];

        if ($is_exist1 > 0) {
            $query = $this->db->query("SELECT selling_price FROM tblitem_price WHERE item_id = '$id' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') ORDER BY start_period desc LIMIT 1");
        } else {
            $query = $this->db->query("SELECT 0 as selling_price ");
        }

        return $query->row();
    }

    function item_promo($branchid, $stockcategoryid, $id)
    {
        $query_exist1 = $this->db->query("SELECT count(0) as is_exist FROM tblitem_promo WHERE branch_id = '$branchid' AND stock_category_id='$stockcategoryid' AND item_id='$id' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') AND end_period>=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        $data_exist1 = $query_exist1->row_array();
        $is_exist1 = $data_exist1['is_exist'];

        $query_exist2 = $this->db->query("SELECT count(0) as is_exist FROM tblitem_promo WHERE branch_id = '$branchid' AND stock_category_id='$stockcategoryid' AND item_id = -1 AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') AND end_period>=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        $data_exist2 = $query_exist2->row_array();
        $is_exist2 = $data_exist2['is_exist'];

        $query_exist3 = $this->db->query("SELECT count(0) as is_exist FROM tblitem_promo WHERE branch_id = '$branchid' AND stock_category_id = -1 AND item_id = -1 AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') AND end_period>=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        $data_exist3 = $query_exist3->row_array();
        $is_exist3 = $data_exist3['is_exist'];

        $query_exist4 = $this->db->query("SELECT count(0) as is_exist FROM tblitem_promo WHERE branch_id = -1 AND stock_category_id = -1 AND item_id = -1 AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') AND end_period>=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        $data_exist4 = $query_exist4->row_array();
        $is_exist4 = $data_exist4['is_exist'];

        if ($is_exist1 > 0) {
            $query = $this->db->query("SELECT disc_percentage, disc_amount FROM tblitem_promo WHERE branch_id = '$branchid' AND stock_category_id = '$stockcategoryid' AND item_id = '$id' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') AND end_period>=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        } else if ($is_exist2 > 0) {
            $query = $this->db->query("SELECT disc_percentage, disc_amount FROM tblitem_promo WHERE branch_id = '$branchid' AND stock_category_id = '$stockcategoryid' AND item_id = -1 AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') AND end_period>=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        } else if ($is_exist3 > 0) {
            $query = $this->db->query("SELECT disc_percentage, disc_amount FROM tblitem_promo WHERE branch_id = '$branchid' AND stock_category_id = -1 AND item_id = -1 AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') AND end_period>=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        } else if ($is_exist4 > 0) {
            $query = $this->db->query("SELECT disc_percentage, disc_amount FROM tblitem_promo WHERE branch_id = -1 AND stock_category_id = -1 AND item_id = -1 AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') AND end_period>=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        } else {
            $query = $this->db->query("SELECT 0 as disc_percentage, 0 as disc_amount");
        }

        return $query->row();
    }

    function search_stock($itemid)
    {
        $query = $this->db->query("SELECT b.branch_name, a.qty FROM tblitem_stock a INNER JOIN tblbranch b ON a.branch_id=b.branch_id WHERE a.item_id = '$itemid'");
        return $query->result_array();
    }

    function search_price($branchid, $itemid)
    {
        $query_exist1 = $this->db->query("SELECT count(0) as is_exist FROM tblitem_price WHERE item_id = '$itemid' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        $data_exist1 = $query_exist1->row_array();
        $is_exist1 = $data_exist1['is_exist'];

        if ($is_exist1 > 0) {
            $query = $this->db->query("SELECT start_period, selling_price FROM tblitem_price WHERE item_id = '$itemid' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') ORDER BY start_period desc LIMIT 1");
        } else {
            $query = $this->db->query("SELECT '' as start_period, 0 as selling_price ");
        }

        return $query->row_array();
    }

    function save_data($branchid, $salesnumber, $totalprice, $totaldisc, $totaltrans, $paymenttype, $bankid, $cardholder, $cardnumber, $payment, $exchange, $notes, $item, $creatorid)
    {
        $salesid = 0;
        $query = $this->db->query("insert into tblsales (branch_id,sales_number,total_price,total_disc,total_transaction,payment_type,bank_id,card_holder,card_number,payment,exchange,notes,creator_id,created_date) 
        values('$branchid','$salesnumber','0','0','$totaltrans','$paymenttype','$bankid','$cardholder','$cardnumber','$payment','$exchange','$notes','$creatorid',NOW())");

        if ($query) {
            $salesid  = $this->db->insert_id();
            $totPrice = 0;
            $totDisc  = 0;
            for ($i = 0; $i < sizeof($item['itemId']); $i++) {
                $itemId      = $item['itemId'][$i];
                $itemPrice   = $item['itemPrice'][$i];
                $itemDisc    = 0;
                $itemExtDisc = $item['itemExtDisc'][$i];
                $itemQty     = $item['itemQty'][$i];
                $itemAmount  = $item['itemAmount'][$i];

                $totPrice = $totPrice + ($itemPrice * $itemQty);
                $totDisc  = $totDisc + $itemExtDisc;

                $querydetail = $this->db->query("insert into tblsales_det (sales_id,item_id,price,disc,extra_disc,qty,subtotal,creator_id,created_date) 
                values('$salesid','$itemId','$itemPrice','$itemDisc','$itemExtDisc','$itemQty','$itemAmount','$creatorid',NOW())");

                if ($querydetail) {
                    $query = $this->db->query("update tblitem_stock set qty = qty - '$itemQty' where branch_id='$branchid' and item_id = '$itemId'");
                }

                $qtyloop = $itemQty;
                $queryflow = $this->db->query("select * from tblstock_flow where branch_id='$branchid' and item_id='$itemId' and flow_type=1 and qty_now>0 order by stock_flow_id");
                if ($queryflow->num_rows() > 0) {
                    foreach ($queryflow->result_array() as $row) {
                        $flowid = $row['stock_flow_id'];
                        $flowqty = $row['qty_now'];
                        $soldprice = $itemPrice - $itemDisc - $itemExtDisc;

                        if ($qtyloop >= $flowqty) {
                            $query = $this->db->query("update tblstock_flow set qty_now = 0 where stock_flow_id='$flowid'");

                            $query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id,reff_trx) 
                            values('$branchid','$itemId',2,NOW(),'$flowqty','$flowqty','$soldprice','stock_out','$flowid','$salesnumber')");
                        } else {
                            $query = $this->db->query("update tblstock_flow set qty_now = qty_now - '$qtyloop' where stock_flow_id='$flowid'");

                            $query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id,reff_trx) 
                            values('$branchid','$itemId',2,NOW(),'$qtyloop','$qtyloop','$soldprice','stock_out','$flowid','$salesnumber')");
                        }

                        $qtyloop = $qtyloop - $flowqty;

                        if ($qtyloop <= 0) {
                            break;
                        }
                    }
                }
            }

            $queryprice = $this->db->query("update tblsales set total_price = '$totPrice', total_disc = '$totDisc' where sales_id = '$salesid' ");

            $querystockout = $this->db->query("insert into tblstock_out (branch_id,doc_number,stock_date,status,creator_id,created_date) 
            values('$branchid','$salesnumber',NOW(),1,'$creatorid',NOW())");

            if ($querystockout) {
                $stockoutid = $this->db->insert_id();
                for ($i = 0; $i < sizeof($item['itemId']); $i++) {
                    $itemId = $item['itemId'][$i];
                    $itemQty = $item['itemQty'][$i];
                    $querydetail = $this->db->query("insert into tblstock_out_det (stock_out_id,item_id,qty,creator_id,created_date)
                     values('$stockoutid','$itemId','$itemQty','$creatorid',NOW())");
                }
            }

            return true;
        } else {
            return false;
        }
    }

    function get_header($salesnumber)
    {
        $query = $this->db->query("SELECT a.sales_number, a.created_date as sales_date, a.total_price, a.total_disc, a.total_transaction, case when a.payment_type=1 then 'TUNAI' when a.payment_type=1 then 'DEBIT' when a.payment_type=1 then 'KARTU KREDIT' end as payment_type, a.payment, a.exchange, b.branch_name, b.branch_address, c.fullname as cashier_name, d.sales_notes
        FROM tblsales a LEFT JOIN tblbranch b ON a.branch_id=b.branch_id LEFT JOIN tbluser c ON a.creator_id=c.user_id CROSS JOIN tblcompany_setting d
        WHERE a.sales_number='$salesnumber'");
        return $query->row();
    }

    function get_report($salesnumber)
    {
        $query = "SELECT c.item_name, b.price, (b.disc+b.extra_disc)*b.qty as disc, b.qty, (b.price * b.qty) as subtotal FROM tblsales a INNER JOIN tblsales_det b ON a.sales_id=b.sales_id INNER JOIN tblitem c ON b.item_id=c.item_id WHERE a.sales_number='$salesnumber'";
        $data = $this->db->query($query);
        return $data;
    }
}
