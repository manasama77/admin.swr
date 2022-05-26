<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Member extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_member');
		$this->load->helper(array('form', 'url'));
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
			$data['member'] = $this->model_member->get_all();
			$this->load->view('v_member_index', $data);
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
            $data = $this->model_member->get_by_id($id);
            echo json_encode($data);
        }
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_add()
    {
        if($this->session->userdata('userid') != ''){

			$result = $this->model_member->last_member_code();
			if($result){
				$last_number = $result->last_number;
				$last_number = $last_number + 1;
				$membercode = "MB" . date("Y") . date("m") . substr("000" . $last_number,-4);
			}else{
				$membercode = "MB" . date("Y") . date("m") . "0001";
			}

			$fullname = $this->input->post('fullname');
			$phone = $this->input->post('phone');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
			$identitytype = $this->input->post('identitytype');
			$identityid = $this->input->post('identityid');
			$status = $this->input->post('status');
			$creatorid = $this->session->userdata('userid');
				
			$insert = $this->model_member->save_data($membercode,$fullname,$phone,$email,$address,$identitytype,$identityid,$status,$creatorid);
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

			$id = $this->input->post('memberid');
			$fullname = $this->input->post('fullname');
			$phone = $this->input->post('phone');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
			$identitytype = $this->input->post('identitytype');
			$identityid = $this->input->post('identityid');
			$status = $this->input->post('status');
			$modificatorid = $this->session->userdata('userid');
				
            $insert = $this->model_member->edit_data($fullname,$phone,$email,$address,$identitytype,$identityid,$status,$modificatorid,$id);
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
            $res = $this->model_member->delete_data($id);
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
    
    public function get_export()
    {
        $result['report'] = $this->model_member->get_all();
        $this->load->view('v_member_excel', $result);
    }

	function file_upload(){
        $config['upload_path']="./././public";
        $config['allowed_types']='xls|xlsx';
         
        $this->load->library('upload',$config);
        if($this->upload->do_upload("file")){
            $upload_data = $this->upload->data();
            echo json_decode("success");
        }
    }
	
    public function import()
    {
        $filename = $this->uri->segment(4);
		$datafile = 'public/' . $filename;
		$excel = new Spreadsheet_Excel_Reader();
		$excel->read($datafile);
		
		$tmpdata = [];
		$x = 2;
		while($x <= $excel->sheets[0]['numRows']){
			$membercode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
			$fullname = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
			$phone = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
			$email = isset($excel->sheets[0]['cells'][$x][4]) ? $excel->sheets[0]['cells'][$x][4] : '';
			$address = isset($excel->sheets[0]['cells'][$x][5]) ? $excel->sheets[0]['cells'][$x][5] : '';
			$identitytype = isset($excel->sheets[0]['cells'][$x][6]) ? $excel->sheets[0]['cells'][$x][6] : '';
			$identityid = isset($excel->sheets[0]['cells'][$x][7]) ? $excel->sheets[0]['cells'][$x][7] : '';
			$limittransaction = isset($excel->sheets[0]['cells'][$x][8]) ? $excel->sheets[0]['cells'][$x][8] : '';
			$status = isset($excel->sheets[0]['cells'][$x][9]) ? $excel->sheets[0]['cells'][$x][9] : '';
			
			if(($identitytype == "1") || (strtoupper($identitytype) == "KTP")){
				$stridentitytype = "KTP";
			}
			else{
				$stridentitytype = "SIM";
			}
			
			if(($status == "1") || (strtoupper($status) == "ACTIVE")){
				$strstatus = "Active";
			}
			else{
				$strstatus = "InActive";
			}
			
			array_push($tmpdata, [
				'membercode' => $membercode,
				'fullname' => $fullname,
				'phone' => $phone,
				'email' => $email,
				'address' => $address,
				'identitytype' => $identitytype,
				'stridentitytype' => $stridentitytype,
				'identityid' => $identityid,
				'limittransaction' => $limittransaction,
				'status' => $status,
				'strstatus' => $strstatus
			]);
			
			$x++;
		}
		$data['data_excell'] = $tmpdata;
		$data['filename'] = $filename;
		
        $this->load->view('v_member_import',$data);
    }
    
    public function import_post()
	{
		$filename = $this->input->post('filename');
		$datafile = 'public/' . $filename;
		
		$excel = new Spreadsheet_Excel_Reader();
		$excel->read($datafile);
		
		$x = 2;
        while($x <= $excel->sheets[0]['numRows']){
			$membercode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
			$fullname = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
			$phone = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
			$email = isset($excel->sheets[0]['cells'][$x][4]) ? $excel->sheets[0]['cells'][$x][4] : '';
			$address = isset($excel->sheets[0]['cells'][$x][5]) ? $excel->sheets[0]['cells'][$x][5] : '';
			$identitytype = isset($excel->sheets[0]['cells'][$x][6]) ? $excel->sheets[0]['cells'][$x][6] : '';
			$identityid = isset($excel->sheets[0]['cells'][$x][7]) ? $excel->sheets[0]['cells'][$x][7] : '';
			$limittransaction = isset($excel->sheets[0]['cells'][$x][8]) ? $excel->sheets[0]['cells'][$x][8] : '';
			$status = isset($excel->sheets[0]['cells'][$x][9]) ? $excel->sheets[0]['cells'][$x][9] : '';
			
			if(($identitytype == "1") || (strtoupper($identitytype) == "KTP")){
				$identitytype = "1";
			}
			else{
				$identitytype = "2";
			}
			
			if(($status == "1") || (strtoupper($status) == "ACTIVE")){
				$status = "1";
			}
			else{
				$status = "0";
			}
			
			$isexist = $this->check_membercode($membercode);
			if($isexist == 0){
				$res = $this->model_member->save_data($membercode,$fullname,$phone,$email,$address,$identitytype,$identityid,$limittransaction,$status);
			}
			else{
				$res = $this->model_member->update_data_excel($membercode,$fullname,$phone,$email,$address,$identitytype,$identityid,$limittransaction,$status);
			}
			
			$x++;
        }
		
		if(file_exists($datafile)){
		   unlink($datafile);
		}
		
		redirect('master/member/index');
	}
}
