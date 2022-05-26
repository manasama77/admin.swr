<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_pass extends MX_Controller {

	public function __construct(){
		parent::__construct();		
        $this->load->model('model_change_pass');	
        $this->load->helper('form_helper');
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
            $this->load->view('v_change_pass');
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
			$password1 = $this->input->post('password1');
		    $password2 = $this->input->post('password2');
                
            if($password1 == $password2){
                $insert = $this->model_change_pass->edit_data($password1,$id);
                if($insert){
                    echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Ubah Data'));
                }
                else{
                    echo json_encode(array('status' => FALSE, 'message' => 'Gagal Ubah Data'));
                }
            }
            else{
                echo json_encode(array('status' => FALSE, 'message' => 'Password yang diinput tidak sama'));
            }
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
}
