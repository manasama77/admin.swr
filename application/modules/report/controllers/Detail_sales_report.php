<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_sales_report extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_detail_sales_report');
        $this->load->helper('form_helper');
    }

    public function index()
    {
        if ($this->session->userdata('userid') != '') {

            $branchid   = $this->session->userdata('branchid');
            $officetype = $this->session->userdata('officetype');
            if ($officetype == 1) {
                $data['branch'] = $this->model_detail_sales_report->dd_branch();
            } else {
                $data['branch'] = $this->model_detail_sales_report->dd_branch_only($branchid);
            }

            $data['user'] = $this->model_detail_sales_report->dd_user();
            $this->load->view('v_detail_sales_report', $data);
        } else {
            $this->session->set_flashdata('flash_login', 'Maaf login anda telah habis, silahkan login ulang !!');
            redirect('home/index');
        }
    }

    public function get_report()
    {
        $startperiod   = $this->input->post('startperiod');
        $endperiod   = $this->input->post('endperiod');
        $userid   = $this->input->post('userid');
        $branchid   = $this->input->post('branchid');

        $dtstartperiod = date('Y-m-d', strtotime($startperiod));
        $dtendperiod = date('Y-m-d', strtotime($endperiod));

        $result = $this->model_detail_sales_report->get_report_array($dtstartperiod, $dtendperiod, $userid, $branchid);
        echo json_encode($result);
    }

    public function get_print()
    {
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $userid = $this->uri->segment(6);
        $branchid = $this->uri->segment(7);

        $strstartperiod = date('d M Y', strtotime($startperiod));
        $strendperiod = date('d M Y', strtotime($endperiod));

        $result['header'] = $this->model_detail_sales_report->get_header($strstartperiod, $strendperiod);
        $result['report'] = $this->model_detail_sales_report->get_report($startperiod, $endperiod, $userid, $branchid);
        $this->load->view('v_detail_sales_print', $result);
    }

    public function get_excel()
    {
        $startperiod = $this->uri->segment(4);
        $endperiod   = $this->uri->segment(5);
        $userid      = $this->uri->segment(6);
        $branchid    = $this->uri->segment(7);

        $strstartperiod = date('d M Y', strtotime($startperiod));
        $strendperiod   = date('d M Y', strtotime($endperiod));
        $result['header'] = $this->model_detail_sales_report->get_header($strstartperiod, $strendperiod);

        $tgl_obj_from = new DateTime($startperiod);
        $tgl_obj_to   = new DateTime($endperiod);
        $result['report'] = $this->model_detail_sales_report->get_sales($tgl_obj_from->format('Y-m-d 00:00:00'), $tgl_obj_to->format('Y-m-d 23:59:59'), $userid, $branchid);
        $this->load->view('v_detail_sales_excel', $result);
    }

    public function get_pdf()
    {
        $startperiod = $this->uri->segment(4);
        $endperiod = $this->uri->segment(5);
        $userid = $this->uri->segment(6);
        $branchid = $this->uri->segment(7);

        $strstartperiod = date('d M Y', strtotime($startperiod));
        $strendperiod = date('d M Y', strtotime($endperiod));

        $result['header'] = $this->model_detail_sales_report->get_header($strstartperiod, $strendperiod);
        $result['report'] = $this->model_detail_sales_report->get_report($startperiod, $endperiod, $userid, $branchid);
        $this->load->view('v_detail_sales_pdf', $result);

        $html = $this->output->get_output();
        $this->load->library('dompdf_gen');

        $this->dompdf->load_html($html);
        $this->dompdf->set_paper("A4", "portrait");
        $this->dompdf->render();
        $this->dompdf->stream("DetailSalesReport.pdf");
    }
}
