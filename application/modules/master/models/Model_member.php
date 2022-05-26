<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_member extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function last_member_code()
    {
        $query = $this->db->query("SELECT SUBSTRING(member_code,10,4) as last_number FROM tblmember WHERE member_id = (SELECT max(member_id) FROM tblmember)");
        return $query->row();
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT member_id, member_code, fullname, case when status = 1 then 'Aktif' else 'Non Aktif' end as strstatus FROM tblmember order by member_code");
        return $query;
	}
	
	public function get_by_id($id){
        $query = $this->db->query("SELECT * FROM tblmember WHERE member_id='$id'");
        return $query->row();
    }
    
    public function save_data($membercode,$fullname,$phone,$email,$address,$identitytype,$identityid,$status,$creatorid){
        $query = $this->db->query("insert into tblmember (member_code,fullname,phone,email,address,identity_type,identity_id,status,creator_id,created_date) 
        values('$membercode','$fullname','$phone','$email','$address','$identitytype','$identityid','$status','$creatorid',NOW())");
		if($query){
			return true;
		}else{
			return false;
		}
    }
    
    public function update_data_excel($membercode,$fullname,$phone,$email,$address,$identitytype,$identityid,$limittransaction,$status){
        $query = $this->db->query("update tblmember set fullname = '$fullname',phone = '$phone',email = '$email',address = '$address',identity_type='$identitytype',identity_id='$identityid',limit_transaction = '$limittransaction',current_limit = '$limittransaction',status='$status' where member_code = '$membercode'");
		if($query){
			return "success";
		}else{
			return "failed";
		}
    }
    
    public function update_data($fullname,$phone,$email,$address,$identitytype,$identityid,$status,$modificatorid,$id){
        $query = $this->db->query("update tblmember set fullname = '$fullname',phone = '$phone',email = '$email',address = '$address', identity_type='$identitytype', identity_id='$identityid',status='$status' where member_id = '$id'");
		if($query){
			return true;
		}else{
			return false;
		}
    }
    
    public function delete($id){
        $query = $this->db->query("delete from tblmember where member_id ='$id'");
        if($query){
            return true;
		}else{
			return false;
        }
    }

    public function reset_limit($id){
        $query = $this->db->query("update tblmember set current_limit = limit_transaction where member_id ='$id'");
        if($query){
            return "Successfully reset Current Limit";
        }else{
            return "Failed on reset Current Limit";
        }
    }

    public function check_membercode_exist($membercode){
        $query = $this->db->query("select count(0) as is_exist from tblmember where member_code ='$membercode'");
        return $query->row();
    }
}