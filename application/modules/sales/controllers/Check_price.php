<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_price extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_check_price');	
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
			$data['item'] = $this->model_check_price->dd_item();
			$this->load->view('v_check_price',$data);
		}
		else{
			$this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
			redirect('home/index');
		}
    }
	
	public function search_price()
    {
		$branchid = $this->session->userdata('branchid');
		$itemid = $this->input->post('itemid');
		$data = $this->model_check_price->search_price($branchid,$itemid);
		echo json_encode($data);
	}
    
}
