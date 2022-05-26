<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_sales');
	}

	public function index()
	{
		if ($this->session->userdata('userid') != '') {
			$data['item'] = $this->model_sales->dd_item();
			$data['bank'] = $this->model_sales->dd_bank();
			$this->load->view('v_sales', $data);
		} else {
			$this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
			redirect('home/index');
		}
	}

	public function load_form()
	{

		echo json_encode($data);
	}

	public function validate_logincode()
	{
		if ($this->session->userdata('userid') != '') {
			$data['userid'] = $this->session->userdata('userid');

			$result = $this->model_sales->last_trans_number();
			if ($result) {
				$last_number = $result->last_number;
				$last_number = $last_number + 1;
				$data['transnumber'] = "POS" . date("Y") . date("m") . substr("000" . $last_number, -4);
			} else {
				$data['transnumber'] = "POS" . date("Y") . date("m") . "0001";
			}
			$data['transdate'] = date("d M Y");
		} else {
			$data['userid'] = 0;
			$data['transnumber'] = "";
			$data['transdate'] = "";
		}
		echo json_encode($data);
	}

	public function get_item_price_promo()
	{
		$branchid = $this->session->userdata('branchid');
		$barcode = $this->input->post('barcode');

		$result0 = $this->model_sales->item_name($branchid, $barcode);
		if ($result0) {
			$id = $result0->item_id;
			$stockcategoryid = $result0->stock_category_id;
			$itemname = $result0->item_name;
			$qty = $result0->qty;
		} else {
			$id = 0;
			$stockcategoryid = 0;
			$itemname = '';
			$qty = 0;
		}

		$data['itemid'] = $id;
		$data['itemname'] = $itemname;
		$data['totalqty'] = $qty;

		$result1 = $this->model_sales->item_price($id, $branchid);
		if ($result1) {
			$data['sellingprice'] = $result1->selling_price;
		}

		$result2 = $this->model_sales->item_promo($branchid, $stockcategoryid, $id);
		if ($result2) {
			$percentage = $result2->disc_percentage;
			if ($percentage > 0) {
				$data['discamount'] = ($price * $percentage) / 100;
			} else {
				$data['discamount'] = $result2->disc_amount;
			}
		}

		echo json_encode($data);
	}

	public function wholesale_limit()
	{
		$result1 = $this->model_sales->check_setting();
		if ($result1) {
			$data['wholesalelimit'] = $result1->wholesale_limit;
		} else {
			$data['wholesalelimit'] = 0;
		}
		echo json_encode($data);
	}

	public function check_qty()
	{
		$branchid = $this->session->userdata('branchid');
		$barcode = $this->input->post('barcode');

		$result0 = $this->model_sales->item_name($branchid, $barcode);
		if ($result0) {
			$data['totalqty'] = $result0->qty;
		} else {
			$data['totalqty'] = 0;
		}

		echo json_encode($data);
	}

	public function search_stock()
	{
		$itemid = $this->input->post('itemid');
		$data = $this->model_sales->search_stock($itemid);
		echo json_encode($data);
	}

	public function search_price()
	{
		$branchid = $this->session->userdata('branchid');
		$itemid = $this->input->post('itemid');
		$data = $this->model_sales->search_price($branchid, $itemid);
		echo json_encode($data);
	}

	public function create_post()
	{
		if ($this->session->userdata('userid') != '') {

			$branchid    = $this->session->userdata('branchid');
			$salesnumber = $this->input->post('salesnumber');
			$totalprice  = $this->input->post('totalprice');
			$totaldisc   = $this->input->post('totaldisc');
			$totaltrans  = $this->input->post('totaltrans');
			$paymenttype = $this->input->post('intpaymenttype');
			$bankid      = $this->input->post('intbankid');
			$cardholder  = $this->input->post('strcardholder');
			$cardnumber  = $this->input->post('strcardnumber');
			$payment     = $this->input->post('payment');
			$notes       = $this->input->post('strnotes');
			$item        = $this->input->post('item');
			$creatorid   = $this->input->post('cashierid');

			$exchange = $payment - $totaltrans;

			$res = $this->model_sales->save_data($branchid, $salesnumber, $totalprice, $totaldisc, $totaltrans, $paymenttype, $bankid, $cardholder, $cardnumber, $payment, $exchange, $notes, $item, $creatorid);
			if ($res) {
				echo json_encode($data['exchange'] = $exchange);
			} else {
				echo json_encode($data['exchange'] = -1);
			}
		} else {
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}

	public function get_preview()
	{
		$invoicenumber = $this->uri->segment(4);

		$result['header'] = $this->model_sales->get_header($invoicenumber);
		$result['detail'] = $this->model_sales->get_report($invoicenumber);
		$this->load->view('v_sales_preview', $result);
	}

	public function get_print()
	{
		$salesnumber = $this->uri->segment(4);

		$result['header'] = $this->model_sales->get_header($salesnumber);
		$result['detail'] = $this->model_sales->get_report($salesnumber);
		$this->load->view('v_sales_print', $result);
	}
}
