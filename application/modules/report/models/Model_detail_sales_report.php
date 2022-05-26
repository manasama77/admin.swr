<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_detail_sales_report extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function dd_user()
    {
        $query = $this->db->query("SELECT * FROM tbluser a INNER JOIN tbluser_group b ON a.user_group_id=b.user_group_id WHERE b.is_cashier=1");
        return $query;
    }

    function dd_branch()
    {
        $query = $this->db->query("SELECT 0 as branch_id, 'Semua Cabang' as branch_code, '' as branch_name UNION ALL SELECT branch_id, branch_code, branch_name FROM tblbranch");
        return $query;
    }

    function dd_branch_only($id)
    {
        $query = $this->db->query("SELECT * FROM tblbranch where branch_id='$id'");
        return $query;
    }

    function get_header($startperiod, $endperiod)
    {
        $query = $this->db->query("SELECT '$startperiod' as startperiod, '$endperiod' as endperiod");
        return $query->row();
    }

    function get_report_array($startperiod, $endperiod, $userid, $branchid)
    {
        $whereall = "";
        if ($userid > 0) {
            $whereall = $whereall . " AND a.creator_id = '$userid'";
        }

        if ($branchid > 0) {
            $whereall = $whereall . " AND a.branch_id = '$branchid'";
        }

        $query = "SELECT d.fullname as cashier_name, e.branch_code, e.branch_name, a.sales_number, a.created_date as sales_date, "
            . "c.barcode, c.item_name, b.price, b.disc, b.extra_disc, b.qty, b.subtotal, a.total_price, a.total_disc, a.total_transaction "
            . "FROM tblsales a LEFT JOIN tblsales_det b ON a.sales_id = b.sales_id "
            . "LEFT JOIN tblitem c ON b.item_id = c.item_id "
            . "LEFT JOIN tbluser d ON a.creator_id = d.user_id "
            . "LEFT JOIN tblbranch e ON a.branch_id = e.branch_id "
            . "WHERE DATE(a.created_date) >='$startperiod' AND DATE(a.created_date) <= '$endperiod' " . $whereall
            . "ORDER BY a.sales_number, b.sales_det_id";
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function get_report($startperiod, $endperiod, $userid, $branchid)
    {
        $whereall = "";
        if ($userid > 0) {
            $whereall = $whereall . " AND a.creator_id = '$userid'";
        }

        if ($branchid > 0) {
            $whereall = $whereall . " AND a.branch_id = '$branchid'";
        }

        $query = "SELECT d.fullname as cashier_name, e.branch_code, e.branch_name, a.sales_number, a.created_date as sales_date, "
            . "c.barcode, c.item_name, b.price, b.disc, b.extra_disc, b.qty, b.subtotal, a.total_price, a.total_disc, a.total_transaction "
            . "FROM tblsales a LEFT JOIN tblsales_det b ON a.sales_id = b.sales_id "
            . "LEFT JOIN tblitem c ON b.item_id = c.item_id "
            . "LEFT JOIN tbluser d ON a.creator_id = d.user_id "
            . "LEFT JOIN tblbranch e ON a.branch_id = e.branch_id "
            . "WHERE a.created_date>='$startperiod' AND DATE_FORMAT(a.created_date,'%Y-%m-%d')<='$endperiod' " . $whereall
            . "ORDER BY a.sales_number, b.sales_det_id";
        $data = $this->db->query($query);
        return $data;
    }

    public function get_sales($from, $to, $userid, $branchid)
    {
        $this->db->select([
            'SUM(tblsales.total_price) as grand_total_transaksi',
            'SUM(tblsales.total_disc) as grand_total_diskon',
            'SUM(tblsales.total_transaction) as grand_total_penjualan',
        ]);
        $this->db->join('tblbranch', 'tblbranch.branch_id = tblsales.branch_id', 'left');
        $this->db->join('tbluser', 'tbluser.user_id = tblsales.creator_id', 'left');
        $this->db->where('tblsales.created_date >=', $from);
        $this->db->where('tblsales.created_date <=', $to);

        if ($userid != 0) {
            $this->db->where('tblsales.creator_id', $userid);
        }

        if ($branchid != 0) {
            $this->db->where('tblsales.branch_id', $branchid);
        }

        $sales_gt = $this->db->get('tblsales');

        $result = [
            'grand_total_transaksi'            => number_format($sales_gt->row()->grand_total_transaksi, 0),
            'grand_total_transaksi_unformated' => $sales_gt->row()->grand_total_transaksi,
            'grand_total_diskon'               => number_format($sales_gt->row()->grand_total_diskon, 0),
            'grand_total_diskon_unformated'    => $sales_gt->row()->grand_total_diskon,
            'grand_total_penjualan'            => number_format($sales_gt->row()->grand_total_penjualan, 0),
            'grand_total_penjualan_unformated' => $sales_gt->row()->grand_total_penjualan,
            'data'                             => [],
        ];


        $this->db->select([
            'tblsales.sales_id',
            'tblsales.created_date AS tanggal_penjualan',
            'tblsales.sales_number AS nomor_penjualan',
            'tblbranch.branch_code AS kode_cabang',
            'tblbranch.branch_name AS nama_cabang',
            'tbluser.fullname AS nama_kasir',
            'tblsales.total_price as total_transaksi',
            'tblsales.total_disc as total_diskon',
            'tblsales.total_transaction as total_penjualan',
        ]);
        $this->db->join('tblbranch', 'tblbranch.branch_id = tblsales.branch_id', 'left');
        $this->db->join('tbluser', 'tbluser.user_id = tblsales.creator_id', 'left');
        $this->db->where('tblsales.created_date >=', $from);
        $this->db->where('tblsales.created_date <=', $to);

        if ($userid != 0) {
            $this->db->where('tblsales.creator_id', $userid);
        }

        if ($branchid != 0) {
            $this->db->where('tblsales.branch_id', $branchid);
        }
        $sales = $this->db->get('tblsales');

        foreach ($sales->result() as $sale) {
            $this->db->select([
                'tblsales_det.sales_id',
                'tblitem.item_code',
                'tblitem.item_name',
                'tblsales_det.price',
                'tblsales_det.qty',
                'tblsales_det.disc',
                'tblsales_det.subtotal',
            ]);
            $this->db->join('tblitem', 'tblitem.item_id = tblsales_det.item_id', 'left');
            $this->db->where('tblsales_det.sales_id', $sale->sales_id);
            $sales_details = $this->db->get('tblsales_det');

            $sales_det_data = [];
            foreach ($sales_details->result() as $sales_detail) {
                $nested = [
                    'sales_id'            => $sales_detail->sales_id,
                    'item_code'           => $sales_detail->item_code,
                    'item_name'           => $sales_detail->item_name,
                    'price'               => number_format($sales_detail->price, 0),
                    'price_unformated'    => $sales_detail->price,
                    'qty'                 => number_format($sales_detail->qty, 0),
                    'qty_unformated'      => $sales_detail->qty,
                    'disc'                => number_format($sales_detail->disc, 0),
                    'disc_unformated'     => $sales_detail->disc,
                    'subtotal'            => number_format($sales_detail->subtotal, 0),
                    'subtotal_unformated' => $sales_detail->subtotal,
                ];
                array_push($sales_det_data, $nested);
            }

            $sales_data = [
                'sales_id'                   => $sale->sales_id,
                'tanggal_penjualan'          => $sale->tanggal_penjualan,
                'nomor_penjualan'            => $sale->nomor_penjualan,
                'kode_cabang'                => $sale->kode_cabang,
                'nama_cabang'                => $sale->nama_cabang,
                'nama_kasir'                 => $sale->nama_kasir,
                'total_transaksi'            => number_format($sale->total_transaksi, 0),
                'total_transaksi_unformated' => $sale->total_transaksi,
                'total_diskon'               => number_format($sale->total_diskon, 0),
                'total_diskon_unformated'    => $sale->total_diskon,
                'total_penjualan'            => number_format($sale->total_penjualan, 0),
                'total_penjualan_unformated' => $sale->total_penjualan,
                'product'                    => $sales_det_data,
            ];

            array_push($result['data'], $sales_data);
        }

        return $result;
    }
}
