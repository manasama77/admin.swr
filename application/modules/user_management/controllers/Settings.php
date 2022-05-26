<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_settings');
		$this->load->helper('form_helper');
	}

	public function index()
	{
		if ($this->session->userdata('userid') != '') {
			$data['header'] = $this->model_settings->get_all();
			$this->load->view('v_settings_index', $data);
		} else {
			$this->session->set_flashdata('flash_login', 'Maaf login anda telah habis, silahkan login ulang !!');
			redirect('home/index');
		}
	}

	public function ajax_update()
	{
		if ($this->session->userdata('userid') != '') {

			$companyname = $this->input->post('companyname');
			$address = $this->input->post('address');
			$city = $this->input->post('city');
			$phone = $this->input->post('phone');
			$mobile = $this->input->post('mobile');
			$email = $this->input->post('email');
			$salesexchangelimit = $this->input->post('salesexchangelimit');
			$wholesalelimit = $this->input->post('wholesalelimit');
			$salesnotes = $this->input->post('strsalesnotes');

			$islogofilename = $this->input->post('islogofilename');
			$strlogofilename = $this->input->post('strlogofilename');
			$strlogopreview = $this->input->post('strlogopreview');

			$config['upload_path'] = './upload/logo/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$this->load->library('upload', $config);

			if ($islogofilename > 0) {
				if ($this->upload->do_upload('logo')) {
					$data = $this->upload->data();
					$logofilename = $data["file_name"];
					$logopreview = '<img src="' . base_url() . 'upload/logo/' . $data["file_name"] . '" width="150" height="250" class="img-thumbnail" />';
				} else {
					$logofilename = '';
					$logopreview = '';
				}
			} else {
				$logofilename = $strlogofilename;
				$logopreview = $strlogopreview;
			}

			$insert = $this->model_settings->edit_data($companyname, $address, $city, $phone, $mobile, $email, $salesnotes, $logofilename, $logopreview, $salesexchangelimit, $wholesalelimit);
			if ($insert) {
				echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Ubah Data'));
			} else {
				echo json_encode(array('status' => FALSE, 'message' => 'Gagal Ubah Data'));
			}
		} else {
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
}
