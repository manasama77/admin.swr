<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_merk extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all()
    {
        $query = $this->db->query("SELECT * FROM tblmerk order by name asc");
        return $query;
    }

    public function get_by_id($id)
    {
        $query = $this->db->query("SELECT * FROM tblmerk WHERE id='$id'");
        return $query->row();
    }

    public function save_data($nama_merk)
    {
        $query = $this->db->query("insert into tblmerk (name) values('$nama_merk')");
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function update_data_excel($suppliercode, $suppliername, $contactname, $phone, $handphone, $email, $city, $address, $description)
    {
        $query = $this->db->query("update tblsupplier set supplier_name = '$suppliername',contact_name = '$contactname',phone='$phone',handphone='$handphone',email = '$email',city='$city',address = '$address',description='$description' where supplier_code = '$suppliercode'");
        if ($query) {
            return "success";
        } else {
            return "failed";
        }
    }

    public function edit_data($id, $nama_merk)
    {
        $query = $this->db->query("update tblmerk set name='$nama_merk' where id = '$id'");
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $query = $this->db->query("select count(0) as is_exist from tblitem where merk_id ='$id'");
        $data = $query->row_array();
        $is_exist = $data['is_exist'];
        if ($is_exist > 0) {
            return false;
        } else {
            $query = $this->db->query("delete from tblmerk where id ='$id'");
            if ($query) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function check_suppliercode_exist($suppliercode)
    {
        $query = $this->db->query("select count(0) as is_exist from tblsupplier where supplier_code ='$suppliercode'");
        return $query->row();
    }
}
