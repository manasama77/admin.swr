<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_stock_item extends CI_Model
{
    protected $select;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->select = "a.item_id, 
        a.stock_category_id, 
        a.unit_id, 
        a.item_code, 
        a.item_name, 
        a.barcode, 
        a.minimum_stock, 
        a.maximum_stock, 
        a.foto_filename, 
        a.foto_preview, 
        a.merk_id, 
        a.keterangan, 
        a.creator_id, 
        a.created_date, 
        a.modificator_id, 
        a.modified_date,
        c.stock_category_id,
        c.stock_category_code,
        c.stock_category_name,
        d.unit_id,
        d.unit_code,
        d.unit_name,
        tblmerk.name as merk_name";
    }

    public function last_item_code()
    {
        $query = $this->db->query("SELECT SUBSTRING(item_code,10,4) as last_number FROM tblitem WHERE item_id = (SELECT max(item_id) FROM tblitem)");
        return $query->row();
    }

    public function search_supplier($suppliercode)
    {
        $query = $this->db->query("SELECT supplier_id FROM tblsupplier WHERE supplier_code = '$suppliercode'");
        return $query->row();
    }

    public function search_stock_category($stockcategorycode)
    {
        $query = $this->db->query("SELECT stock_category_id FROM tblstock_category WHERE stock_category_code = '$stockcategorycode'");
        return $query->row();
    }

    public function search_stock_unit($unitcode)
    {
        $query = $this->db->query("SELECT unit_id FROM tblunit WHERE unit_code = '$unitcode'");
        return $query->row();
    }

    public function itemcode($itemcode)
    {
        $query = $this->db->query("SELECT '$itemcode' as itemcode");
        return $query->row();
    }

    public function dd_stockcategory()
    {
        $query = $this->db->query("SELECT * FROM tblstock_category");
        return $query;
    }

    public function dd_unit()
    {
        $query = $this->db->query("SELECT * FROM tblunit");
        return $query;
    }

    public function get_all()
    {
        $query = $this->db->query("SELECT $this->select FROM tblitem a INNER JOIN tblstock_category c ON a.stock_category_id = c.stock_category_id INNER JOIN tblunit d ON a.unit_id = d.unit_id left join tblmerk on tblmerk.id = a.merk_id");
        return $query;
    }

    public function get_by_id($id)
    {
        $query = $this->db->query("SELECT * FROM tblitem WHERE item_id='$id'");
        return $query->row();
    }

    public function save_data($stockcategoryid, $unitid, $itemcode, $itemname, $barcode, $minimumstock, $maximumstock, $fotofilename, $fotopreview, $creatorid, $merk_id, $keterangan)
    {
        $query = $this->db->query("
        insert into tblitem 
        (
            stock_category_id, 
            unit_id, 
            item_code,
            item_name,
            barcode, 
            minimum_stock,
            maximum_stock,
            foto_filename,
            foto_preview,
            merk_id,
            keterangan,
            creator_id,
            created_date
        ) 
        values
        (
            '$stockcategoryid',
            '$unitid',
            '$itemcode',
            '$itemname',
            '$barcode',
            '$minimumstock',
            '$maximumstock',
            '$fotofilename',
            '$fotopreview',
            '$merk_id',
            '$keterangan', 
            '$creatorid',
            NOW()
        )");
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_data($stockcategoryid, $unitid, $itemcode, $itemname, $barcode, $minimumstock, $maximumstock, $fotofilename, $fotopreview, $merk_id, $keterangan, $modificatorid, $id)
    {
        $query = $this->db->query("update tblitem set stock_category_id = '$stockcategoryid',unit_id = '$unitid',item_code = '$itemcode',item_name = '$itemname',barcode = '$barcode', minimum_stock = '$minimumstock',maximum_stock = '$maximumstock', foto_filename='$fotofilename', foto_preview='$fotopreview', modificator_id='$modificatorid',modified_date = NOW(), merk_id = '$merk_id', keterangan = '$keterangan' where item_id = '$id'");
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function check_code($code)
    {
        $this->db->where('item_code', $code);
        return $this->db->get('tblitem');
    }

    public function delete($id)
    {
        $this->db->trans_begin();

        $query1 = $this->db->query("select count(0) as is_exist from tblsales_det where item_id='$id'");
        $data1 = $query1->row_array();
        $is_exist1 = $data1['is_exist'];

        // $query2 = $this->db->query("select count(0) as is_exist from tblstock_in_det where item_id='$id'");
        // $data2 = $query2->row_array();
        // $is_exist2 = $data2['is_exist'];

        $query3 = $this->db->query("select count(0) as is_exist from tblstock_out_det where item_id='$id'");
        $data3 = $query3->row_array();
        $is_exist3 = $data3['is_exist'];

        // $query4 = $this->db->query("select count(0) as is_exist from tblstock_adj where item_id='$id'");
        // $data4 = $query4->row_array();
        // $is_exist4 = $data4['is_exist'];

        // if (($is_exist1 > 0) && ($is_exist2 > 0) && ($is_exist3 > 0) && ($is_exist4 > 0)) {
        if (($is_exist1 > 0) && ($is_exist3 > 0)) {
            $this->db->trans_rollback();
            return false;
        } else {
            $query1 = $this->db->query("delete from tblitem where item_id ='$id'");
            $query2 = $this->db->query("delete from tblstock_in_det where item_id ='$id'");
            $query3 = $this->db->query("delete from tblstock_adj where item_id ='$id'");
            if ($query1 && $query2 && $query3) {
                $this->db->trans_commit();
                return true;
            } else {
                $this->db->trans_rollback();
                return false;
            }
        }
    }

    public function get_all_item()
    {
        $query = $this->db->query("SELECT * FROM tblitem");
        return $query->result_array();
    }

    public function barcode_isexist($barcode)
    {
        $query = $this->db->query("select count(0) as is_exist from tblitem where barcode ='$barcode'");
        return $query->row_array();
    }

    public function update_barcode($barcode, $id)
    {
        $query = $this->db->query("update tblitem set barcode ='$barcode' where item_id='$id'");
    }
}
