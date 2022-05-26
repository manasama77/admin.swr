<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_home extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    public function dd_branch()
    {
        $query = $this->db->query("SELECT * FROM tblbranch");
        return $query;
    }
    
    public function get_login($username,$password){
        $query = $this->db->query("select a.user_id, a.user_group_id, a.fullname, a.branch_id, b.office_type
        from tbluser a inner join tblbranch b on a.branch_id=b.branch_id
        where a.username='$username' and a.password='$password' and a.status=1");
        return $query->row();
    }
    
    public function get_menu($usergroupid){
        $query = $this->db->query("select IFNULL(c.module_name,'') as module_name, IFNULL(c.module_icon,'') as module_icon, b.menu_name, b.menu_url
        from tbluser_access a inner join tblmenu b on a.menu_id=b.menu_id 
        left join tblmodule c on b.module_id=c.module_id
        where a.user_group_id='$usergroupid' and b.status=1 and a.is_access=1
        order by c.data_order, b.data_order");
        return $query;
    }

    public function get_dash($usergroupid){
        $query = $this->db->query("select b.menu_url
        from tbluser_access a inner join tblmenu b on a.menu_id=b.menu_id
        left join tblmodule c on b.module_id=c.module_id
        where a.user_group_id='$usergroupid' and b.status=1 and a.is_access=1
        order by c.data_order, b.data_order
        limit 1");
        return $query->row();
    }
}