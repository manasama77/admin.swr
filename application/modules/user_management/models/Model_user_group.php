<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_user_group extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }
    
    function last_user_group_code()
    {
        $query = $this->db->query("SELECT SUBSTRING(user_group_code,10,4) as last_number FROM tbluser_group WHERE user_group_id = (SELECT max(user_group_id) FROM tbluser_group)");
        return $query->row();
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT *, case when user_group_status = 0 then 'Non Aktif' when user_group_status = 1 then 'Aktif' end as str_status FROM tbluser_group");
        return $query;
	}
	
	public function get_all_menu(){
        $query = $this->db->query("SELECT * FROM tblmenu");
        return $query->result_array();
	}
	
	public function get_by_id($id){
        $query = $this->db->query("SELECT * FROM tbluser_group WHERE user_group_id='$id'");
        return $query->row();
    }
    
    public function save_data($usergroupcode,$usergroupname,$usergroupstatus,$creatorid){
        $usergroupid = 0;
        $query = $this->db->query("insert into tbluser_group (user_group_code,user_group_name,user_group_status,creator_id,created_date) values('$usergroupcode','$usergroupname','$usergroupstatus','$creatorid',NOW())");
        $usergroupid = $this->db->insert_id();
        
		if($query){
			return $usergroupid;
		}else{
			return 0;
		}
    }
	
    public function generate_user_access($usergroupid,$menuid,$creatorid){
        $query = $this->db->query("insert into tbluser_access (user_group_id,menu_id,is_access,creator_id,created_date) values('$usergroupid','$menuid','0','$creatorid',NOW())");
        
		if($query){
			return true;
		}else{
			return false;
		}
    }
	
    public function edit_data($usergroupname,$usergroupstatus,$modificatorid,$id){
        $query = $this->db->query("update tbluser_group set user_group_name = '$usergroupname', user_group_status = '$usergroupstatus', modificator_id='$modificatorid', modified_date=NOW() where user_group_id = '$id'");
		if($query){
			return true;
		}else{
			return false;
		}
    }
    
    public function delete($id){
        $query = $this->db->query("delete from tbluser_group where user_group_id ='$id'");
        if($query){
            return true;
		}else{
			return false;
        }
    }
}