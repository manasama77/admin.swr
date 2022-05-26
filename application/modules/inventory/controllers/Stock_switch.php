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

class Stock_switch extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_stock_switch');	
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
			
            $branchid = $this->session->userdata('branchid');
            $officetype = $this->session->userdata('officetype');
            if($officetype == 1){
                $data['branchorigin'] = $this->model_stock_switch->dd_branch();
                $data['branchdestination'] = $this->model_stock_switch->dd_branch();
            }
            else{
                $data['branchorigin'] = $this->model_stock_switch->dd_branch_only($branchid);
                $data['branchdestination'] = $this->model_stock_switch->dd_branch_only($branchid);
            }

            $data['stockswitch'] = $this->model_stock_switch->get_all();
            $data['item'] = $this->model_stock_switch->dd_item();
            $this->load->view('v_stock_switch_index', $data);
        }
        else{
            $this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
            redirect('home/index');
        }
    }
    
	public function get_qty_available()
    {
        if($this->session->userdata('userid') != ''){
			$branchorigin = $this->input->post('branchorigin');
            $itemid = $this->input->post('itemid');
            
			$data = $this->model_stock_switch->get_qty_available($branchorigin,$itemid);
			echo json_encode($data);
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_view()
    {
        if($this->session->userdata('userid') != ''){
			$id = $this->input->post('id');
			$data['stockswitch'] = $this->model_stock_switch->get_by_id_master($id);
			$data['stockswitchdet'] = $this->model_stock_switch->get_by_id_detail($id);
			echo json_encode($data);
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_add()
    {
        if($this->session->userdata('userid') != ''){
			
			$branchorigin = $this->input->post('branchorigin');
			$branchdestination = $this->input->post('branchdestination');
			$switchdate = $this->input->post('switchdate');
			$status = 1;
			$description = $this->input->post('description');
			$item = $this->input->post('item');
			$creatorid = $this->session->userdata('userid');
				
            $dtswitchdate = date('Y-m-d',strtotime($switchdate));
            
			$insert = $this->model_stock_switch->save_data($branchorigin,$branchdestination,$dtswitchdate,$status,$description,$item,$creatorid);
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
	
	public function ajax_update()
    {
        if($this->session->userdata('userid') != ''){

			$id = $this->input->post('stockinid');
			$branchorigin = $this->input->post('branchorigin');
			$branchdestination = $this->input->post('branchdestination');
			$status = 1;
			$description = $this->input->post('description');
			$item = $this->input->post('item');
			$modificatorid = $this->session->userdata('userid');
				
			$insert = $this->model_stock_switch->edit_data($branchorigin,$branchdestination,$status,$description,$item,$modificatorid,$id);
			if($insert){
				echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Ubah Data'));
			}
			else{
				echo json_encode(array('status' => FALSE, 'message' => 'Gagal Ubah Data'));
			}
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_delete()
    {
        if($this->session->userdata('userid') != ''){
			$id = $this->input->post('id');
			$res = $this->model_stock_switch->delete_data($id);
			if($res){
				echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Hapus Data'));
			}
			else{
				echo json_encode(array('status' => FALSE, 'message' => 'Gagal Hapus Data'));
			}
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
    }
	
}
