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

class merk extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_merk');
		$this->load->helper(array('form', 'url'));
	}

	public function index()
	{
		if ($this->session->userdata('userid') != '') {
			$data['merk'] = $this->model_merk->get_all();
			$this->load->view('v_merk_index', $data);
		} else {
			$this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
			redirect('home/index');
		}
	}

	public function ajax_view()
	{
		if ($this->session->userdata('userid') != '') {
			$id   = $this->input->post('id');
			$data = $this->model_merk->get_by_id($id);
			echo json_encode($data);
		} else {
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}

	public function ajax_add()
	{
		if ($this->session->userdata('userid') != '') {
			$nama_merk = $this->input->post('nama_merk');

			$insert = $this->model_merk->save_data($nama_merk);
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

			$id        = $this->input->post('id_merk_edit');
			$nama_merk = $this->input->post('nama_merk');

			$insert = $this->model_merk->edit_data($id, $nama_merk);
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
			$res = $this->model_merk->delete($id);
			if ($res) {
				echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Hapus Data'));
			} else {
				echo json_encode(array('status' => TRUE, 'message' => 'Gagal Hapus Data'));
			}
		} else {
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}

	public function view($id)
	{
		$data['supplier'] = $this->model_supplier->get_by_id($id);
		if (!empty($data['supplier'])) {
			$this->load->view('v_supplier_view', $data);
		} else {
			redirect('master/supplier/index');
		}
	}

	public function create()
	{
		$result = $this->model_supplier->last_supplier_code();
		if ($result) {
			$last_number = $result->last_number;
			$last_number = $last_number + 1;
			$suppliercode = "SP" . date("Y") . date("m") . substr("000" . $last_number, -4);
		} else {
			$suppliercode = "SP" . date("Y") . date("m") . "0001";
		}
		$data = array('suppliercode' => $suppliercode);
		$this->load->view('v_supplier_add', $data);
	}

	public function create_post()
	{
		$suppliercode = $this->input->post('suppliercode');
		$suppliername = $this->input->post('suppliername');
		$contactname = $this->input->post('contactname');
		$phone = $this->input->post('phone');
		$handphone = $this->input->post('handphone');
		$email = $this->input->post('email');
		$city = $this->input->post('city');
		$address = $this->input->post('address');
		$description = $this->input->post('description');

		$isexist = $this->check_suppliercode($suppliercode);

		if ($isexist == 0) {
			$res = $this->model_supplier->save_data($suppliercode, $suppliername, $contactname, $phone, $handphone, $email, $city, $address, $description);
			if ($res == "success") {
				redirect('master/supplier/index');
			} else {
				redirect('master/supplier/index');
			}
		} else {
			redirect('master/supplier/index');
		}
	}

	public function edit($id)
	{
		$data['supplier'] = $this->model_supplier->get_by_id($id);
		if (!empty($data['supplier'])) {
			$this->load->view('v_supplier_edit', $data);
		} else {
			redirect('master/supplier/index');
		}
	}

	public function edit_post()
	{
		$id = $this->input->post('supplierid');
		$contactname = $this->input->post('contactname');
		$phone = $this->input->post('phone');
		$handphone = $this->input->post('handphone');
		$email = $this->input->post('email');
		$city = $this->input->post('city');
		$address = $this->input->post('address');
		$description = $this->input->post('description');

		$res = $this->model_supplier->update_data($contactname, $phone, $handphone, $email, $city, $address, $description, $id);
		if ($res == "success") {
			redirect('master/supplier/index');
		} else {
			redirect('master/supplier/index');
		}
	}

	public function delete()
	{
		$id = $this->input->post('supplierid');

		$res = $this->model_supplier->delete($id);
		echo json_encode($data['response'] = $res);
	}
}
