<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_user extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function dd_usergroup()
    {
        $query = $this->db->query("SELECT * FROM tbluser_group");
        return $query;
    }
    
    function dd_branch()
    {
        $query = $this->db->query("SELECT * FROM tblbranch");
        return $query;
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT a.user_id, b.user_group_name, a.fullname, a.phone, a.email
        FROM tbluser a INNER JOIN tbluser_group b ON a.user_group_id = b.user_group_id 
        INNER JOIN tblbranch c on a.branch_id=c.branch_id
        ORDER BY b.user_group_name, a.fullname, a.phone, a.email");
        return $query;
	}
	
	public function get_username($username,$logincode){
        $query = $this->db->query("SELECT count(0) as is_exist FROM tbluser WHERE username='$username' or login_code='$logincode'");
        return $query->row();
    }
    
	public function get_by_id($id){
        $query = $this->db->query("SELECT * FROM tbluser a INNER JOIN tbluser_group b ON a.user_group_id = b.user_group_id WHERE a.user_id='$id'");
        return $query->row();
    }
    
    public function save_data($usergroupid,$branchid,$fullname,$phone,$email,$address,$username,$password,$logincode,$status,$creatorid){
        $query = $this->db->query("insert into tbluser (user_group_id,branch_id,fullname,phone,email,address,username,password,login_code,status,creator_id,created_date) 
        values('$usergroupid','$branchid','$fullname','$phone','$email','$address','$username','$password','$logincode','$status','$creatorid',NOW())");

		if($query){
			return "success";
		}else{
			return "failed";
		}
    }
	
    public function edit_data($branchid,$fullname,$phone,$email,$address,$username,$password,$logincode,$status,$modificatorid,$id){
        $query = $this->db->query("update tbluser set branch_id = '$branchid',fullname = '$fullname',phone = '$phone',email = '$email',address = '$address',username = '$username',password = '$password',login_code = '$logincode',status = '$status', modificator_id='$modificatorid', modified_date=NOW() where user_id = '$id'");
		if($query){
			return "success";
		}else{
			return "failed";
		}
    }
    
    public function delete($id){
        $query = $this->db->query("delete from tbluser where user_id ='$id'");
        if($query){
            return "success";
        }else{
            return "failed";
        }
    }
}