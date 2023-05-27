<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_dashboard');
		$this->load->helper(array('form', 'url'));
	}

	public function index()
	{
		if ($this->session->userdata('userid') != '') {
			//$data['stockproductwarn'] = $this->model_dashboard->get_stock_product_warn();

			$startperiod = date('Y-m-d', strtotime('today - 29 days'));
			$endperiod   = date('Y-m-d');

			$dtstartperiod = date('d M Y', strtotime($startperiod));
			$dtendperiod   = date('d M Y', strtotime($endperiod));

			$data['header'] = $this->model_dashboard->get_graph_header($dtstartperiod, $dtendperiod);

			$label = '';
			for ($x = 29; $x >= 0; $x--) {
				$label = $label . "," . date('d M Y', strtotime('today - ' . $x . ' days'));
			}
			$label = substr($label, 1);
			$data['label'] = $label;

			$sales = '';
			for ($x = 29; $x >= 0; $x--) {
				$datasales = $this->model_dashboard->get_sales_data(date('Y-m-d', strtotime('today - ' . $x . ' days')));
				$sales = $sales . ',' . $datasales->sales_daily;
			}
			$sales = substr($sales, 1);
			$data['sales'] = $sales;

			$data['stock_kosong']  = $this->model_dashboard->get_stock_kosong();
			$data['stock_minimum'] = $this->model_dashboard->get_stock_minimum();
			$data['top15s'] = $this->model_dashboard->top15();

			$this->load->view('v_dashboard', $data);
		} else {
			$this->session->set_flashdata('flash_login', 'Maaf login anda telah habis, silahkan login ulang !!');
			redirect('home/index');
		}
	}
}
