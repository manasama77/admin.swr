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

class Sales_exchange extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_sales_exchange');	
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){			
            $data['itemexchange'] = $this->model_sales_exchange->dd_item();
            $data['item'] = $this->model_sales_exchange->dd_item();
            $this->load->view('v_sales_exchange_index', $data);
        }
        else{
            $this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
            redirect('home/index');
        }
    }
    
	public function validate_logincode()
	{
		if($this->session->userdata('userid') != ''){
			$data['userid'] = $this->session->userdata('userid');

			$result = $this->model_sales_exchange->last_trans_number();
			if($result){
				$last_number = $result->last_number;
				$last_number = $last_number + 1;
				$data['transnumber'] = "EXC" . date("Y") . date("m") . substr("000" . $last_number,-4);
			}else{
				$data['transnumber'] = "EXC" . date("Y") . date("m") . "0001";
			}
			$data['transdate'] = date("d M Y");
		}
		else{
			$data['userid'] = 0;
			$data['transnumber'] = "";
			$data['transdate'] = "";
		}
		echo json_encode($data);
	}
	
	public function get_sales_data()
    {
        if($this->session->userdata('userid') != ''){
			$salesnumber = $this->input->post('salesnumber');
            
			$data['sales'] = $this->model_sales_exchange->get_sales($salesnumber);
			$salesid = $data['sales']['sales_id'];
			$data['sales_det'] = $this->model_sales_exchange->get_sales_det($salesid);
			echo json_encode($data);
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function get_qty_available()
    {
        if($this->session->userdata('userid') != ''){
			$branchid = $this->session->userdata('branchid');
            $itemid = $this->input->post('itemexchange');
            
			$data['qty'] = $this->model_sales_exchange->get_qty_available($branchid,$itemid);
			$data['price'] = $this->model_sales_exchange->search_price($branchid,$itemid);
			echo json_encode($data);
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
    public function create_post()
    {
        if($this->session->userdata('userid') != ''){
			
			$branchid = $this->session->userdata('branchid');
			$salesexchangenumber = $this->input->post('salesexchangenumber');
			$salesnumber = $this->input->post('salesnumber');
			$totaltrans = $this->input->post('totaltrans');
			$payment = $this->input->post('payment');
			$description = $this->input->post('description');
			$item = $this->input->post('item');
			$creatorid = $this->input->post('cashierid');
			
			$exchange = $payment - $totaltrans;
	
			$res = $this->model_sales_exchange->save_data($branchid,$salesexchangenumber,$salesnumber,$totaltrans,$payment,$exchange,$description,$item,$creatorid);
			if($res){
				echo json_encode($data['exchange'] = $exchange);
			}else{
				echo json_encode($data['exchange'] = -1);
			}
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}

    public function get_print()
    {
        $salesexchangenumber = $this->uri->segment(4);

        $result['header'] = $this->model_sales_exchange->get_header($salesexchangenumber);
        $result['detail'] = $this->model_sales_exchange->get_report($salesexchangenumber);
        $this->load->view('v_sales_exchange_print', $result);
    }

	public function ajax_view()
    {
        if($this->session->userdata('userid') != ''){
			$id = $this->input->post('id');
			$data['salesexchange'] = $this->model_sales_exchange->get_by_id_master($id);
			$data['salesexchangedet'] = $this->model_sales_exchange->get_by_id_detail($id);
			echo json_encode($data);
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_add()
    {
        if($this->session->userdata('userid') != ''){
			
			$branchid = $this->session->userdata('branchid');
			$salesexchangenumber = $this->input->post('salesexchangenumber');
			$salesnumber = $this->input->post('salesnumber');
			$status = $this->input->post('status');
			$description = $this->input->post('description');
			$item = $this->input->post('item');
			$creatorid = $this->session->userdata('userid');
				
            $dtsalesdate = date('Y-m-d',strtotime($salesdate));
            
			$insert = $this->model_sales_exchange->save_data($branchid,$dtsalesdate,$status,$description,$item,$creatorid);
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

			$id = $this->input->post('salesexchangeid');
			$branchid = $this->input->post('branchid');
			$status = $this->input->post('status');
			$description = $this->input->post('description');
			$item = $this->input->post('item');
			$modificatorid = $this->session->userdata('userid');
				
			$insert = $this->model_sales_exchange->edit_data($branchid,$status,$description,$item,$modificatorid,$id);
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
			$res = $this->model_sales_exchange->delete_data($id);
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
