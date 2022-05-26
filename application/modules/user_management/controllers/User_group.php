<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_group extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_user_group');	
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
            $data['usergroup'] = $this->model_user_group->get_all();
            $this->load->view('v_user_group_index', $data);
        }
        else{
			$this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
            redirect('home/index');
        }
    }
    
	public function ajax_view()
    {
        if($this->session->userdata('userid') != ''){
            $id = $this->input->post('id');
            $data = $this->model_user_group->get_by_id($id);
            echo json_encode($data);
        }
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_add()
    {
        if($this->session->userdata('userid') != ''){
            
			$result = $this->model_user_group->last_user_group_code();
			if($result){
				$last_number = $result->last_number;
				$last_number = $last_number + 1;
				$usergroupcode = "UG" . date("y") . date("m") . substr("000" . $last_number,-4);
			}else{
				$usergroupcode = "UG" . date("y") . date("m") . "0001";
			}

		    $usergroupname = $this->input->post('usergroupname');
			$usergroupstatus = $this->input->post('usergroupstatus');
			$creatorid = $this->session->userdata('userid');
				
			$usergroupid = $this->model_user_group->save_data($usergroupcode,$usergroupname,$usergroupstatus,$creatorid);
			if($usergroupid > 0){

                $menu = $this->model_user_group->get_all_menu();
                foreach($menu as $item){
                    $menuid = $item['menu_id'];
                    $insert = $this->model_user_group->generate_user_access($usergroupid,$menuid,$creatorid);
                }

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
			$id = $this->input->post('usergroupid');
			$usergroupname = $this->input->post('usergroupname');
			$usergroupstatus = $this->input->post('usergroupstatus');
			$modificatorid = $this->session->userdata('userid');
				
            $insert = $this->model_user_group->edit_data($usergroupname,$usergroupstatus,$modificatorid,$id);
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
            $res = $this->model_user_group->delete_data($id);
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
