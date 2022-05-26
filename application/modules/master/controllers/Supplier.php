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

class Supplier extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_supplier');
		$this->load->helper(array('form', 'url'));
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
			$data['supplier'] = $this->model_supplier->get_all();
			$this->load->view('v_supplier_index', $data);
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
            $data = $this->model_supplier->get_by_id($id);
            echo json_encode($data);
        }
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_add()
    {
        if($this->session->userdata('userid') != ''){

			$result = $this->model_supplier->last_supplier_code();
			if($result){
				$last_number = $result->last_number;
				$last_number = $last_number + 1;
				$suppliercode = "SP" . date("Y") . date("m") . substr("000" . $last_number,-4);
			}else{
				$suppliercode = "SP" . date("Y") . date("m") . "0001";
			}

			$suppliername = $this->input->post('suppliername');
			$contactname = $this->input->post('contactname');
			$phone = $this->input->post('phone');
			$handphone = $this->input->post('handphone');
			$email = $this->input->post('email');
			$city = $this->input->post('city');
			$address = $this->input->post('address');
			$description = $this->input->post('description');
			$creatorid = $this->session->userdata('userid');
				
			$insert = $this->model_supplier->save_data($suppliercode,$suppliername,$contactname,$phone,$handphone,$email,$city,$address,$description,$creatorid);
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

			$id = $this->input->post('supplierid');
			$suppliername = $this->input->post('suppliername');
			$contactname = $this->input->post('contactname');
			$phone = $this->input->post('phone');
			$handphone = $this->input->post('handphone');
			$email = $this->input->post('email');
			$city = $this->input->post('city');
			$address = $this->input->post('address');
			$description = $this->input->post('description');
			$modificatorid = $this->session->userdata('userid');
				
            $insert = $this->model_supplier->edit_data($suppliername,$contactname,$phone,$handphone,$email,$city,$address,$description,$modificatorid,$id);
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
            $res = $this->model_supplier->delete_data($id);
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
    
    public function view($id)
    {
        $data['supplier'] = $this->model_supplier->get_by_id($id);
        if(!empty($data['supplier'])){
            $this->load->view('v_supplier_view',$data);
        }else{
            redirect('master/supplier/index');
        }
    }
    
    public function create()
    {
        $result = $this->model_supplier->last_supplier_code();
        if($result){
            $last_number = $result->last_number;
            $last_number = $last_number + 1;
            $suppliercode = "SP" . date("Y") . date("m") . substr("000" . $last_number,-4);
        }else{
            $suppliercode = "SP" . date("Y") . date("m") . "0001";
        }
        $data = array('suppliercode' => $suppliercode);
        $this->load->view('v_supplier_add',$data);
    }
    
    public function create_post()
    {
        $suppliercode = $this->input->post('suppliercode');
		$suppliername = $this->input->post('suppliername');
        $contactname = $this->input->post('contactname');
		$phone = $this->input->post('phone');
        $handphone = $this->input->post('handphone');
		$email = $this->input->post('email');
        $city = $this->input->post('city');
		$address = $this->input->post('address');
		$description = $this->input->post('description');
 
        $isexist = $this->check_suppliercode($suppliercode);
        
        if($isexist == 0){
    		$res = $this->model_supplier->save_data($suppliercode,$suppliername,$contactname,$phone,$handphone,$email,$city,$address,$description);
    		if($res == "success"){
    			redirect('master/supplier/index');
    		}else{
    			redirect('master/supplier/index');
    		}
        }
        else{
            redirect('master/supplier/index');
        }
    }
    
    public function edit($id)
    {
        $data['supplier'] = $this->model_supplier->get_by_id($id);
        if(!empty($data['supplier'])){
            $this->load->view('v_supplier_edit',$data);
        }else{
            redirect('master/supplier/index');
        }
    }

    public function edit_post()
    {
        $id = $this->input->post('supplierid');
        $contactname = $this->input->post('contactname');
		$phone = $this->input->post('phone');
        $handphone = $this->input->post('handphone');
		$email = $this->input->post('email');
        $city = $this->input->post('city');
		$address = $this->input->post('address');
		$description = $this->input->post('description');
 
		$res = $this->model_supplier->update_data($contactname,$phone,$handphone,$email,$city,$address,$description,$id);
		if($res == "success"){
			redirect('master/supplier/index');
		}else{
			redirect('master/supplier/index');
		}
    }

    public function delete(){
        $id = $this->input->post('supplierid');

        $res = $this->model_supplier->delete($id);
        echo json_encode($data['response'] = $res);
    }

    public function check_suppliercode($suppliercode){
        $result = $this->model_supplier->check_suppliercode_exist($suppliercode);
        return $result->is_exist;
    }

    public function get_export()
    {
        $result['report'] = $this->model_supplier->get_all();
        $this->load->view('v_supplier_excel', $result);
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
			$suppliercode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
			$suppliername = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
			$contactname = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
			$phone = isset($excel->sheets[0]['cells'][$x][4]) ? $excel->sheets[0]['cells'][$x][4] : '';
			$handphone = isset($excel->sheets[0]['cells'][$x][5]) ? $excel->sheets[0]['cells'][$x][5] : '';
			$email = isset($excel->sheets[0]['cells'][$x][6]) ? $excel->sheets[0]['cells'][$x][6] : '';
			$city = isset($excel->sheets[0]['cells'][$x][7]) ? $excel->sheets[0]['cells'][$x][7] : '';
			$address = isset($excel->sheets[0]['cells'][$x][8]) ? $excel->sheets[0]['cells'][$x][8] : '';
			$description = isset($excel->sheets[0]['cells'][$x][9]) ? $excel->sheets[0]['cells'][$x][9] : '';
			
			array_push($tmpdata, [
				'suppliercode' => $suppliercode,
				'suppliername' => $suppliername,
				'contactname' => $contactname,
				'phone' => $phone,
				'handphone' => $handphone,
				'email' => $email,
				'city' => $city,
				'address' => $address,
				'description' => $description
			]);
			
			$x++;
		}
		$data['data_excell'] = $tmpdata;
		$data['filename'] = $filename;
		
        $this->load->view('v_supplier_import',$data);
    }
    
    public function import_post()
	{
		$filename = $this->input->post('filename');
		$datafile = 'public/' . $filename;
		
		$excel = new Spreadsheet_Excel_Reader();
		$excel->read($datafile);
		
		$x = 2;
        while($x <= $excel->sheets[0]['numRows']){
			$suppliercode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
			$suppliername = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
			$contactname = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
			$phone = isset($excel->sheets[0]['cells'][$x][4]) ? $excel->sheets[0]['cells'][$x][4] : '';
			$handphone = isset($excel->sheets[0]['cells'][$x][5]) ? $excel->sheets[0]['cells'][$x][5] : '';
			$email = isset($excel->sheets[0]['cells'][$x][6]) ? $excel->sheets[0]['cells'][$x][6] : '';
			$city = isset($excel->sheets[0]['cells'][$x][7]) ? $excel->sheets[0]['cells'][$x][7] : '';
			$address = isset($excel->sheets[0]['cells'][$x][8]) ? $excel->sheets[0]['cells'][$x][8] : '';
			$description = isset($excel->sheets[0]['cells'][$x][9]) ? $excel->sheets[0]['cells'][$x][9] : '';
			
			$isexist = $this->check_suppliercode($suppliercode);
			if($isexist == 0){
				$res = $this->model_supplier->save_data($suppliercode,$suppliername,$contactname,$phone,$handphone,$email,$city,$address,$description);
			}
			else{
				$res = $this->model_supplier->update_data_excel($suppliercode,$suppliername,$contactname,$phone,$handphone,$email,$city,$address,$description);
			}
			
			$x++;
        }
		
		if(file_exists($datafile)){
		   unlink($datafile);
		}
		
		redirect('master/supplier/index');
	}
}
