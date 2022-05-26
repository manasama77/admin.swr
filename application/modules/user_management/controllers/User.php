<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MX_Controller {

	public function __construct(){
		parent::__construct();		
        $this->load->model('model_user');	
        $this->load->helper('form_helper');
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
            $data['user'] = $this->model_user->get_all();
            $data['usergroup'] = $this->model_user->dd_usergroup();
            $data['branch'] = $this->model_user->dd_branch();
            $this->load->view('v_user_index', $data);
        }
        else{
			$this->session->set_flashdata('flash_login', 'Maaf login anda telah habis, silahkan login ulang !!');
            redirect('home/index');
        }
    }

    public function ajax_check_exist()
    {
        if($this->session->userdata('userid') != ''){
            $username = $this->input->post('username');
            $logincode = $this->input->post('logincode');
            $data = $this->model_user->get_username($username,$logincode);
            echo json_encode($data);
        }
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
    }
    
	public function ajax_view()
    {
        if($this->session->userdata('userid') != ''){
            $id = $this->input->post('id');
            $data = $this->model_user->get_by_id($id);
            echo json_encode($data);
        }
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_add()
    {
        if($this->session->userdata('userid') != ''){
			$usergroupid = $this->input->post('usergroupid');
		    $branchid = $this->input->post('branchid');
		    $fullname = $this->input->post('fullname');
		    $phone = $this->input->post('phone');
		    $email = $this->input->post('email');
		    $address = $this->input->post('address');
		    $username = $this->input->post('username');
		    $password = $this->input->post('password');
		    $logincode = $this->input->post('logincode');
			$status = $this->input->post('status');
			$creatorid = $this->session->userdata('userid');
				
			$insert = $this->model_user->save_data($usergroupid,$branchid,$fullname,$phone,$email,$address,$username,$password,$logincode,$status,$creatorid);
			if($insert){
                echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Tambah Data'));
            }
            else{
                echo json_encode(array('status' => FALSE, 'message' => 'Gagal Tambah Data'));
            }
		}
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
    }
	
	public function ajax_update()
    {
        if($this->session->userdata('userid') != ''){
			$id = $this->input->post('userid');
		    $branchid = $this->input->post('branchid');
		    $fullname = $this->input->post('fullname');
		    $phone = $this->input->post('phone');
		    $email = $this->input->post('email');
		    $address = $this->input->post('address');
		    $username = $this->input->post('username');
		    $password = $this->input->post('password');
		    $logincode = $this->input->post('logincode');
			$status = $this->input->post('status');
			$modificatorid = $this->session->userdata('userid');
				
            $insert = $this->model_user->edit_data($branchid,$fullname,$phone,$email,$address,$username,$password,$logincode,$status,$modificatorid,$id);
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
	
	public function ajax_delete()
    {
        if($this->session->userdata('userid') != ''){
            $id = $this->input->post('id');
            $res = $this->model_user->delete_data($id);
            if($res){
                echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Hapus Data'));
            }
            else{
                echo json_encode(array('status' => TRUE, 'message' => 'Gagal Hapus Data'));
            }
        }
        else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
        }
    }
    
}
