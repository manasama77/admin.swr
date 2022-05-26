<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_user_access extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT * FROM tbluser_group");
        return $query;
	}
	
	public function get_by_id($id){
        $query = $this->db->query("SELECT * FROM tbluser_group WHERE user_group_id='$id'");
        return $query->row();
    }
    
    public function get_access($usergroupid,$moduleid){
        $query = $this->db->query("SELECT a.menu_id, a.menu_name, IFNULL(b.is_access,0) as is_access
        FROM tblmenu a left join tbluser_access b on a.menu_id=b.menu_id AND b.user_group_id='$usergroupid'
        WHERE a.status=1 AND a.module_id='$moduleid'");
        return $query->result();
    }
    
    public function edit_data($activemenu,$modificatorid,$usergroupid){
        $query = $this->db->query("update tbluser_access set is_access = 0, modificator_id='$modificatorid', modified_date=NOW() where user_group_id = '$usergroupid'");

        $arr_activemenu = explode(",",$activemenu);
        foreach($arr_activemenu as $activemenu){
            $query = $this->db->query("update tbluser_access set is_access = 1, modificator_id='$modificatorid', modified_date=NOW() where user_group_id = '$usergroupid' and menu_id = '$activemenu'");
        }
        
		if($query){
			return true;
		}else{
			return false;
		}
    }
    
}