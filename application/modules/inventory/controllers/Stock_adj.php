<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_adj extends MX_Controller {

	public function __construct(){
		parent::__construct();		
        $this->load->model('model_stock_adj');	
        $this->load->helper('form_helper');
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
			
            $branchid = $this->session->userdata('branchid');
            $officetype = $this->session->userdata('officetype');
            if($officetype == 1){
                $data['branch'] = $this->model_stock_adj->dd_branch();
            }
            else{
                $data['branch'] = $this->model_stock_adj->dd_branch_only($branchid);
            }

            $data['stockadj'] = $this->model_stock_adj->get_all();
            $data['item'] = $this->model_stock_adj->dd_item();
            $this->load->view('v_stock_adj_index', $data);
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
			$data = $this->model_stock_adj->get_by_id($id);
			echo json_encode($data);
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_add()
    {
        if($this->session->userdata('userid') != ''){
			
			$branchid = $this->input->post('branchid');
			$itemid = $this->input->post('itemid');
			$adjqty = $this->input->post('adjqty');
			$adjtype = $this->input->post('adjtype');
			$description = $this->input->post('description');
			$creatorid = $this->session->userdata('userid');
			
			$buyingprice = 0;
			$result = $this->model_stock_adj->search_price($branchid,$itemid);
			if($result){
				$buyingprice = $result->buying_price;
			}

			$insert = $this->model_stock_adj->save_data($branchid,$itemid,$adjqty,$adjtype,$buyingprice,$description,$creatorid);
			if($insert){
				echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Tambah Data'));
			}
			else{
				echo json_encode(array('status' => FALSE, 'message' => 'Gagal Tambah Data'));
			}
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
    }
	
}
