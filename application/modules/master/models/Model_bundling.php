<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_bundling extends CI_Model {
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function last_bundling_code()
    {
        $query = $this->db->query("SELECT SUBSTRING(bundling_code,10,4) as last_number FROM tblitem_bundling WHERE item_bundling_id = (SELECT max(item_bundling_id) FROM tblitem_bundling)");
        return $query->row();
    }
    
    function dd_branch()
    {
        $query = $this->db->query("SELECT * FROM tblbranch");
        return $query;
    }
    
    function dd_item()
    {
        $query = $this->db->query("SELECT * FROM tblitem");
        return $query;
    }
    
    public function get_all(){
        $query = $this->db->query("SELECT *, case when status = 0 then 'Draft' when status = 1 then 'Active' else 'InActive' end as strstatus FROM tblitem_bundling");
        return $query;
    }
    
    public function get_by_id_master($id){
        $query = $this->db->query("SELECT *, case when status = 0 then 'Draft' when status = 1 then 'Active' else 'InActive' end as strstatus FROM tblitem_bundling WHERE item_bundling_id='$id'");
        return $query->row();
    }
    
    public function get_by_id_promo($id){
        $query = $this->db->query("SELECT * FROM tblitem_bundling_promo a INNER JOIN tblitem b ON a.item_id = b.item_id WHERE a.item_bundling_id='$id' ORDER BY item_bundling_promo_id");
        return $query;
    }
    
    public function get_by_id_prize($id){
        $query = $this->db->query("SELECT * FROM tblitem_bundling_prize a INNER JOIN tblitem b ON a.item_id = b.item_id WHERE a.item_bundling_id='$id' ORDER BY item_bundling_prize_id");
        return $query;
    }
    
    public function save_data($bundlingcode,$bundlingname,$dtstartperiod,$dtendperiod,$information,$status,$listpromo,$listprize){
        $query = $this->db->query("insert into tblitem_bundling (bundling_code,bundling_name,start_period,end_period,information,status,created_date) values('$bundlingcode','$bundlingname','$dtstartperiod','$dtendperiod','$information','$status',NOW())");
        $id = $this->db->insert_id();
        if($query){
            for ($i = 0; $i < sizeof($listpromo['itemidpromo']); $i++) {
                $remarkpromo = $listpromo['remarkpromo'][$i];
                $itemidpromo = $listpromo['itemidpromo'][$i];
                $qtypromo = $listpromo['qtypromo'][$i];
                $query = $this->db->query("insert into tblitem_bundling_promo (item_bundling_id,remark,item_id,qty,created_date) values('$id','$remarkpromo','$itemidpromo','$qtypromo',NOW())");
            }
			for ($i = 0; $i < sizeof($listprize['itemidprize']); $i++) {
                $remarkprize = $listprize['remarkprize'][$i];
                $itemidprize = $listprize['itemidprize'][$i];
                $qtyprize = $listprize['qtyprize'][$i];
                $discpercent = $listprize['discpercent'][$i];
                $discamount = $listprize['discamount'][$i];
                $fixprice = $listprize['fixprice'][$i];
                $query = $this->db->query("insert into tblitem_bundling_prize (item_bundling_id,remark,item_id,qty,disc_percentage,disc_amount,fix_price,created_date) values('$id','$remarkprize','$itemidprize','$qtyprize','$discpercent','$discamount','$fixprice',NOW())");
            }
            return "success";
        }else{
            return "failed";
        }
    }
    
    public function edit_data($bundlingname,$dtstartperiod,$dtendperiod,$status,$itempromo,$itemprize,$id){
        $query = $this->db->query("update tblitem_bundling set bundling_name = '$bundlingname',start_period = '$dtstartperiod',end_period = '$dtendperiod',status = '$status',modified_date = NOW() where item_bundling_id = '$id'");
        if($query){
            $query = $this->db->query("delete from tblitem_bundling_promo where item_bundling_id ='$id'");
            for ($i = 0; $i < sizeof($item['itemidpromo']); $i++) {
                $remarkpromo = $item['remarkpromo'][$i];
                $itemidpromo = $item['itemidpromo'][$i];
                $qtypromo = $item['qtypromo'][$i];
                $informationpromo = $item['informationpromo'][$i];
                $query = $this->db->query("insert into tblitem_bundling_promo (item_bundling_id,remark,item_id,qty,information,created_date) values('$id','$remarkpromo','$itemidpromo','$qtypromo','$informationpromo',NOW())");
            }
            $query = $this->db->query("delete from tblitem_bundling_prize where item_bundling_id ='$id'");
			for ($i = 0; $i < sizeof($item['itemidprize']); $i++) {
                $remarkprize = $item['remarkprize'][$i];
                $itemidprize = $item['itemidprize'][$i];
                $qtyprize = $item['qtyprize'][$i];
                $discpercent = $item['discpercent'][$i];
                $discamount = $item['discamount'][$i];
                $fixprice = $item['fixprice'][$i];
                $informationprize = $item['informationprize'][$i];
                $query = $this->db->query("insert into tblitem_bundling_prize (item_bundling_id,remark,item_id,qty,disc_percent,disc_amount,fix_price,information,created_date) values('$id','$remarkprize','$itemidprize','$qtyprize','$discpercent','$discamount','$fixprice','$informationprize',NOW())");
            }
            return "success";
        }else{
            return "failed";
        }
    }
    
    public function delete($id){
        $query = $this->db->query("delete from tblitem_bundling where item_bundling_id ='$id'");
        if($query){
            $query = $this->db->query("delete from tblitem_bundling_promo where item_bundling_id ='$id'");
            $query = $this->db->query("delete from tblitem_bundling_prize where item_bundling_id ='$id'");
            return "success";
        }else{
            return "failed";
        }
    }

    public function check_bundling_exist($itemid,$dtstartperiod,$dtendperiod){
        $query = $this->db->query("select count(0) as is_exist from tblitem_bundling where item_id = '$itemid' 
            and (
                (start_period <= '$dtstartperiod' and end_period >= '$dtendperiod') or 
                (start_period >= '$dtstartperiod' and end_period <= '$dtendperiod') or 
                (start_period <= '$dtstartperiod' and end_period >= '$dtendperiod' and end_period <= '$dtendperiod') or 
                (start_period >= '$dtstartperiod' and start_period <= '$dtendperiod' and end_period >= '$dtendperiod'))");
        return $query->row();
    }
}