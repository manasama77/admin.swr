<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_profile extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

	public function get_all($id){
        $query = $this->db->query("SELECT * FROM tbluser where user_id='$id'");
        return $query->row();
	}
	
    public function edit_data($fullname,$phone,$email,$address,$id){
        $query = $this->db->query("update tbluser set fullname='$fullname', phone='$phone', email='$email', address='$address' where user_id='$id'");
		if($query){
			return true;
		}else{
			return false;
		}
    }
    
}