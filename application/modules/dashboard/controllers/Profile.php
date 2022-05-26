<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MX_Controller {

	public function __construct(){
		parent::__construct();		
        $this->load->model('model_profile');	
        $this->load->helper('form_helper');
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
			$id = $this->session->userdata('userid');
            $data['header'] = $this->model_profile->get_all($id);
            $this->load->view('v_profile', $data);
        }
        else{
			$this->session->set_flashdata('flash_login', 'Maaf login anda telah habis, silahkan login ulang !!');
            redirect('home/index');
        }
    }
    
	public function ajax_update()
    {
        if($this->session->userdata('userid') != ''){
			$id = $this->session->userdata('userid');
			$fullname = $this->input->post('fullname');
		    $phone = $this->input->post('phone');
		    $email = $this->input->post('email');
		    $address = $this->input->post('address');
				
            $insert = $this->model_profile->edit_data($fullname,$phone,$email,$address,$id);
            if($insert){
                echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Ubah Data'));
            }
            else{
                echo json_encode(array('status' => FALSE, 'message' => 'Gagal Ubah Data'));
            }
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
}
