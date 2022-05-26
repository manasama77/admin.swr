<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_trans_report extends MX_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('model_member_trans_report');	
        $this->load->helper('form_helper');
	}
	
	public function index()
	{
        $data['member'] = $this->model_member_trans_report->dd_member();
		$this->load->view('v_member_trans_report', $data);
    }

    public function get_report()
    {
        $startperiod   = $this->input->post('startperiod');
        $endperiod   = $this->input->post('endperiod');
        $memberid   = $this->input->post('memberid');

        $dtstartperiod = date('Y-m-d',strtotime($startperiod));
        $dtendperiod = date('Y-m-d',strtotime($endperiod));

        $result = $this->model_member_trans_report->get_report_array($dtstartperiod,$dtendperiod,$memberid);
        echo json_encode($result);
    }

    public function get_print()
    {
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $memberid = $this->uri->segment(6);

        $strstartperiod = date('d M Y',strtotime($startperiod));
        $strendperiod = date('d M Y',strtotime($endperiod));

        $result['header'] = $this->model_member_trans_report->get_header($strstartperiod,$strendperiod);
        $result['report'] = $this->model_member_trans_report->get_report($startperiod,$endperiod,$memberid);
        $this->load->view('v_member_trans_print', $result);
    }

    public function get_excel()
    {
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $memberid = $this->uri->segment(6);

        $strstartperiod = date('d M Y',strtotime($startperiod));
        $strendperiod = date('d M Y',strtotime($endperiod));

        $result['header'] = $this->model_member_trans_report->get_header($strstartperiod,$strendperiod);
        $result['report'] = $this->model_member_trans_report->get_report($startperiod,$endperiod,$memberid);
        $this->load->view('v_member_trans_excel', $result);
    }

    public function get_pdf()
    {
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $memberid = $this->uri->segment(6);

        $strstartperiod = date('d M Y',strtotime($startperiod));
        $strendperiod = date('d M Y',strtotime($endperiod));

        $result['header'] = $this->model_member_trans_report->get_header($strstartperiod,$strendperiod);
        $result['report'] = $this->model_member_trans_report->get_report($startperiod,$endperiod,$memberid);
        $this->load->view('v_member_trans_pdf',$result);

        $html = $this->output->get_output();
        $this->load->library('dompdf_gen');

        $this->dompdf->load_html($html);
        $this->dompdf->set_paper("A4","portrait");
		$this->dompdf->render();
        $this->dompdf->stream("MemberTransactionReport.pdf");
    }
}
