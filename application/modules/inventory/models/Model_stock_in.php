<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_stock_in extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function dd_branch()
    {
        $query = $this->db->query("SELECT branch_id, branch_code, branch_name FROM tblbranch");
        return $query;
    }

    function dd_branch_only($id)
    {
        $query = $this->db->query("SELECT * FROM tblbranch where branch_id='$id'");
        return $query;
    }

    function dd_supplier()
    {
        $query = $this->db->query("SELECT * FROM tblsupplier");
        return $query;
    }

    function dd_item()
    {
        $query = $this->db->query("SELECT * FROM tblitem order by item_name");
        return $query;
    }

    public function get_all()
    {
        $query = $this->db->query("SELECT *, CASE WHEN status = 0 THEN 'Draft' WHEN status = 1 THEN 'Final' END as strstatus 
        FROM tblstock_in a INNER JOIN tblbranch b ON a.branch_id=b.branch_id INNER JOIN tblsupplier c ON a.supplier_id=c.supplier_id");
        return $query;
    }

    public function get_by_id_master($id)
    {
        $sql = "
        SELECT
            tblstock_in.*,
            tblsupplier.supplier_name,
            tblbranch.branch_name 
        FROM
            tblstock_in
            LEFT JOIN tblbranch ON tblbranch.branch_id = tblstock_in.branch_id
            LEFT JOIN tblsupplier ON tblsupplier.supplier_id = tblstock_in.supplier_id 
        WHERE
            stock_in_id = '$id'
        ";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function get_by_id_detail($id)
    {
        $query = $this->db->query("SELECT * FROM tblstock_in_det a INNER JOIN tblitem b ON a.item_id=b.item_id WHERE a.stock_in_id='$id'");
        return $query->result();
    }

    public function get_item($itemcode)
    {
        $query = $this->db->query("SELECT * FROM tblitem WHERE item_code='$itemcode'");
        return $query->row();
    }

    public function save_data($branchid, $supplierid, $docnumber, $dtstockdate, $status, $description, $arr_item_id, $arr_item_qty, $creatorid)
    {
        $this->db->trans_begin();

        $sql_in = "
        INSERT INTO tblstock_in
        (
            branch_id,
            supplier_id,
            doc_number,
            stock_date,
            status,
            description,
            creator_id,
            created_date
        )
        VALUES 
        (
            '$branchid',
            '$supplierid',
            '$docnumber',
            '$dtstockdate',
            '$status',
            '$description',
            '$creatorid',
            NOW()
        )
        ";

        $query = $this->db->query($sql_in);

        if (!$query) {
            $this->db->trans_rollback();
            return false;
        }

        $last_id = $this->db->insert_id();

        for ($i = 0; $i < count($arr_item_id); $i++) {
            $item_id  = $arr_item_id[$i];
            $item_qty = $arr_item_qty[$i];

            $sql_stock_in_det = "
            INSERT INTO tblstock_in_det
            (
                stock_in_id,
                item_id,
                qty,
                creator_id,
                created_date
            )
            VALUES 
            (
                '$last_id',
                '$item_id',
                '$item_qty',
                '$creatorid',
                NOW()
            )
            ";
            $query = $this->db->query($sql_stock_in_det);
            if (!$query) {
                $this->db->trans_rollback();
                return false;
            }

            $sql_check_tblitem_stock   = "SELECT * FROM tblitem_stock WHERE branch_id = $branchid and item_id = $item_id";
            $query_check_tblitem_stock = $this->db->query($sql_check_tblitem_stock);
            $is_exist                  = $query_check_tblitem_stock->num_rows();

            if ($is_exist > 0) {
                $prev_qty = $query_check_tblitem_stock->row()->qty;
                $sql_tblitem_stock = "UPDATE tblitem_stock SET qty = qty + $item_qty WHERE branch_id = $branchid and item_id = $item_id";
            } else {
                $prev_qty = $item_qty;
                $sql_tblitem_stock = "INSERT INTO tblitem_stock (branch_id, item_id, qty) values ($branchid, '$item_id', '$item_qty')";
            }

            $query = $this->db->query($sql_tblitem_stock);
            if (!$query) {
                $this->db->trans_rollback();
                return false;
            }

            $sql_check_tblitem_price = "SELECT count(0) as is_exist FROM tblitem_price WHERE branch_id = $branchid AND item_id = '$item_id' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d')";
            $query_tblitem_price = $this->db->query($sql_check_tblitem_price);

            if (!$query_tblitem_price) {
                $this->db->trans_rollback();
                return false;
            }

            $is_exist = $query_tblitem_price->row()->is_exist;

            $buying_price = 0;
            if ($is_exist > 0) {
                $sql_tblitem_price = "SELECT buying_price FROM tblitem_price WHERE branch_id = '$branchid' AND item_id = '$item_id' AND start_period <= DATE_FORMAT(NOW(),'%Y-%m-%d') ORDER BY start_period DESC LIMIT 1";
                $query = $this->db->query($sql_tblitem_price);

                if (!$query) {
                    $this->db->trans_rollback();
                    return false;
                }

                $buying_price = $query->row()->buying_price;
            }

            $new_qty = $prev_qty + $item_qty;

            $sql_tblstock_flow = "
            INSERT INTO tblstock_flow 
            (
                branch_id,
                item_id,
                flow_type,
                flow_date,
                qty_trx,
                qty_now,
                price,
                information,
                reff_id,
                reff_trx
            ) 
            VALUES
            (
                '$branchid',
                '$item_id',
                1,
                NOW(),
                '$item_qty',
                '$new_qty',
                '$buying_price',
                'stock_in',
                null,
                '$docnumber'
            )";
            $query = $this->db->query($sql_tblstock_flow);

            if (!$query) {
                $this->db->trans_rollback();
                return false;
            }
        }
        $this->db->trans_commit();
        return true;
    }

    public function edit_data($branchid, $status, $description, $item, $modificatorid, $id)
    {
        $query = $this->db->query("update tblstock_in set status = '$status',description = '$description', modificator_id='$modificatorid', modified_date=NOW() where stock_in_id = '$id'");
        if ($query) {
            $query = $this->db->query("delete from tblstock_in_det where stock_in_id ='$id'");
            for ($i = 0; $i < sizeof($item['itemStockItem']); $i++) {
                $itemStockItem = $item['itemStockItem'][$i];
                $itemQty = $item['itemQty'][$i];
                $query = $this->db->query("insert into tblstock_in_det (stock_in_id,item_id,qty,creator_id,created_date) 
                values('$id','$itemStockItem','$itemQty','$modificatorid',now())");

                if ($status == 1) {
                    $query_exist = $this->db->query("select count(0) as is_exist from tblitem_stock where branch_id='$branchid' and item_id = '$itemStockItem'");
                    $data_exist = $query_exist->row_array();
                    $is_exist = $data_exist['is_exist'];

                    if ($is_exist > 0) {
                        $query = $this->db->query("update tblitem_stock set qty = qty + '$itemQty' where branch_id='$branchid' and item_id = '$itemStockItem'");
                    } else {
                        $query = $this->db->query("insert into tblitem_stock(branch_id,item_id,qty) values('$branchid','$itemStockItem','$itemQty')");
                    }

                    $query_exist1 = $this->db->query("SELECT count(0) as is_exist FROM tblitem_price WHERE branch_id = '$branchid' AND item_id = '$itemStockItem' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d')");
                    $data_exist1 = $query_exist1->row_array();
                    $is_exist1 = $data_exist1['is_exist'];

                    $query_exist2 = $this->db->query("SELECT count(0) as is_exist FROM tblitem_price WHERE branch_id = '-1' AND item_id = '$itemStockItem' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d')");
                    $data_exist2 = $query_exist2->row_array();
                    $is_exist2 = $data_exist2['is_exist'];

                    if ($is_exist1 > 0) {
                        $query = $this->db->query("SELECT buying_price FROM tblitem_price WHERE branch_id = '$branchid' AND item_id = '$itemStockItem' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') ORDER BY start_period desc LIMIT 1");
                    } else if ($is_exist2 > 0) {
                        $query = $this->db->query("SELECT buying_price FROM tblitem_price WHERE branch_id = '-1' AND item_id = '$itemStockItem' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') ORDER BY start_period desc LIMIT 1");
                    } else {
                        $query = $this->db->query("SELECT 0 as buying_price ");
                    }
                    $data = $query->row_array();
                    $itemBuyingPrice = $data['buying_price'];

                    $query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id,reff_trx) 
                    values('$branchid','$itemStockItem',1,NOW(),'$itemQty','$itemQty','$itemBuyingPrice','stock_in',null,'$docnumber')");
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $query = $this->db->query("delete from tblstock_in where stock_in_id ='$id'");
        if ($query) {
            $query = $this->db->query("delete from tblstock_in_det where stock_in_id ='$id'");
            return true;
        } else {
            return false;
        }
    }

    public function check_docnumber_exist($docnumber)
    {
        $query = $this->db->query("select count(0) as is_exist from tblstock_in where doc_number ='$docnumber'");
        return $query->row();
    }
}
