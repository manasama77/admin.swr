<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_branch extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }
    
    function last_branch_code()
    {
        $query = $this->db->query("SELECT SUBSTRING(branch_code,10,4) as last_number FROM tblbranch WHERE branch_id = (SELECT max(branch_id) FROM tblbranch)");
        return $query->row();
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT *, case when office_type=1 then 'Pusat' when office_type=2 then 'Cabang' end as office_type, case when branch_status=0 then 'Non Aktif' when branch_status=1 then 'Aktif' end as strbranch_status FROM tblbranch");
        return $query;
	}
	
	public function get_by_id($id){
        $query = $this->db->query("SELECT * FROM tblbranch WHERE branch_id='$id'");
        return $query->row();
    }
    
    public function save_data($officetype,$branchcode,$branchname,$branchaddress,$branchstatus){
        $query = $this->db->query("insert into tblbranch (office_type,branch_code,branch_name,branch_address,branch_status) 
        values('$officetype','$branchcode','$branchname','$branchaddress','$branchstatus')");
		if($query){
			return true;
		}else{
			return false;
		}
    }
	
    public function edit_data($branchname,$branchaddress,$branchstatus,$id){
        $query = $this->db->query("update tblbranch set branch_name = '$branchname', branch_address='$branchaddress', branch_status = '$branchstatus' where branch_id = '$id'");
		if($query){
			return true;
		}else{
			return false;
		}
    }
    
    public function delete($id){
        $query = $this->db->query("delete from tblbranch where branch_id ='$id'");
        if($query){
            return true;
		}else{
			return false;
        }
    }
}