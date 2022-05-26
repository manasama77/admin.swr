<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_access extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_user_access');	
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
            $data['useraccess'] = $this->model_user_access->get_all();
            $this->load->view('v_user_access_index', $data);
        }
        else{
			$this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
            redirect('home/index');
        }
    }
    
	public function ajax_view()
    {
        if($this->session->userdata('userid') != ''){

            $id = $this->input->post('usergroupid');
            $data['user_group'] = $this->model_user_access->get_by_id($id);
			$data['dashboard'] = $this->model_user_access->get_access($id,0);
			$data['manajemen'] = $this->model_user_access->get_access($id,1);
			$data['data_utama'] = $this->model_user_access->get_access($id,2);
			$data['inventory'] = $this->model_user_access->get_access($id,3);
			$data['transaksi'] = $this->model_user_access->get_access($id,4);
			$data['laporan'] = $this->model_user_access->get_access($id,5);

            echo json_encode($data);
        }
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_update()
    {
        if($this->session->userdata('userid') != ''){
			$usergroupid = $this->input->post('usergroupid');
			$activemenu = $this->input->post('activemenu');			
			$modificatorid = $this->session->userdata('userid');
				
            $insert = $this->model_user_access->edit_data($activemenu,$modificatorid,$usergroupid);
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
