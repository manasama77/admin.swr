<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Repair extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_repair');
    }


    public function index()
    {
        $username     = $this->input->get('username');
        $password     = $this->input->get('password');
        $sales_number = $this->input->get('sales_number');

        if ($username != "adam" || $password != "ganteng") {
            return show_error("Username / Password Wrong", 500);
        }

        if ($sales_number == null) {
            return show_error("Sales Number Required", 400);
        }

        $this->db->trans_begin();

        $sales = $this->Model_repair->get_sales($sales_number);
        if ($sales->num_rows() == 0) {
            return show_error("Sales Number Not Found", 404);
        }

        $sales_id = $sales->row()->sales_id;

        $sales_dets = $this->Model_repair->get_sales_det($sales_id);

        foreach ($sales_dets->result() as $key) {
            $item_id      = $key->item_id;
            $qty          = $key->qty;
            $return_stock = $this->Model_repair->return_stock($item_id, $qty);
            if (!$return_stock) {
                $this->db->trans_rollback();
                return show_error("Return Stock Item ID " . $item_id . " Failed", 404);
            }
        }

        $stock_out = $this->Model_repair->get_stock_out($sales_number);
        if ($stock_out->num_rows() == 0) {
            return show_error("Stock Out Not Found", 404);
        }

        $stock_out_id = $stock_out->row()->stock_out_id;

        $exec = $this->Model_repair->process_delete($sales_number, $sales_id, $stock_out_id);
        if ($exec['code'] == 500) {
            return show_error($exec['msg'], $exec['code']);
        } elseif ($exec['code'] == 200) {
            $this->db->trans_commit();
            echo $exec['msg'];
        }
    }
}
        
    /* End of file  Repair.php */
