<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Load library phpspreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use Picqer\Barcode\BarcodeGeneratorSVG;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Picqer\Barcode\BarcodeGeneratorHTML;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
// End load library phpspreadsheet

class Stock_item extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_stock_item');
		$this->load->model('model_merk');
		$this->load->helper(array('form', 'url'));
	}

	public function index()
	{
		if ($this->session->userdata('userid') != '') {
			$data['stockitem']     = $this->model_stock_item->get_all();
			$data['stockcategory'] = $this->model_stock_item->dd_stockcategory();
			$data['unit']          = $this->model_stock_item->dd_unit();
			$data['merk']          = $this->model_merk->get_all();
			$this->load->view('v_stock_item_index', $data);
		} else {
			$this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
			redirect('home/index');
		}
	}

	public function reset_barcode()
	{
		$data_item = $this->model_stock_item->get_all_item();
		foreach ($data_item as $item) {
			$id = $item['item_id'];

			$permitted_chars = '0123456789';
			$barcode_new = $id . substr(str_shuffle($permitted_chars), 0, 12);
			$barcode_new = substr($barcode_new, 0, 12);

			$data_barcode = $this->model_stock_item->barcode_isexist($barcode_new);
			if ($data_barcode['is_exist'] <= 0) {
				$insert = $this->model_stock_item->update_barcode($barcode_new, $id);
			}
		}
	}

	public function ajax_view()
	{
		if ($this->session->userdata('userid') != '') {
			$id = $this->input->post('id');
			$data = $this->model_stock_item->get_by_id($id);
			echo json_encode($data);
		} else {
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}

	public function ajax_add()
	{
		if ($this->session->userdata('userid') != '') {
			$stockcategoryid = $this->input->post('stockcategoryid');
			$unitid          = $this->input->post('unitid');
			$itemcode        = $this->input->post('itemcode');
			$itemname        = $this->input->post('itemname');
			$barcode         = $this->input->post('itemcode');
			$merk_id         = $this->input->post('merk_id');
			$keterangan      = $this->input->post('keterangan');
			$minimum_stock   = $this->input->post('minimum_stock');
			$expired   = $this->input->post('expired');
			$maximumstock    = 0;
			$creatorid       = $this->session->userdata('userid');

			$isfotofilename  = $this->input->post('isfotofilename');
			$strfotofilename = $this->input->post('strfotofilename');
			$strfotopreview  = $this->input->post('strfotopreview');

			$config['upload_path'] = './upload/item/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$this->load->library('upload', $config);

			if ($isfotofilename > 0) {
				if ($this->upload->do_upload('foto')) {
					$data = $this->upload->data();
					$fotofilename = $data["file_name"];
					$fotopreview = '<img src="' . base_url() . 'upload/item/' . $data["file_name"] . '" width="150" height="250" class="img-thumbnail" />';
				} else {
					$fotofilename = '';
					$fotopreview = '';
				}
			} else {
				$fotofilename = $strfotofilename;
				$fotopreview = $strfotopreview;
			}

			$insert = $this->model_stock_item->save_data($stockcategoryid, $unitid, $itemcode, $itemname, $barcode, $minimum_stock, $expired, $maximumstock, $fotofilename, $fotopreview, $creatorid, $merk_id, $keterangan);
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

			$id              = $this->input->post('itemid');
			$stockcategoryid = $this->input->post('stockcategoryid');
			$unitid          = $this->input->post('unitid');
			$itemcode        = $this->input->post('itemcode');
			$olditemcode     = $this->input->post('olditemcode');
			$itemname        = $this->input->post('itemname');
			$barcode         = $this->input->post('itemcode');
			$merk_id         = $this->input->post('merk_id');
			$keterangan      = $this->input->post('keterangan');
			$minimumstock    = $this->input->post('minimum_stock');
			$expired   = $this->input->post('expired');
			$maximumstock    = 0;
			$modificatorid   = $this->session->userdata('userid');

			$isfotofilename = $this->input->post('isfotofilename');
			$strfotofilename = $this->input->post('strfotofilename');
			$strfotopreview = $this->input->post('strfotopreview');

			if ($olditemcode != $itemcode) {
				$check_code = $this->model_stock_item->check_code($itemcode);
				if ($check_code->num_rows() > 0) {
					echo json_encode(array('status' => FALSE, 'message' => 'Kode Barang Telah Terdaftar'));
					exit;
				}
			}

			$config['upload_path'] = './upload/item/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$this->load->library('upload', $config);

			if ($isfotofilename > 0) {
				if ($this->upload->do_upload('foto')) {
					$data = $this->upload->data();
					$fotofilename = $data["file_name"];
					$fotopreview = '<img src="' . base_url() . 'upload/item/' . $data["file_name"] . '" width="150" height="250" class="img-thumbnail" />';
				} else {
					$fotofilename = '';
					$fotopreview = '';
				}
			} else {
				$fotofilename = $strfotofilename;
				$fotopreview = $strfotopreview;
			}

			$insert = $this->model_stock_item->edit_data($stockcategoryid, $unitid, $itemcode, $itemname, $barcode, $minimumstock, $expired, $maximumstock, $fotofilename, $fotopreview, $merk_id, $keterangan, $modificatorid, $id);
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
			$id  = $this->input->post('id');
			$res = $this->model_stock_item->delete($id);
			if ($res) {
				echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Hapus Data'));
			} else {
				echo json_encode(array('status' => FALSE, 'message' => 'Gagal Hapus Data, Karna Barang Sudah Terjadi Penjualan'));
			}
		} else {
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}

	public function import()
	{
		$filename = $this->uri->segment(4);
		$datafile = 'public/' . $filename;
		$excel = new Spreadsheet_Excel_Reader();
		$excel->read($datafile);

		$tmpdata = [];
		$x = 2;
		while ($x <= $excel->sheets[0]['numRows']) {
			$suppliercode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
			$stockcategorycode = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
			$unitcode = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
			$itemcode = isset($excel->sheets[0]['cells'][$x][4]) ? $excel->sheets[0]['cells'][$x][4] : '';
			$itemname = isset($excel->sheets[0]['cells'][$x][5]) ? $excel->sheets[0]['cells'][$x][5] : '';
			$barcode = isset($excel->sheets[0]['cells'][$x][6]) ? $excel->sheets[0]['cells'][$x][6] : '';
			$minimumqty = isset($excel->sheets[0]['cells'][$x][7]) ? $excel->sheets[0]['cells'][$x][7] : '';
			$maximumqty = isset($excel->sheets[0]['cells'][$x][8]) ? $excel->sheets[0]['cells'][$x][8] : '';

			array_push($tmpdata, [
				'suppliercode' => $suppliercode,
				'stockcategorycode' => $stockcategorycode,
				'unitcode' => $unitcode,
				'itemcode' => $itemcode,
				'itemname' => $itemname,
				'barcode' => $barcode,
				'minimumqty' => $minimumqty,
				'maximumqty' => $maximumqty
			]);

			$x++;
		}
		$data['data_excell'] = $tmpdata;
		$data['filename'] = $filename;

		$this->load->view('v_stock_item_import', $data);
	}

	public function import_post()
	{
		$filename = $this->input->post('filename');
		$datafile = 'public/' . $filename;

		$excel = new Spreadsheet_Excel_Reader();
		$excel->read($datafile);

		$x = 2;
		while ($x <= $excel->sheets[0]['numRows']) {
			$suppliercode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
			$stockcategorycode = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
			$unitcode = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
			$itemcode = isset($excel->sheets[0]['cells'][$x][4]) ? $excel->sheets[0]['cells'][$x][4] : '';
			$itemname = isset($excel->sheets[0]['cells'][$x][5]) ? $excel->sheets[0]['cells'][$x][5] : '';
			$barcode = isset($excel->sheets[0]['cells'][$x][6]) ? $excel->sheets[0]['cells'][$x][6] : '';
			$minimumqty = isset($excel->sheets[0]['cells'][$x][7]) ? $excel->sheets[0]['cells'][$x][7] : '';
			$maximumqty = isset($excel->sheets[0]['cells'][$x][8]) ? $excel->sheets[0]['cells'][$x][8] : '';

			$supplier = $this->model_stock_item->search_supplier($suppliercode);
			$supplierid = $supplier->supplier_id;

			$stockcategory = $this->model_stock_item->search_stock_category($stockcategorycode);
			$stockcategoryid = $stockcategory->stock_category_id;

			$stockunit = $this->model_stock_item->search_stock_unit($unitcode);
			$stockunitid = $stockunit->unit_id;

			$isexist = $this->check_barcode($barcode);
			if ($isexist == 0) {
				$res = $this->model_stock_item->save_data($supplierid, $stockcategoryid, $stockunitid, $itemcode, $itemname, $barcode, 0, $minimumqty, $maximumqty);
			} else {
				$res = $this->model_stock_item->update_data_excel($supplierid, $stockcategoryid, $stockunitid, $itemcode, $itemname, $barcode, 0, $minimumqty, $maximumqty);
			}

			$x++;
		}

		if (file_exists($datafile)) {
			unlink($datafile);
		}

		redirect('master/stock_item/index');
	}

	public function print_barcode($item_code, $qty)
	{
		$generator = new Picqer\Barcode\BarcodeGeneratorSVG();
		$data = [
			'qty'       => $qty,
			'item_code' => $item_code,
			'barcode'   => $generator->getBarcode($item_code, $generator::TYPE_CODE_128)
		];

		echo $this->load->view('v_print_barcode', $data, true);
	}
}
