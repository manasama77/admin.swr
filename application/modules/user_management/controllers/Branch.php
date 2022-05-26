<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_branch');	
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
            $data['branch'] = $this->model_branch->get_all();
            $this->load->view('v_branch_index', $data);
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
            $data = $this->model_branch->get_by_id($id);
            echo json_encode($data);
        }
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_add()
    {
        if($this->session->userdata('userid') != ''){
            
			$result = $this->model_branch->last_branch_code();
			if($result){
				$last_number = $result->last_number;
				$last_number = $last_number + 1;
				$branchcode = "BR" . date("y") . date("m") . substr("000" . $last_number,-4);
			}else{
				$branchcode = "BR" . date("y") . date("m") . "0001";
			}

			$officetype = $this->input->post('officetype');
		    $branchname = $this->input->post('branchname');
			$branchaddress = $this->input->post('strbranchaddress');
			$branchstatus = $this->input->post('branchstatus');
				
			$insert = $this->model_branch->save_data($officetype,$branchcode,$branchname,$branchaddress,$branchstatus);
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
			$id = $this->input->post('branchid');
		    $branchname = $this->input->post('branchname');
			$branchaddress = $this->input->post('strbranchaddress');
			$branchstatus = $this->input->post('branchstatus');
				
            $insert = $this->model_branch->edit_data($branchname,$branchaddress,$branchstatus,$id);
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
            $res = $this->model_branch->delete_data($id);
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
