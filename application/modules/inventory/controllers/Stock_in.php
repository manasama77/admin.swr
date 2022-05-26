<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Load library phpspreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Stock_in extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_stock_in');
	}

	public function index()
	{
		if ($this->session->userdata('userid') != '') {

			$branchid   = $this->session->userdata('branchid');
			$officetype = $this->session->userdata('officetype');
			if ($officetype == 1) {
				$data['branch'] = $this->model_stock_in->dd_branch();
			} else {
				$data['branch'] = $this->model_stock_in->dd_branch_only($branchid);
			}

			$data['stockin']  = $this->model_stock_in->get_all();
			$data['supplier'] = $this->model_stock_in->dd_supplier();
			$data['item']     = $this->model_stock_in->dd_item();
			$this->load->view('v_stock_in_index', $data);
		} else {
			$this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
			redirect('home/index');
		}
	}

	public function ajax_view()
	{
		if ($this->session->userdata('userid') != '') {
			$id = $this->input->post('id');
			$data['stockin']    = $this->model_stock_in->get_by_id_master($id);
			$data['stockindet'] = $this->model_stock_in->get_by_id_detail($id);
			echo json_encode($data);
		} else {
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}

	public function ajax_add()
	{
		if ($this->session->userdata('userid') != '') {
			$branchid     = $this->input->post('branchid');
			$supplierid   = $this->input->post('supplierid');
			$docnumber    = $this->input->post('docnumber');
			$stockdate    = $this->input->post('stockdate');
			$status       = 1;
			$description  = $this->input->post('description');
			$arr_item_id  = $this->input->post('item_id');
			$arr_item_qty = $this->input->post('item_qty');
			$creatorid    = $this->session->userdata('userid');

			$insert = $this->model_stock_in->save_data($branchid, $supplierid, $docnumber, $stockdate, $status, $description, $arr_item_id, $arr_item_qty, $creatorid);
			if ($insert) {
				echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Tambah Data'));
			} else {
				echo json_encode(array('status' => FALSE, 'message' => 'Gagal Tambah Data'));
			}
		} else {
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}

	public function ajax_update()
	{
		if ($this->session->userdata('userid') != '') {

			$id = $this->input->post('stockinid');
			$branchid = $this->input->post('branchid');
			$status = 1;
			$description = $this->input->post('description');
			$item = $this->input->post('item');
			$modificatorid = $this->session->userdata('userid');

			$insert = $this->model_stock_in->edit_data($branchid, $supplierid, $status, $description, $item, $modificatorid, $id);
			if ($insert) {
				echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Ubah Data'));
			} else {
				echo json_encode(array('status' => FALSE, 'message' => 'Gagal Ubah Data'));
			}
		} else {
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}

	public function ajax_delete()
	{
		if ($this->session->userdata('userid') != '') {
			$id = $this->input->post('id');
			$res = $this->model_stock_in->delete_data($id);
			if ($res) {
				echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Hapus Data'));
			} else {
				echo json_encode(array('status' => FALSE, 'message' => 'Gagal Hapus Data'));
			}
		} else {
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
}
