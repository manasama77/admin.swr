<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_stock_product_warn()
  {
    $query = $this->db->query("SELECT c.branch_name, b.item_name, a.qty FROM tblitem_stock a INNER JOIN tblitem b on a.item_id=b.item_id INNER JOIN tblbranch c on a.branch_id=c.branch_id 
        WHERE a.qty <= b.minimum_stock order by c.branch_id, a.qty, b.item_name");
    return $query;
  }

  public function get_sales_data($salesdate)
  {
    $query = $this->db->query("SELECT * 
                                    FROM (SELECT '$salesdate' as sales_date) a 
                                    CROSS JOIN (
                                          SELECT IFNULL(SUM(total_transaction),0) as sales_daily 
                                            FROM tblsales 
                                          WHERE DATE_FORMAT(created_date,'%Y-%m-%d')='$salesdate'
                                    ) b");
    return $query->row();
  }

  public function get_graph_header($startperiod, $endperiod)
  {
    $query = $this->db->query("SELECT '$startperiod' as startperiod, '$endperiod' as endperiod");
    return $query->row();
  }

  public function get_stock_kosong()
  {
    $sql = "
    SELECT
      tblitem.stock_category_id,
      tblstock_category.stock_category_name,
      tblitem.item_name 
    FROM
      tblitem_stock
      LEFT JOIN tblitem ON tblitem.item_id = tblitem_stock.item_id
      LEFT JOIN tblstock_category ON tblstock_category.stock_category_id = tblitem.stock_category_id 
    WHERE
      tblitem_stock.qty <= 0
    ";
    $exec = $this->db->query($sql);
    return $exec;
  }

  public function get_stock_minimum()
  {
    $sql = "
    SELECT
      tblitem.stock_category_id,
      tblstock_category.stock_category_name,
      tblitem.item_name,
      tblitem_stock.qty
    FROM
      tblitem_stock
      LEFT JOIN tblitem ON tblitem.item_id = tblitem_stock.item_id
      LEFT JOIN tblstock_category ON tblstock_category.stock_category_id = tblitem.stock_category_id 
    WHERE
      tblitem_stock.qty BETWEEN 1 
      AND tblitem.minimum_stock
    ";
    $exec = $this->db->query($sql);
    return $exec;
  }
  
  public function top15()
  {
      $sql = "SELECT tblitem.item_name, tblsales_det.qty FROM `tblsales_det` left join tblitem on tblitem.item_id = tblsales_det.item_id group by tblsales_det.item_id order by qty desc limit 15";
      return $this->db->query($sql);
  }
}
