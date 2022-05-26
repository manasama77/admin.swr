<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_stock_unit extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function last_unit_code()
    {
        $query = $this->db->query("SELECT SUBSTRING(unit_code,10,4) as last_number FROM tblunit WHERE unit_id = (SELECT max(unit_id) FROM tblunit)");
        return $query->row();
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT * FROM tblunit");
        return $query;
	}
	
	public function get_by_id($id){
        $query = $this->db->query("SELECT * FROM tblunit WHERE unit_id='$id'");
        return $query->row();
    }
    
    public function save_data($unitcode,$unitname,$creatorid){
        $query = $this->db->query("insert into tblunit (unit_code,unit_name,creator_id,created_date) values('$unitcode','$unitname','$creatorid',NOW())");
		if($query){
			return true;
		}else{
			return false;
		}
    }
	
    public function update_data_excel($unitcode,$unitname){
        $query = $this->db->query("update tblunit set unit_name = '$unitname' where unit_code = '$unitcode'");
		if($query){
			return "success";
		}else{
			return "failed";
		}
    }
    
    public function edit_data($unitname,$modificatorid,$id){
        $query = $this->db->query("update tblunit set unit_name = '$unitname', modificator_id='$modificatorid', modified_date=NOW() where unit_id = '$id'");
		if($query){
			return true;
		}else{
			return false;
		}
    }
    
    public function delete($id){
        $query = $this->db->query("select count(0) as is_exist from tblitem where unit_id ='$id'");
        $data = $query->row_array();
        $is_exist = $data['is_exist'];
        if($is_exist > 0){
            return false;
        }
        else{
            $query = $this->db->query("delete from tblunit where unit_id ='$id'");
            if($query){
                return true;
		}else{
			return false;
            }
        }
    }

    public function check_stockunitcode_exist($stockunitcode){
        $query = $this->db->query("select count(0) as is_exist from tblunit where unit_code ='$stockunitcode'");
        return $query->row();
    }
}