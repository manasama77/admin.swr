<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_stock_category extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function last_stock_category_code()
    {
        $query = $this->db->query("SELECT SUBSTRING(stock_category_code,10,4) as last_number FROM tblstock_category WHERE stock_category_id = (SELECT max(stock_category_id) FROM tblstock_category)");
        return $query->row();
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT * FROM tblstock_category");
        return $query;
	}
	
	public function get_by_id($id){
        $query = $this->db->query("SELECT * FROM tblstock_category WHERE stock_category_id='$id'");
        return $query->row();
    }
    
    public function save_data($stockcategorycode,$stockcategoryname,$creatorid){
        $query = $this->db->query("insert into tblstock_category (stock_category_code,stock_category_name,creator_id,created_date) values('$stockcategorycode','$stockcategoryname','$creatorid',NOW())");
		if($query){
			return true;
		}else{
			return false;
		}
    }
	
    public function update_data_excel($stockcategorycode,$stockcategoryname){
        $query = $this->db->query("update tblstock_category set stock_category_name = '$stockcategoryname' where stock_category_code = '$stockcategorycode'");
		if($query){
			return "success";
		}else{
			return "failed";
		}
    }
    
    public function edit_data($stockcategoryname,$modificatorid,$id){
        $query = $this->db->query("update tblstock_category set stock_category_name = '$stockcategoryname', modificator_id='$modificatorid', modified_date=NOW() where stock_category_id = '$id'");
		if($query){
			return true;
		}else{
			return false;
		}
    }
    
    public function delete($id){
        $query = $this->db->query("select count(0) as is_exist from tblitem where stock_category_id ='$id'");
        $data = $query->row_array();
        $is_exist = $data['is_exist'];
        if($is_exist > 0){
            return false;
        }
        else{
            $query = $this->db->query("delete from tblstock_category where stock_category_id ='$id'");
            if($query){
                return true;
            }else{
                return false;
            }
        }
    }

    public function check_stockcategorycode_exist($stockcategorycode){
        $query = $this->db->query("select count(0) as is_exist from tblstock_category where stock_category_code ='$stockcategorycode'");
        return $query->row();
    }
}