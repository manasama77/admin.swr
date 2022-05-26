<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_settings extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

	public function get_all(){
        $query = $this->db->query("SELECT * FROM tblcompany_setting");
        return $query->row();
	}
	
    public function edit_data($companyname,$address,$city,$phone,$mobile,$email,$salesnotes,$logofilename,$logopreview,$salesexchangelimit,$wholesalelimit){
        $query = $this->db->query("update tblcompany_setting set company_name='$companyname', address='$address', city='$city', phone='$phone', mobile='$mobile', email='$email', sales_notes='$salesnotes', logo_filename='$logofilename', logo_preview='$logopreview', sales_exchange_limit='$salesexchangelimit', wholesale_limit='$wholesalelimit'");
		if($query){
			return "success";
		}else{
			return "failed";
		}
    }
    
}