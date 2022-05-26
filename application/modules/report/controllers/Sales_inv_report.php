<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_inv_report extends MX_Controller {

	public function __construct(){
		parent::__construct();		
        $this->load->model('model_sales_inv_report');	
        $this->load->helper('form_helper');
	}
	
	public function index()
	{
        $data['item'] = $this->model_sales_inv_report->dd_item();
		$this->load->view('v_sales_inv_report', $data);
    }

    function get_report(){
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $itemid = $this->uri->segment(6);

        $strstartperiod = date('d M Y',strtotime($startperiod));
        $strendperiod = date('d M Y',strtotime($endperiod));

        $result['header'] = $this->model_sales_inv_report->get_header($strstartperiod,$strendperiod);
        $result['report'] = $this->model_sales_inv_report->get_report($startperiod,$endperiod,$itemid);
        $this->load->view('v_sales_inv_preview', $result);
    }

    function get_print(){
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $itemid = $this->uri->segment(6);

        $strstartperiod = date('d M Y',strtotime($startperiod));
        $strendperiod = date('d M Y',strtotime($endperiod));

        $result['header'] = $this->model_sales_inv_report->get_header($strstartperiod,$strendperiod);
        $result['report'] = $this->model_sales_inv_report->get_report($startperiod,$endperiod,$itemid);
        $this->load->view('v_sales_inv_print', $result);
    }

    function get_excel(){
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $itemid = $this->uri->segment(6);

        $strstartperiod = date('d M Y',strtotime($startperiod));
        $strendperiod = date('d M Y',strtotime($endperiod));

        $result['header'] = $this->model_sales_inv_report->get_header($strstartperiod,$strendperiod);
        $result['report'] = $this->model_sales_inv_report->get_report($startperiod,$endperiod,$itemid);
        $this->load->view('v_fast_slow_moving_excel', $result);
    }

    function get_pdf(){
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $itemid = $this->uri->segment(6);

        $strstartperiod = date('d M Y',strtotime($startperiod));
        $strendperiod = date('d M Y',strtotime($endperiod));

        $result['header'] = $this->model_sales_inv_report->get_header($strstartperiod,$strendperiod);
        $result['report'] = $this->model_sales_inv_report->get_report($startperiod,$endperiod,$itemid);
        $this->load->view('v_fast_slow_moving_pdf', $result);

        $html = $this->output->get_output();
        $this->load->library('dompdf_gen');

        $this->dompdf->load_html($html);
        $this->dompdf->set_paper("A4","portrait");
		$this->dompdf->render();
        $this->dompdf->stream("FastSlowMovingReport.pdf");
    }
}
