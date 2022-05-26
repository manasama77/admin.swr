<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_hist extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_sales_hist');	
	}
	
	public function index()
	{
        $data['saleshist'] = $this->model_sales_hist->get_all();
		$this->load->view('v_sales_hist_index', $data);
    }
    
    public function ajax_view()
    {
        if($this->session->userdata('userid') != ''){
			$salesnumber = $this->input->post('salesnumber');
            $data['sales'] = $this->model_sales_hist->get_by_id_master($salesnumber);
            $data['salesdet'] = $this->model_sales_hist->get_by_id_detail($salesnumber);
            echo json_encode($data);
        }
        else{
            echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
        }
    }

    public function get_print()
    {
        $invoicenumber = $this->uri->segment(4);

        $result['header'] = $this->model_sales_hist->get_header($invoicenumber);
        $result['detail'] = $this->model_sales_hist->get_report($invoicenumber);
        $this->load->view('v_sales_print', $result);
    }

}
