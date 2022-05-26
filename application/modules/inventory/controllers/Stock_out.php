<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Stock_out extends MX_Controller {

	public function __construct(){
		parent::__construct();		
        $this->load->model('model_stock_out');	
        $this->load->helper('form_helper');
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
            $data['stockout'] = $this->model_stock_out->get_all();
            $data['branch'] = $this->model_stock_out->dd_branch();
            $this->load->view('v_stock_out_index', $data);
        }
        else{
            $this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
            redirect('home/index');
        }
    }
    
    public function ajax_view()
    {
        if($this->session->userdata('userid') != ''){
			$id = $this->input->post('id');
            $data['stockout'] = $this->model_stock_out->get_by_id_master($id);
            $data['stockoutdet'] = $this->model_stock_out->get_by_id_detail($id);
            echo json_encode($data);
        }
        else{
            echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
        }
    }

}
