<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_sales_inv_report extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function dd_item()
    {
        $query = $this->db->query("SELECT * FROM tblitem");
        return $query;
    }
    
    function get_header($startperiod,$endperiod){
        $query = $this->db->query("SELECT '$startperiod' as startperiod, '$endperiod' as endperiod");
        return $query->row();
    }

	function get_report($startperiod,$endperiod,$itemid){
        $whereall = "";
        if($itemid > 0){
            $whereall = $whereall . " WHERE a.item_id = '$itemid' ";
        }

        $query = "select b.stock_category_name, a.barcode, a.item_code, a.item_name, c.unit_code, c.unit_name, "
                . "IFNULL(d.beginning_qty,0) as beginning_qty, IFNULL(d.beginning_price,0) as beginning_price, IFNULL((d.beginning_qty*d.beginning_price),0) as beginning_total, "
                . "IFNULL(e.stock_in_qty,0) as stock_in_qty, IFNULL(e.stock_in_price,0) as stock_in_price, IFNULL((e.stock_in_qty*e.stock_in_price),0) as stock_in_total, "
                . "IFNULL(f.stock_adj_qty,0) as stock_adj_qty, IFNULL(f.stock_adj_price,0) as stock_adj_price, IFNULL((f.stock_adj_qty*f.stock_adj_price),0) as stock_adj_total, "
                . "IFNULL(g.sales_mem_qty,0) as sales_mem_qty, IFNULL(g.sales_mem_price,0) as sales_mem_price, IFNULL((g.sales_mem_qty*g.sales_mem_price),0) as sales_mem_total, "
                . "IFNULL(h.sales_pub_qty,0) as sales_pub_qty, IFNULL(h.sales_pub_price,0) as sales_pub_price, IFNULL((h.sales_pub_qty*h.sales_pub_price),0) as sales_pub_total, "
                . "(IFNULL(g.sales_mem_qty,0)+IFNULL(h.sales_pub_qty,0)) as all_sales_qty, (IFNULL((g.sales_mem_qty*g.sales_mem_price),0)+IFNULL((h.sales_pub_qty*h.sales_pub_price),0)) as all_sales_total, "
                . "IFNULL(i.remaining_qty,0) as remaining_qty, IFNULL(i.remaining_price,0) as remaining_price, IFNULL((i.remaining_qty*i.remaining_price),0) as remaining_total "
                . "from tblitem a inner join tblstock_category b on a.stock_category_id = b.stock_category_id "
                . "inner join tblunit c on a.unit_id = c.unit_id "
                . "left join ( "
                . "    select item_id, SUM(qty_trx) as beginning_qty, price as beginning_price "
                . "    from tblstock_flow "
                . "    where flow_type=1 and flow_date<'$startperiod' "
                . "    group by item_id, price, expired_date "
                . ") d on a.item_id=d.item_id "
                . "left join ( "
                . "    select item_id, SUM(qty_trx) as stock_in_qty, price as stock_in_price "
                . "    from tblstock_flow "
                . "    where flow_type=1 and flow_date>='$startperiod' and flow_date<='$endperiod' "
                . "    group by item_id, price, expired_date "
                . ") e on a.item_id=e.item_id "
                . "left join ( "
                . "    select item_id, SUM(case when flow_type=1 then qty_trx else qty_trx*(-1) end) as stock_adj_qty, price as stock_adj_price "
                . "    from tblstock_flow "
                . "    where information='stock_adjustment' and flow_date>='$startperiod' and flow_date<='$endperiod' "
                . "    group by item_id, price, expired_date "
                . ") f on a.item_id=f.item_id "
                . "left join ( "
                . "    select a.item_id, SUM(a.qty_trx) as sales_mem_qty, a.price as sales_mem_price "
                . "    from tblstock_flow a inner join tblsales b on a.reff_trx=b.sales_number "
                . "    where a.flow_type=2 and a.flow_date>='$startperiod' and a.flow_date<='$endperiod' and b.member_id<>0 "
                . "    group by a.item_id, a.price "
                . ") g on a.item_id=g.item_id "
                . "left join ( "
                . "    select a.item_id, SUM(a.qty_trx) as sales_pub_qty, a.price as sales_pub_price "
                . "    from tblstock_flow a inner join tblsales b on a.reff_trx=b.sales_number "
                . "    where a.flow_type=2 and a.flow_date>='$startperiod' and a.flow_date<='$endperiod' and b.member_id=0 "
                . "    group by a.item_id, a.price "
                . ") h on a.item_id=h.item_id "
                . "left join ( "
                . "    select item_id, SUM(qty_now) as remaining_qty, price as remaining_price "
                . "    from tblstock_flow "
                . "    where flow_type=1 and qty_now>0 "
                . "    group by item_id, price, expired_date "
                . ") i on a.item_id=i.item_id "
                . $whereall
                . "order by b.stock_category_name, a.barcode, a.item_code";
        $data = $this->db->query($query);
        return $data->result();
    }
}