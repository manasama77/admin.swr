<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_price extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function search_item($barcode)
    {
        $query = $this->db->query("SELECT item_id FROM tblitem WHERE barcode = '$barcode'");
        return $query->row();
    }

    function dd_branch()
    {
        $query = $this->db->query("SELECT branch_id, branch_code, branch_name FROM tblbranch");
        return $query->result_array();
    }

    function dd_branch_only($id)
    {
        $query = $this->db->query("SELECT * FROM tblbranch where branch_id='$id'");
        return $query->result_array();
    }

    function dd_item()
    {
        $query = $this->db->query("SELECT * FROM tblitem order by item_name");
        return $query->result_array();
    }

    public function get_all($limit, $start, $search)
    {
        $sql = "SELECT *, case when a.branch_id > 0 then c.branch_name else 'Semua Cabang' end as branch_name 
                FROM tblitem_price a INNER JOIN tblitem b ON a.item_id = b.item_id LEFT JOIN tblbranch c ON a.branch_id=c.branch_id ";

        $search = trim($search);
        if (strlen($search) > 0) {
            $sql = $sql . "WHERE b.item_name like '%$search%' ";
        }

        if ($limit != -1) {
            $sql = $sql . "LIMIT $limit OFFSET $start ";
        }

        $data = $this->db->query($sql);
        return $data;
    }

    public function get_count_all($search)
    {
        $sql = "SELECT count(0) as tot_data FROM tblitem_price a INNER JOIN tblitem b ON a.item_id = b.item_id ";

        $search = trim($search);
        if (strlen($search) > 0) {
            $sql = $sql . "WHERE b.item_name like '%$search%' ";
        }

        $query = $this->db->query($sql);
        return $query->row();
    }

    public function get_by_id($id)
    {
        $sql = "
        SELECT
            tblitem_price.item_price_id,
            tblitem_price.branch_id,
            tblitem_price.item_id,
            tblitem_price.start_period,
            tblitem_price.buying_price,
            tblitem_price.selling_price,
            tblbranch.branch_name,
            tblitem.item_name 
        FROM
            tblitem_price
            LEFT JOIN tblbranch ON tblbranch.branch_id = tblitem_price.branch_id
            LEFT JOIN tblitem ON tblitem.item_id = tblitem_price.item_id 
        WHERE
            item_price_id = $id
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function save_data($branchid, $itemid, $dtstartperiod, $buyingprice, $sellingprice, $creatorid)
    {
        $query = $this->db->query("insert into tblitem_price (branch_id,item_id,start_period,buying_price,selling_price,creator_id,created_date) 
        values('$branchid','$itemid','$dtstartperiod','$buyingprice','$sellingprice','$creatorid',NOW())");
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function update_data_excel($itemid, $startperiod, $endperiod, $minprice, $memberprice)
    {
        $query = $this->db->query("update tblitem_price set public_price = '$minprice',member_price = '$memberprice' where item_id = '$itemid' and start_period = '$startperiod' and end_period = '$endperiod'");
        if ($query) {
            return "success";
        } else {
            return "failed";
        }
    }

    public function edit_data($buyingprice, $sellingprice, $modificatorid, $id, $startperiod)
    {
        $query = $this->db->query("update tblitem_price set start_period = '$startperiod', buying_price = '$buyingprice', selling_price = '$sellingprice', modificator_id = '$modificatorid', modified_date = NOW() where item_price_id = '$id'");
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $query = $this->db->query("select count(0) as is_exist from tblitem_price where start_period <= NOW() and item_price_id='$id'");
        $data = $query->row_array();
        $is_exist = $data['is_exist'];

        if ($is_exist > 0) {
            return "Cannot delete price which already used in transaction";
        } else {
            $query = $this->db->query("delete from tblitem_price where item_price_id ='$id'");
            if ($query) {
                return "Data Deleted";
            } else {
                return "Failed on Price Delete";
            }
        }
    }

    public function check_price_exist($itemid, $dtstartperiod, $dtendperiod)
    {
        $query = $this->db->query("select count(0) as is_exist from tblitem_price where item_id = '$itemid' 
            and (
                (start_period <= '$dtstartperiod' and end_period >= '$dtendperiod') or 
                (start_period >= '$dtstartperiod' and end_period <= '$dtendperiod') or 
                (start_period >= '$dtstartperiod' and end_period >= '$dtendperiod' and start_period <= '$dtendperiod') or 
                (start_period <= '$dtstartperiod' and end_period <= '$dtendperiod' and end_period >= '$dtstartperiod'))");
        return $query->row();
    }
}
