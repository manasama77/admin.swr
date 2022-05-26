<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_supplier extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function last_supplier_code()
    {
        $query = $this->db->query("SELECT SUBSTRING(supplier_code,10,4) as last_number FROM tblsupplier WHERE supplier_id = (SELECT max(supplier_id) FROM tblsupplier)");
        return $query->row();
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT * FROM tblsupplier");
        return $query;
	}
	
	public function get_by_id($id){
        $query = $this->db->query("SELECT * FROM tblsupplier WHERE supplier_id='$id'");
        return $query->row();
    }
    
    public function save_data($suppliercode,$suppliername,$contactname,$phone,$handphone,$email,$city,$address,$description,$creatorid){
        $query = $this->db->query("insert into tblsupplier (supplier_code,supplier_name,contact_name,phone,handphone,email,city,address,description,creator_id,created_date) 
        values('$suppliercode','$suppliername','$contactname','$phone','$handphone','$email','$city','$address','$description','$creatorid',NOW())");
		if($query){
			return true;
		}else{
			return false;
		}
    }
	
    public function update_data_excel($suppliercode,$suppliername,$contactname,$phone,$handphone,$email,$city,$address,$description){
        $query = $this->db->query("update tblsupplier set supplier_name = '$suppliername',contact_name = '$contactname',phone='$phone',handphone='$handphone',email = '$email',city='$city',address = '$address',description='$description' where supplier_code = '$suppliercode'");
		if($query){
			return "success";
		}else{
			return "failed";
		}
    }
    
    public function edit_data($suppliername,$contactname,$phone,$handphone,$email,$city,$address,$description,$modificatorid,$id){
        $query = $this->db->query("update tblsupplier set supplier_name='$suppliername', contact_name = '$contactname',phone = '$phone',handphone = '$handphone',email = '$email',city = '$city',address = '$address',description = '$description', modificator_id='$modificatorid', modified_date='NOW()' where supplier_id = '$id'");
		if($query){
			return true;
		}else{
			return false;
		}
    }
    
    public function delete($id){
        $query = $this->db->query("select count(0) as is_exist from tblitem where supplier_id ='$id'");
        $data = $query->row_array();
        $is_exist = $data['is_exist'];
        if($is_exist > 0){
            return false;
        }
        else{
            $query = $this->db->query("delete from tblsupplier where supplier_id ='$id'");
            if($query){
                return true;
		}else{
			return false;
            }
        }
    }

    public function check_suppliercode_exist($suppliercode){
        $query = $this->db->query("select count(0) as is_exist from tblsupplier where supplier_code ='$suppliercode'");
        return $query->row();
    }
}