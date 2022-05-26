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

class Stock_unit extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_stock_unit');	
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
            $data['stockunit'] = $this->model_stock_unit->get_all();
            $this->load->view('v_stock_unit_index', $data);
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
            $data = $this->model_stock_unit->get_by_id($id);
            echo json_encode($data);
        }
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_add()
    {
        if($this->session->userdata('userid') != ''){

			$result = $this->model_stock_unit->last_unit_code();
			if($result){
				$last_number = $result->last_number;
				$last_number = $last_number + 1;
				$unitcode = "SU" . date("y") . date("m") . substr("000" . $last_number,-4);
			}else{
				$unitcode = "SU" . date("y") . date("m") . "0001";
			}

			$unitname = $this->input->post('unitname');
			$creatorid = $this->session->userdata('userid');
				
			$insert = $this->model_stock_unit->save_data($unitcode,$unitname,$creatorid);
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

			$id = $this->input->post('unitid');
			$unitname = $this->input->post('unitname');
			$modificatorid = $this->session->userdata('userid');
				
            $insert = $this->model_stock_unit->edit_data($unitname,$modificatorid,$id);
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
            $res = $this->model_stock_unit->delete_data($id);
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
        $data['stockunit'] = $this->model_stock_unit->get_by_id($id);
        if(!empty($data['stockunit'])){
            $this->load->view('v_stock_unit_view',$data);
        }else{
            redirect('master/stock_unit/index');
        }
    }
    
    public function create()
    {
        $this->load->view('v_stock_unit_add');
    }
    
    public function create_post()
    {
        $stockunitcode = $this->input->post('stockunitcode');
		$stockunitname = $this->input->post('stockunitname');
 
		$res = $this->model_stock_unit->save_data($stockunitcode,$stockunitname);
		if($res == "success"){
			redirect('master/stock_unit/index');
		}else{
			redirect('master/stock_unit/index');
		}
    }
    
    public function edit($id)
    {
        $data['stockunit'] = $this->model_stock_unit->get_by_id($id);
        if(!empty($data['stockunit'])){
            $this->load->view('v_stock_unit_edit',$data);
        }else{
            redirect('master/stock_unit/index');
        }
    }

    public function edit_post()
    {
		$id = $this->input->post('stockunitid');
		$stockunitname = $this->input->post('stockunitname');
 
		$res = $this->model_stock_unit->edit_data($stockunitname,$id);
		if($res == "success"){
			redirect('master/stock_unit/index');
		}else{
			redirect('master/stock_unit/index');
		}
    }

    public function delete(){
        $id = $this->input->post('stockunitid');

        $res = $this->model_stock_unit->delete($id);
        echo json_encode($data['response'] = $res);
    }

    public function check_stockunitcode($stockunitcode){
        $result = $this->model_stock_unit->check_stockunitcode_exist($stockunitcode);
        return $result->is_exist;
    }

    public function stockunitcode_isexist(){
        $stockunitcode = $this->input->post('stockunitcode');

        $isexist = $this->check_stockunitcode($stockunitcode);
        echo json_encode($data['response'] = $isexist);
    }

    public function get_export()
    {
        $result['report'] = $this->model_stock_unit->get_all();
        $this->load->view('v_stock_unit_excel', $result);
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
			$stockunitcode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
			$stockunitname = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
			
			array_push($tmpdata, [
				'stockunitcode' => $stockunitcode,
				'stockunitname' => $stockunitname
			]);
			
			$x++;
		}
		$data['data_excell'] = $tmpdata;
		$data['filename'] = $filename;
		
        $this->load->view('v_stock_unit_import',$data);
    }
    
    public function import_post()
	{
		$filename = $this->input->post('filename');
		$datafile = 'public/' . $filename;
		
		$excel = new Spreadsheet_Excel_Reader();
		$excel->read($datafile);
		
		$x = 2;
        while($x <= $excel->sheets[0]['numRows']){
			$stockunitcode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
			$stockunitname = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
			
			$isexist = $this->check_stockunitcode($stockunitcode);
			if($isexist == 0){
				$res = $this->model_stock_unit->save_data($stockunitcode,$stockunitname);
			}
			else{
				$res = $this->model_stock_unit->update_data_excel($stockunitcode,$stockunitname);
			}
			
			$x++;
        }
		
		if(file_exists($datafile)){
		   unlink($datafile);
		}
		
		redirect('master/stock_unit/index');
	}
}
