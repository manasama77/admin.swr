<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_stock_adj extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function dd_branch()
    {
        $query = $this->db->query("SELECT branch_id, branch_code, branch_name FROM tblbranch");
        return $query;
    }
    
    function dd_branch_only($id)
    {
        $query = $this->db->query("SELECT * FROM tblbranch where branch_id='$id'");
        return $query;
    }
    
    function dd_item()
    {
        $query = $this->db->query("SELECT * FROM tblitem order by item_name");
        return $query;
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT *, a.created_date as adj_date, CASE WHEN a.adj_type = 1 THEN 'Penambahan' WHEN a.adj_type = 2 THEN 'Pengurangan' END as stradj_type FROM tblstock_adj a INNER JOIN tblitem b ON a.item_id = b.item_id LEFT JOIN tblbranch c ON a.branch_id = c.branch_id");
        return $query;
	}
	
	public function get_by_id($id){
        $query = $this->db->query("SELECT * FROM tblstock_adj WHERE stock_adj_id='$id'");
        return $query->row();
	}
	
	function search_price($branchid,$itemid)
    {
        $query_exist1 = $this->db->query("SELECT count(0) as is_exist FROM tblitem_price WHERE item_id = '$itemid' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        $data_exist1 = $query_exist1->row_array();
        $is_exist1 = $data_exist1['is_exist'];

        if($is_exist1 > 0){
            $query = $this->db->query("SELECT buying_price FROM tblitem_price WHERE item_id = '$itemid' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') ORDER BY start_period desc LIMIT 1");
        }
        else{
            $query = $this->db->query("SELECT 0 as buying_price ");
        }
            
        return $query->row();
    }
    
    public function save_data($branchid,$itemid,$adjqty,$adjtype,$buyingprice,$description,$creatorid){
		$query = $this->db->query("insert into tblstock_adj (branch_id,item_id,adj_number,adj_type,buying_price,description,creator_id,created_date) 
		values('$branchid','$itemid','$adjqty','$adjtype','$buyingprice','$description','$creatorid',NOW())");
		if($query){
            if($adjtype == 1){
				$query_exist = $this->db->query("select count(0) as is_exist from tblitem_stock where branch_id='$branchid' and item_id = '$itemid'");
				$data_exist = $query_exist->row_array();
				$is_exist = $data_exist['is_exist'];
		
				if($is_exist > 0){
					$query = $this->db->query("update tblitem_stock set qty = qty + '$adjqty' where branch_id='$branchid' and item_id = '$itemid'");
				}
				else{
					$query = $this->db->query("insert into tblitem_stock(branch_id,item_id,qty) values('$branchid','$itemid','$adjqty')");
				}
                
				$query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id,reff_trx) 
				values('$branchid','$itemid',1,NOW(),'$adjqty','$adjqty','$buyingprice','stock_adjustment',null,null)");

            }elseif($adjtype == 2){
				$query_exist = $this->db->query("select count(0) as is_exist from tblitem_stock where branch_id='$branchid' and item_id = '$itemid'");
				$data_exist = $query_exist->row_array();
				$is_exist = $data_exist['is_exist'];
		
				if($is_exist > 0){
					$query = $this->db->query("update tblitem_stock set qty = qty - '$adjqty' where branch_id='$branchid' and item_id = '$itemid'");
				}
				else{
					$qty = $adjqty * -1;
					$query = $this->db->query("insert into tblitem_stock(branch_id,item_id,qty) values('$branchid','$itemid','$qty')");
				}
                
				$qtyloop = $adjqty;
				$queryflow = $this->db->query("select * from tblstock_flow where item_id='$itemid' and flow_type=1 and qty_now>0 order by stock_flow_id");
				if ($queryflow->num_rows() > 0) {
					foreach ($queryflow->result_array() as $row){
						$flowid = $row['stock_flow_id'];
						$flowqty = $row['qty_now'];
						$price = $row['price'];
						
						if($qtyloop >= $flowqty){
							$query = $this->db->query("update tblstock_flow set qty_now = 0 where stock_flow_id='$flowid'");

							$query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id,reff_trx) 
							values('$branchid','$itemid',2,NOW(),'$flowqty','$flowqty','$price','stock_adjustment','$flowid',null)");
							
						}
						else{
							$query = $this->db->query("update tblstock_flow set qty_now = qty_now - '$qtyloop' where stock_flow_id='$flowid'");
							
							$query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id,reff_trx) 
							values('$branchid','$itemid',2,NOW(),'$qtyloop','$qtyloop','$price','stock_adjustment','$flowid',null)");
							
						}
						
						$qtyloop = $qtyloop - $flowqty;
						
						if($qtyloop <= 0){
							break;
						}
					}
				}
				
            }
			return true;
		}else{
			return false;
		}
    }
}