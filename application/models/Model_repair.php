<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_repair extends CI_Model
{

    public function get_sales($sales_number)
    {
        $this->db->where('sales_number', $sales_number);
        return $this->db->get('tblsales');
    }

    public function get_sales_det($sales_id)
    {
        $this->db->where('sales_id', $sales_id);
        return $this->db->get('tblsales_det');
    }

    public function get_stock_out($sales_number)
    {
        $this->db->where('doc_number', $sales_number);
        return $this->db->get('tblstock_out');
    }

    public function return_stock($item_id, $qty)
    {
        $this->db->set('qty', 'qty + ' . $qty, FALSE);
        $this->db->where('item_id', $item_id);
        return $this->db->update('tblitem_stock');
    }

    public function process_delete($sales_number, $sales_id, $stock_out_id)
    {
        $this->db->where('stock_out_id', $stock_out_id);
        $stock_out_det = $this->db->delete('tblstock_out_det');
        if (!$stock_out_det) {
            $this->db->trans_rollback();
            return [
                'code' => 500,
                'msg'  => "Proses Hapus Table Stock Out Det Gagal",
            ];
        }


        $this->db->where('doc_number', $sales_number);
        $stock_out = $this->db->delete('tblstock_out');
        if (!$stock_out) {
            $this->db->trans_rollback();
            return [
                'code' => 500,
                'msg'  => "Proses Hapus Table Stock Out Gagal",
            ];
        }


        $this->db->where('reff_trx', $sales_number);
        $stock_flow = $this->db->delete('tblstock_flow');
        if (!$stock_flow) {
            $this->db->trans_rollback();
            return [
                'code' => 500,
                'msg'  => "Proses Hapus Table Stock Flow Gagal",
            ];
        }


        $this->db->where('sales_id', $sales_id);
        $sales_det = $this->db->delete('tblsales_det');
        if (!$sales_det) {
            $this->db->trans_rollback();
            return [
                'code' => 500,
                'msg'  => "Proses Hapus Table Sales Det Gagal",
            ];
        }


        $this->db->where('sales_id', $sales_id);
        $sales = $this->db->delete('tblsales');
        if (!$sales) {
            $this->db->trans_rollback();
            return [
                'code' => 500,
                'msg'  => "Proses Hapus Table Sales Gagal",
            ];
        }

        return [
            'code' => 200,
            'msg'  => "Proses Hapus Berhasil"
        ];
    }
}
                        
/* End of file Model_repair.php */
