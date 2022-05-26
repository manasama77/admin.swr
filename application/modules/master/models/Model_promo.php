<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_promo extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function last_promo_code()
    {
        $query = $this->db->query("SELECT SUBSTRING(promo_code,10,4) as last_number FROM tblitem_promo WHERE item_promo_id = (SELECT max(item_promo_id) FROM tblitem_promo)");
        return $query->row();
    }
    
    function dd_branch()
    {
        $query = $this->db->query("SELECT -1 as branch_id, 'Semua Cabang' as branch_code, '' as branch_name UNION ALL SELECT branch_id, branch_code, branch_name FROM tblbranch");
        return $query;
    }
    
    function dd_branch_only($id)
    {
        $query = $this->db->query("SELECT * FROM tblbranch where branch_id='$id'");
        return $query;
    }
    
    function dd_stock_category()
    {
        $query = $this->db->query("SELECT * FROM tblstock_category");
        return $query;
    }
    
    public function get_item($id){
        $query = $this->db->query("SELECT * FROM tblitem WHERE stock_category_id='$id'");
        return $query->result_array();
      }
  
	public function get_all(){
        $query = $this->db->query("SELECT *, case when a.branch_id=-1 then 'Semua Cabang' else b.branch_name end as branch_name,
        case when a.stock_category_id=-1 then 'Semua Kategori Barang' else c.stock_category_name end as stock_category_name,
        case when a.item_id=-1 then 'Semua Jenis Barang' else d.item_name end as item_name
        FROM tblitem_promo a LEFT JOIN tblbranch b ON a.branch_id=b.branch_id 
        LEFT JOIN tblstock_category c ON a.stock_category_id=c.stock_category_id
        LEFT JOIN tblitem d ON a.item_id=d.item_id");
        return $query;
	}
	
	public function get_by_id($id){
        $query = $this->db->query("SELECT * FROM tblitem_promo WHERE item_promo_id='$id'");
        return $query->row();
    }
    
    public function save_data($promocode,$promoname,$branchid,$stockcategoryid,$itemid,$startperiod,$endperiod,$discpercentage,$discamount,$creatorid){
        $query = $this->db->query("insert into tblitem_promo (promo_code,promo_name,branch_id,stock_category_id,item_id,start_period,end_period,disc_percentage,disc_amount,creator_id,created_date) 
        values('$promocode','$promoname','$branchid','$stockcategoryid','$itemid','$startperiod','$endperiod','$discpercentage','$discamount','$creatorid',NOW())");
		if($query){
			return "success";
		}else{
			return "failed";
		}
    }
	
    public function edit_data($endperiod,$modificatorid,$id){
        $query = $this->db->query("update tblitem_promo set end_period = '$endperiod', modificator_id='$modificatorid', modified_date=NOW() where item_promo_id = '$id'");
		if($query){
			return "success";
		}else{
			return "failed";
		}
    }
    
    public function delete($id){
        $query = $this->db->query("select count(0) as is_exist from tblitem_promo where start_period <= NOW() and item_promo_id='$id'");
        $data = $query->row_array();
        $is_exist = $data['is_exist'];

        if($is_exist > 0){
            return "Cannot delete promo which already used in transaction";
        }
        else{
            $query = $this->db->query("delete from tblitem_promo where item_promo_id ='$id'");
            if($query){
                return "Data Deleted";
            }else{
                return "Failed on Price Delete";
            }
        }
    }

    public function check_promo_exist($itemid,$dtstartperiod,$dtendperiod)
    {
        $query = $this->db->query("select count(0) as is_exist FROM tblitem_promo where item_id = '$itemid' 
            and (
                (start_period <= '$dtstartperiod' and end_period >= '$dtendperiod') or 
                (start_period >= '$dtstartperiod' and end_period <= '$dtendperiod') or 
                (start_period <= '$dtstartperiod' and end_period >= '$dtendperiod' and end_period <= '$dtendperiod') or 
                (start_period >= '$dtstartperiod' and start_period <= '$dtendperiod' and end_period >= '$dtendperiod'))");
        return $query->row();
    }
    
}