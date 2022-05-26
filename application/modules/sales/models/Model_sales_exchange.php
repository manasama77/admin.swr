<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_sales_exchange extends CI_Model {
    
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
        $query = $this->db->query("SELECT * FROM tblitem");
        return $query;
    }
    
    function last_trans_number()
    {
        $query = $this->db->query("SELECT SUBSTRING(sales_exchange_number,10,4) as last_number 
        FROM tblsales_exchange 
        WHERE sales_exchange_id = (SELECT max(sales_exchange_id) FROM tblsales_exchange WHERE YEAR(created_date)=YEAR(NOW()) AND MONTH(created_date)=MONTH(NOW()))");
        return $query->row();
    }
    
    function validate_logincode($logincode)
    {
        $query = $this->db->query("SELECT * FROM tbluser WHERE login_code = '$logincode' and status=1");
        return $query->row();
    }
    
	public function get_all(){
        $query = $this->db->query("SELECT *, CASE WHEN status = 0 THEN 'Draft' WHEN status = 1 THEN 'Final' END as strstatus 
        FROM tblsales_exchange a INNER JOIN tblbranch b ON a.branch_id=b.branch_id");
        return $query;
	}
	
	public function get_by_id_master($id){
        $query = $this->db->query("SELECT * FROM tblsales_exchange WHERE sales_exchange_id='$id'");
        return $query->row();
    }
    
	public function get_sales($salesnumber){
        $query = $this->db->query("SELECT a.sales_id, b.branch_name, a.sales_number, a.created_date, c.fullname, d.sales_exchange_limit, a.total_price, a.total_disc, a.total_transaction, a.payment, a.exchange, 
        case when a.payment_type=1 then 'Tunai' when a.payment_type=2 then 'Kartu Debit' when a.payment_type=3 then 'Kartu Kredit' end as str_payment_type, 
        datediff(now(),a.created_date) as date_diff
        FROM tblsales a inner join tblbranch b on a.branch_id=b.branch_id 
        inner join tbluser c on a.creator_id=c.user_id 
        cross join tblcompany_setting d
        WHERE a.sales_number='$salesnumber'");
        return $query->row_array();
    }
    
	public function get_sales_det($salesid){
        $query = $this->db->query("SELECT a.sales_det_id, b.item_id, b.item_name, a.price, a.qty, a.extra_disc, IFNULL(c.qty_exchange,0) as qty_exchange
        FROM tblsales_det a inner join tblitem b on a.item_id=b.item_id 
        left join (select b.sales_det_id, sum(b.qty_exchange) as qty_exchange from tblsales_exchange a inner join tblsales_exchange_det b on a.sales_exchange_id=b.sales_exchange_id group by b.sales_det_id) c on a.sales_det_id=c.sales_det_id
        WHERE a.sales_id='$salesid'");
        return $query->result_array();
    }
    
	public function get_qty_available($branchid,$itemid){
        $query = $this->db->query("SELECT count(0) as is_exist FROM tblitem_stock WHERE branch_id='$branchid' and item_id='$itemid'");
        $data = $query->row_array();
        $is_exist = $data['is_exist'];
        if($is_exist > 0){
            $query = $this->db->query("SELECT qty as qty_available FROM tblitem_stock WHERE branch_id='$branchid' and item_id='$itemid'");
        }
        else{
            $query = $this->db->query("SELECT 0 as qty_available");
        }
        return $query->row_array();
    }
    
    function search_price($branchid,$itemid)
    {
        $query_exist1 = $this->db->query("SELECT count(0) as is_exist FROM tblitem_price WHERE item_id = '$itemid' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d')");
        $data_exist1 = $query_exist1->row_array();
        $is_exist1 = $data_exist1['is_exist'];

        if($is_exist1 > 0){
            $query = $this->db->query("SELECT selling_price FROM tblitem_price WHERE item_id = '$itemid' AND start_period<=DATE_FORMAT(NOW(),'%Y-%m-%d') ORDER BY start_period desc LIMIT 1");
        }
        else{
            $query = $this->db->query("SELECT 0 as selling_price ");
        }
            
        return $query->row_array();
    }
    
	public function get_by_id_detail($id){
        $query = $this->db->query("SELECT *, b.item_name as item_origin_name, c.item_name as item_exchange_name
        FROM tblsales_exchange_det a INNER JOIN tblitem b ON a.item_origin=b.item_id 
        INNER JOIN tblitem c ON a.item_exchange=c.item_id 
        WHERE a.sales_exchange_id='$id'");
        return $query->result();
    }
    
	public function get_item($itemcode){
        $query = $this->db->query("SELECT * FROM tblitem WHERE item_code='$itemcode'");
        return $query->row();
    }
    
    function save_data($branchid,$salesexchangenumber,$salesnumber,$totaltrans,$payment,$exchange,$description,$item,$creatorid)
    {
        $salesexchangeid = 0;
        $query = $this->db->query("insert into tblsales_exchange (branch_id,sales_exchange_number,sales_number,total_transaction,payment,exchange,description,creator_id,created_date) 
        values('$branchid','$salesexchangenumber','$salesnumber','$totaltrans','$payment','$exchange','$description','$creatorid',NOW())");

        if($query){
            $salesexchangeid = $this->db->insert_id();
            
            for ($i = 0; $i < sizeof($item['itemSalesDetId']); $i++) {
                $itemSalesDetId = $item['itemSalesDetId'][$i];
                $itemBuyingItemId = $item['itemBuyingItemId'][$i];
                $itemBuyingPrice = $item['itemBuyingPrice'][$i];
                $itemBuyingQty = $item['itemBuyingQty'][$i];
                $itemBuyingDisc = $item['itemBuyingDisc'][$i];
                $itemExchangeItem = $item['itemExchangeItem'][$i];
                $itemStockQty = $item['itemStockQty'][$i];
                $itemExchangeQty = $item['itemExchangeQty'][$i];
                $itemExtraPayment = $item['itemExtraPayment'][$i];

                $querydetail = $this->db->query("insert into tblsales_exchange_det (sales_exchange_id,sales_det_id,item_origin,buying_price,qty_origin,buying_disc,item_exchange,qty_stock,qty_exchange,extra_payment,creator_id,created_date) 
                values('$salesexchangeid','$itemSalesDetId','$itemBuyingItemId','$itemBuyingPrice','$itemBuyingQty','$itemBuyingDisc','$itemExchangeItem','$itemStockQty','$itemExchangeQty','$itemExtraPayment','$creatorid',NOW())");
    
                // flow masuk
                if($querydetail){
                    $query_check = $this->db->query("select * from tblitem_stock where branch_id='$branchid' and item_id = '$itemBuyingItemId'");
                    if ($query_check->num_rows() > 0){
                        $query_check = $this->db->query("update tblitem_stock set qty = qty + '$itemExchangeQty' where branch_id='$branchid' and item_id = '$itemBuyingItemId'");
                    }
                    else{
                        $query = $this->db->query("insert into tblitem_stock(branch_id,item_id,qty) values('$branchid','$itemBuyingItemId','$itemExchangeQty')");
                    }

                    $query_flow_in = $this->db->query("select b.price from tblstock_flow a inner join tblstock_flow b on a.reff_id=b.stock_flow_id where a.reff_trx='$salesnumber'");
                    $data_exist = $query_flow_in->row_array();
                    $BasePrice = $data_exist['price'];

                    $transnumber = $salesexchangenumber . '-' . $i;
                    $query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id,reff_trx) 
                    values('$branchid','$itemBuyingItemId',1,NOW(),'$itemExchangeQty','$itemExchangeQty','$BasePrice','stock_exchange',null,'$transnumber')");

                }
                
                // flow keluar
                $query = $this->db->query("update tblitem_stock set qty = qty - '$itemExchangeQty' where branch_id='$branchid' and item_id = '$itemExchangeItem'");

				$qtyloop = $itemExchangeQty;
				$queryflow = $this->db->query("select * from tblstock_flow where branch_id='$branchid' and item_id='$itemExchangeItem' and flow_type=1 and qty_now>0 order by stock_flow_id");
				if ($queryflow->num_rows() > 0) {
					foreach ($queryflow->result_array() as $row){
						$flowid = $row['stock_flow_id'];
                        $flowqty = $row['qty_now'];
                        $soldprice = $itemExtraPayment / $itemExchangeQty;
						
                        $transnumber = $salesexchangenumber . '-' . $i;
						if($qtyloop >= $flowqty){
                            $query = $this->db->query("update tblstock_flow set qty_now = 0 where stock_flow_id='$flowid'");
                            
                            $query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id,reff_trx) 
                            values('$branchid','$itemExchangeItem',2,NOW(),'$itemExchangeQty','$itemExchangeQty','$soldprice','stock_exchange','$flowid','$transnumber')");
						}
						else{
                            $query = $this->db->query("update tblstock_flow set qty_now = qty_now - '$qtyloop' where stock_flow_id='$flowid'");
                            
                            $query = $this->db->query("insert into tblstock_flow (branch_id,item_id,flow_type,flow_date,qty_trx,qty_now,price,information,reff_id,reff_trx) 
                            values('$branchid','$itemExchangeItem',2,NOW(),'$itemExchangeQty','$itemExchangeQty','$soldprice','stock_exchange','$flowid','$transnumber')");
						}
						
						$qtyloop = $qtyloop - $flowqty;
						
						if($qtyloop <= 0){
							break;
						}
					}
				}
				
            }
            
            $stockinid = 0;
            $query = $this->db->query("insert into tblstock_in (branch_id,supplier_id,doc_number,stock_date,status,description,creator_id,created_date) 
            values('$branchid','0','$salesexchangenumber',NOW(),1,'$description','$creatorid',NOW())");

            if($query){
                $stockinid = $this->db->insert_id();
                for ($i = 0; $i < sizeof($item['itemBuyingItemId']); $i++) {
                    $itemBuyingItemId = $item['itemBuyingItemId'][$i];
                    $itemExchangeQty = $item['itemExchangeQty'][$i];
                    $query = $this->db->query("insert into tblstock_in_det (stock_in_id,item_id,qty,creator_id,created_date) 
                    values('$stockinid','$itemBuyingItemId','$itemExchangeQty','$creatorid',now())");
                }
            }
        
            $stockoutid = 0;
            $querystockout = $this->db->query("insert into tblstock_out (branch_id,doc_number,stock_date,status,creator_id,created_date) 
            values('$branchid','$salesexchangenumber',NOW(),1,'$creatorid',NOW())");

            if($querystockout){
                $stockoutid = $this->db->insert_id();
                for ($i = 0; $i < sizeof($item['itemExchangeItem']); $i++) {
                    $itemExchangeItem = $item['itemExchangeItem'][$i];
                    $itemExchangeQty = $item['itemExchangeQty'][$i];
                    $querydetail = $this->db->query("insert into tblstock_out_det (stock_out_id,item_id,qty,creator_id,created_date)
                     values('$stockoutid','$itemExchangeItem','$itemExchangeQty','$creatorid',NOW())");
                }
            }
			
			return true;
		}else{
			return false;
		}
    }
    
    function get_header($salesexchangenumber){
        $query = $this->db->query("SELECT a.sales_exchange_number, a.created_date as sales_exchange_date, a.total_transaction, a.payment, a.exchange, b.branch_name, b.branch_address, c.fullname as cashier_name, d.sales_notes
        FROM tblsales_exchange a LEFT JOIN tblbranch b ON a.branch_id=b.branch_id LEFT JOIN tbluser c ON a.creator_id=c.user_id CROSS JOIN tblcompany_setting d
        WHERE a.sales_exchange_number='$salesexchangenumber'");
        return $query->row();
    }

	function get_report($salesexchangenumber){
        $query = "SELECT c.item_name as item_origin, d.item_name as item_exchange, b.qty_exchange, (b.extra_payment / b.qty_exchange) as single_extra, b.extra_payment
        FROM tblsales_exchange a INNER JOIN tblsales_exchange_det b ON a.sales_exchange_id=b.sales_exchange_id 
        INNER JOIN tblitem c ON b.item_origin=c.item_id 
        INNER JOIN tblitem d ON b.item_exchange=d.item_id
        WHERE a.sales_exchange_number='$salesexchangenumber'";
        $data = $this->db->query($query);
        return $data;
    }
    
    /*
    public function save_data($branchid,$dtsalesdate,$status,$description,$item,$creatorid){
        $salesexchangeid = 0;

        $query = $this->db->query("insert into tblsales_exchange (branch_id,sales_date,status,description,creator_id,created_date) 
        values('$branchid','$dtsalesdate','$status','$description','$creatorid',NOW())");

        $salesexchangeid = $this->db->insert_id();

        if($query){
            for ($i = 0; $i < sizeof($item['itemStockItemOrigin']); $i++) {
                $itemStockItemOrigin = $item['itemStockItemOrigin'][$i];
                $itemStockItemExchange = $item['itemStockItemExchange'][$i];
                $itemQtyStock = $item['itemQtyStock'][$i];
                $itemQtyExchange = $item['itemQtyExchange'][$i];
                $query = $this->db->query("insert into tblsales_exchange_det (sales_exchange_id,item_origin,item_exchange,qty_stock,qty_exchange,creator_id,created_date) 
                values('$salesexchangeid','$itemStockItemOrigin','$itemStockItemExchange','$itemQtyStock','$itemQtyExchange','$creatorid',now())");

                if($status == 1){
                    $queryfrom = $this->db->query("update tblitem_stock set qty = qty - '$itemQtyExchange' where branch_id='$branchid' and item_id = '$itemStockItemExchange'");
                    if($queryfrom){
                        $query_exist = $this->db->query("select count(0) as is_exist from tblitem_stock where branch_id='$branchid' and item_id = '$itemStockItemOrigin'");
                        $data_exist = $query_exist->row_array();
                        $is_exist = $data_exist['is_exist'];
                
                        if($is_exist > 0){
                            $query = $this->db->query("update tblitem_stock set qty = qty + '$itemQtyExchange' where branch_id='$branchid' and item_id = '$itemStockItemOrigin'");
                        }
                        else{
                            $query = $this->db->query("insert into tblitem_stock(branch_id,item_id,qty) values('$branchid','$itemStockItemOrigin','$itemQtyExchange')");
                        }
                    }
                    
					//$query = $this->db->query("insert into tblstock_flow (item_id,flow_type,flow_date,qty_trx,qty_now,price,expired_date,information,reff_trx) values('$itemid',1,NOW(),'$qty','$qty','$buyingprice','$expireddate','sales_exchange','$docnumber')");
                }
            }
			return true;
		}else{
			return false;
		}
    }
	*/
    public function edit_data($branchid,$status,$description,$item,$modificatorid,$id){
        $query = $this->db->query("update tblsales_exchange set status = '$status',description = '$description', modificator_id='$modificatorid', modified_date=NOW() where sales_exchange_id = '$id'");
		if($query){
            $query = $this->db->query("delete from tblsales_exchange_det where sales_exchange_id ='$id'");
            for ($i = 0; $i < sizeof($item['itemStockItemOrigin']); $i++) {
                $itemStockItemOrigin = $item['itemStockItemOrigin'][$i];
                $itemStockItemExchange = $item['itemStockItemExchange'][$i];
                $itemQtyStock = $item['itemQtyStock'][$i];
                $itemQtyExchange = $item['itemQtyExchange'][$i];
                $query = $this->db->query("insert into tblsales_exchange_det (sales_exchange_id,item_origin,item_exchange,qty_stock,qty_exchange,creator_id,created_date) 
                values('$salesexchangeid','$itemStockItemOrigin','$itemStockItemExchange','$itemQtyStock','$itemQtyExchange','$creatorid',now())");

                if($status == 1){
                    $queryfrom = $this->db->query("update tblitem_stock set qty = qty - '$itemQtyExchange' where branch_id='$branchid' and item_id = '$itemStockItemExchange'");
                    if($queryfrom){
                        $query_exist = $this->db->query("select count(0) as is_exist from tblitem_stock where branch_id='$branchid' and item_id = '$itemStockItemOrigin'");
                        $data_exist = $query_exist->row_array();
                        $is_exist = $data_exist['is_exist'];
                
                        if($is_exist > 0){
                            $query = $this->db->query("update tblitem_stock set qty = qty + '$itemQtyExchange' where branch_id='$branchid' and item_id = '$itemStockItemOrigin'");
                        }
                        else{
                            $query = $this->db->query("insert into tblitem_stock(branch_id,item_id,qty) values('$branchid','$itemStockItemOrigin','$itemQtyExchange')");
                        }
                    }
                    
					//$query = $this->db->query("insert into tblstock_flow (item_id,flow_type,flow_date,qty_trx,qty_now,price,expired_date,information,reff_trx) values('$itemid',1,NOW(),'$qty','$qty','$buyingprice','$expireddate','sales_exchange','$docnumber')");
                }
            }
			return true;
		}else{
			return false;
		}
    }
    
    public function delete($id){
        $query = $this->db->query("delete from tblsales_exchange where sales_exchange_id ='$id'");
        if($query){
            $query = $this->db->query("delete from tblsales_exchange_det where sales_exchange_id ='$id'");
            return true;
		}else{
			return false;
        }
    }
	
    public function check_docnumber_exist($docnumber){
        $query = $this->db->query("select count(0) as is_exist from tblsales_exchange where doc_number ='$docnumber'");
        return $query->row();
    }
}