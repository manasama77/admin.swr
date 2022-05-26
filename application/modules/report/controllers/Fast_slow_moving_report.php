<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fast_slow_moving_report extends MX_Controller {

	public function __construct(){
		parent::__construct();		
        $this->load->model('model_fast_slow_moving_report');	
        $this->load->helper('form_helper');
	}
	
	public function index()
	{
        $branchid = $this->session->userdata('branchid');
        $officetype = $this->session->userdata('officetype');
        if($officetype == 1){
            $data['branch'] = $this->model_fast_slow_moving_report->dd_branch();
        }
        else{
            $data['branch'] = $this->model_fast_slow_moving_report->dd_branch_only($branchid);
        }

        $data['item'] = $this->model_fast_slow_moving_report->dd_item();
		$this->load->view('v_fast_slow_moving_report', $data);
    }

    function get_report(){
        $startperiod   = $this->input->post('startperiod');
        $endperiod   = $this->input->post('endperiod');
        $branchid   = $this->input->post('branchid');
        $itemid   = $this->input->post('itemid');

        $dtstartperiod = date('Y-m-d',strtotime($startperiod));
        $dtendperiod = date('Y-m-d',strtotime($endperiod));

        $result = $this->model_fast_slow_moving_report->get_report_array($dtstartperiod,$dtendperiod,$branchid,$itemid);
        echo json_encode($result);
    }

    function get_print(){
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $branchid = $this->uri->segment(6);
        $itemid = $this->uri->segment(7);

        $strstartperiod = date('d M Y',strtotime($startperiod));
        $strendperiod = date('d M Y',strtotime($endperiod));

        $result['header'] = $this->model_fast_slow_moving_report->get_header($strstartperiod,$strendperiod);
        $result['report'] = $this->model_fast_slow_moving_report->get_report($startperiod,$endperiod,$branchid,$itemid);
        $this->load->view('v_fast_slow_moving_print', $result);
    }

    function get_excel(){
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $branchid = $this->uri->segment(6);
        $itemid = $this->uri->segment(7);

        $strstartperiod = date('d M Y',strtotime($startperiod));
        $strendperiod = date('d M Y',strtotime($endperiod));

        $result['header'] = $this->model_fast_slow_moving_report->get_header($strstartperiod,$strendperiod);
        $result['report'] = $this->model_fast_slow_moving_report->get_report($startperiod,$endperiod,$branchid,$itemid);
        $this->load->view('v_fast_slow_moving_excel', $result);
    }

    function get_pdf(){
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $itemid = $this->uri->segment(6);

        $strstartperiod = date('d M Y',strtotime($startperiod));
        $strendperiod = date('d M Y',strtotime($endperiod));

        $result['header'] = $this->model_fast_slow_moving_report->get_header($strstartperiod,$strendperiod);
        $result['report'] = $this->model_fast_slow_moving_report->get_report($startperiod,$endperiod,$itemid);
        $this->load->view('v_fast_slow_moving_pdf', $result);

        $html = $this->output->get_output();
        $this->load->library('dompdf_gen');

        $this->dompdf->load_html($html);
        $this->dompdf->set_paper("A4","portrait");
		$this->dompdf->render();
        $this->dompdf->stream("FastSlowMovingReport.pdf");
    }
}
