<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item_stock extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_item_stock');
    }

    public function index()
    {
        if ($this->session->userdata('userid') != '') {
            $data['itemstock'] = $this->model_item_stock->get_all();
            $this->load->view('v_item_stock_index', $data);
        } else {
            $this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
            redirect('home/index');
        }
    }
}
