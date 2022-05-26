<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_stock_switch extends CI_Model {
    
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
        $query = $this->db->query("SELECT *, b.branch_name as branch_origin, c.branch_name as branch_destination, CASE WHEN status = 0 THEN 'Draft' WHEN status = 1 THEN 'Final' END as strstatus 
        FROM tblstock_switch a INNER JOIN tblbranch b ON a.branch_origin=b.branch_id
        INNER JOIN tblbranch c ON a.branch_destination=c.branch_id");
        return $query;
	}
	
	public function get_by_id_detail($id){
        $query = $this->db->query("SELECT * FROM tblstock_switch_det a INNER JOIN tblitem b ON a.item_id=b.item_id WHERE a.stock_switch_id='$id'");
        return $query->result();
    }
    
	public function get_by_id_master($id){
        $query = $this->db->query("SELECT * FROM tblstock_switch WHERE stock_switch_id='$id'");
        return $query->row();
    }
    
	public function get_qty_available($branchorigin,$itemid){
        $query = $this->db->query("SELECT count(0) as is_exist FROM tblitem_stock WHERE branch_id='$branchorigin' and item_id='$itemid'");
        $data = $query->row_array();
        $is_exist = $data['is_exist'];
        if($is_exist > 0){
            $query = $this->db->query("SELECT qty as qty_available FROM tblitem_stock WHERE branch_id='$branchorigin' and item_id='$itemid'");
        }
        else{
            $query = $this->db->query("SELECT 0 as qty_available");
        }
        return $query->row_array();
    }
    
	public function get_item($itemcode){
        $query = $this->db->query("SELECT * FROM tblitem WHERE item_code='$itemcode'");
        return $query->row();
    }
    
    public function save_data($branchorigin,$branchdestination,$dtswitchdate,$status,$description,$item,$creatorid){
        $stockswitchid = 0;

        $query = $this->db->query("insert into tblstock_switch (branch_origin,branch_destination,switch_date,status,description,creator_id,created_date) 
        values('$branchorigin','$branchdestination','$dtswitchdate','$status','$description','$creatorid',NOW())");

        $stockswitchid = $this->db->insert_id();

        if($query){
            for ($i = 0; $i < sizeof($item['itemStockItem']); $i++) {
                $itemStockItem = $item['itemStockItem'][$i];
                $itemQtyAvailable = $item['itemQtyAvailable'][$i];
                $itemQtySwitch = $item['itemQtySwitch'][$i];
                $query = $this->db->query("insert into tblstock_switch_det (stock_switch_id,item_id,qty_available,qty_switch,creator_id,created_date) 
                values('$stockswitchid','$itemStockItem','$itemQtyAvailable','$itemQtySwitch','$creatorid',now())");

                if($status == 1){
                    $queryfrom = $this->db->query("update tblitem_stock set qty = qty - '$itemQtySwitch' where branch_id='$branchorigin' and item_id = '$itemStockItem'");
                    if($queryfrom){
                        $query_exist = $this->db->query("select count(0) as is_exist from tblitem_stock where branch_id='$branchdestination' and item_id = '$itemStockItem'");
                        $data_exist = $query_exist->row_array();
                        $is_exist = $data_exist['is_exist'];
                
                        if($is_exist > 0){
                            $query = $this->db->query("update tblitem_stock set qty = qty + '$itemQtySwitch' where branch_id='$branchdestination' and item_id = '$itemStockItem'");
                        }
                        else{
                            $query = $this->db->query("insert into tblitem_stock(branch_id,item_id,qty) values('$branchdestination','$itemStockItem','$itemQtySwitch')");
                        }
                    }
                }
                
				$qtyloop = $itemQtySwitch;
				$queryflow = $this->db->query("select * from tblstock_flow where branch_id='$branchorigin' and item_id='$itemStockItem' and flow_type=1 and qty_now>0 order by stock_flow_id");
				if ($queryflow->num_rows() > 0) {
					foreach ($queryflow->result_array() as $row){
						$flowid = $row['stock_flow_id'];
                        $flowqty = $row['qty_now'];
                        $price = $row['price'];
						
						if($qtyloop >= $flowqty){
                            $query = $this->db->query("update tblstock_flow set qty_now = 0 where stock_flow_id='$flowid'");

                            $query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id) 
                            values('$branchorigin','$itemStockItem',2,NOW(),'$flowqty','$flowqty','$price','stock_switch','$flowid')");

                            $query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id) 
                            values('$branchdestination','$itemStockItem',1,NOW(),'$flowqty','$flowqty','$price','stock_switch','$flowid')");
						}
						else{
                            $query = $this->db->query("update tblstock_flow set qty_now = qty_now - '$qtyloop' where stock_flow_id='$flowid'");

                            $query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id) 
                            values('$branchorigin','$itemStockItem',2,NOW(),'$qtyloop','$qtyloop','$price','stock_switch','$flowid')");

                            $query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id) 
                            values('$branchdestination','$itemStockItem',1,NOW(),'$qtyloop','$qtyloop','$price','stock_switch','$flowid')");
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
	
    public function edit_data($branchorigin,$branchdestination,$status,$description,$item,$modificatorid,$id){
        $query = $this->db->query("update tblstock_switch set status = '$status',description = '$description', modificator_id='$modificatorid', modified_date=NOW() where stock_switch_id = '$id'");
		if($query){
            $query = $this->db->query("delete from tblstock_switch_det where stock_switch_id ='$id'");
            for ($i = 0; $i < sizeof($item['itemStockItem']); $i++) {
                $itemStockItem = $item['itemStockItem'][$i];
                $itemQtyAvailable = $item['itemQtyAvailable'][$i];
                $itemQtySwitch = $item['itemQtySwitch'][$i];
                $query = $this->db->query("insert into tblstock_switch_det (stock_switch_id,item_id,qty_available,qty_switch,creator_id,created_date) 
                values('$stockswitchid','$itemStockItem','$itemQtyAvailable','$itemQtySwitch','$creatorid',now())");

                if($status == 1){
                    $queryfrom = $this->db->query("update tblitem_stock set qty = qty - '$itemQtySwitch' where branch_id='$branchorigin' and item_id = '$itemStockItem'");
                    if($queryfrom){
                        $query_exist = $this->db->query("select count(0) as is_exist from tblitem_stock where branch_id='$branchdestination' and item_id = '$itemStockItem'");
                        $data_exist = $query_exist->row_array();
                        $is_exist = $data_exist['is_exist'];
                
                        if($is_exist > 0){
                            $query = $this->db->query("update tblitem_stock set qty = qty + '$itemQtySwitch' where branch_id='$branchdestination' and item_id = '$itemStockItem'");
                        }
                        else{
                            $query = $this->db->query("insert into tblitem_stock(branch_id,item_id,qty) values('$branchdestination','$itemStockItem','$itemQtySwitch')");
                        }
                    }
                    
					//$query = $this->db->query("insert into tblstock_flow (item_id,flow_type,flow_date,qty_trx,qty_now,price,expired_date,information,reff_trx) values('$itemid',1,NOW(),'$qty','$qty','$buyingprice','$expireddate','stock_switch',null)");
                }
            }
			return true;
		}else{
			return false;
		}
    }
    
    public function delete($id){
        $query = $this->db->query("delete from tblstock_switch where stock_switch_id ='$id'");
        if($query){
            $query = $this->db->query("delete from tblstock_switch_det where stock_switch_id ='$id'");
            return true;
		}else{
			return false;
        }
    }
	
}