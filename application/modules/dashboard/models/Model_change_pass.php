<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_change_pass extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    public function edit_data($password,$id){
        $query = $this->db->query("update tbluser set password='$password' where user_id='$id'");
		if($query){
			return true;
		}else{
			return false;
		}
    }
    
}