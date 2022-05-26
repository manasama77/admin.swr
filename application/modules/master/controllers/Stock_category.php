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

class Stock_category extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_stock_category');	
		$this->load->helper(array('form', 'url'));
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
            $data['stockcategory'] = $this->model_stock_category->get_all();
            $this->load->view('v_stock_category_index', $data);
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
            $data = $this->model_stock_category->get_by_id($id);
            echo json_encode($data);
        }
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_add()
    {
        if($this->session->userdata('userid') != ''){

			$result = $this->model_stock_category->last_stock_category_code();
            if($result){
                $last_number = $result->last_number;
                $last_number = $last_number + 1;
                $stockcategorycode = "CG" . date("Y") . date("m") . substr("000" . $last_number,-4);
            }else{
                $stockcategorycode = "CG" . date("Y") . date("m") . "0001";
            }

			$stockcategoryname = $this->input->post('stockcategoryname');
			$creatorid = $this->session->userdata('userid');
				
			$insert = $this->model_stock_category->save_data($stockcategorycode,$stockcategoryname,$creatorid);
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

			$id = $this->input->post('stockcategoryid');
			$stockcategoryname = $this->input->post('stockcategoryname');
			$modificatorid = $this->session->userdata('userid');
				
            $insert = $this->model_stock_category->edit_data($stockcategoryname,$modificatorid,$id);
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
            $res = $this->model_stock_category->delete_data($id);
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
        $data['stockcategory'] = $this->model_stock_category->get_by_id($id);
        if(!empty($data['stockcategory'])){
            $this->load->view('v_stock_category_view',$data);
        }else{
            redirect('master/stock_category/index');
        }
    }
    
    public function create()
    {
        $result = $this->model_stock_category->last_stock_category_code();
        if($result){
            $last_number = $result->last_number;
            $last_number = $last_number + 1;
            $stockcategorycode = "CG" . date("Y") . date("m") . substr("000" . $last_number,-4);
        }else{
            $stockcategorycode = "CG" . date("Y") . date("m") . "0001";
        }
        $data = array('stockcategorycode' => $stockcategorycode);
        $this->load->view('v_stock_category_add',$data);
    }
    
    public function create_post()
    {
        $stockcategorycode = $this->input->post('stockcategorycode');
		$stockcategoryname = $this->input->post('stockcategoryname');
 
        $isexist = $this->check_stockcategorycode($stockcategorycode);
        
        if($isexist == 0){
    		$res = $this->model_stock_category->save_data($stockcategorycode,$stockcategoryname);
    		if($res == "success"){
    			redirect('master/stock_category/index');
    		}else{
    			redirect('master/stock_category/index');
    		}
        }
        else{
            redirect('master/supplier/index');
        }
    }
    
    public function edit($id)
    {
        $data['stockcategory'] = $this->model_stock_category->get_by_id($id);
        if(!empty($data['stockcategory'])){
            $this->load->view('v_stock_category_edit',$data);
        }else{
            redirect('master/stock_category/index');
        }
    }

    public function edit_post()
    {
		$id = $this->input->post('stockcategoryid');
		$stockcategoryname = $this->input->post('stockcategoryname');
 
		$res = $this->model_stock_category->edit_data($stockcategoryname,$id);
		if($res == "success"){
			redirect('master/stock_category/index');
		}else{
			redirect('master/stock_category/index');
		}
    }

    public function delete(){
        $id = $this->input->post('stockcategoryid');

        $res = $this->model_stock_category->delete($id);
        echo json_encode($data['response'] = $res);
    }

    public function check_stockcategorycode($stockcategorycode){
        $result = $this->model_stock_category->check_stockcategorycode_exist($stockcategorycode);
        return $result->is_exist;
    }

    public function get_export()
    {
        $result['report'] = $this->model_stock_category->get_all();
        $this->load->view('v_stock_category_excel', $result);
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
			$stockcategorycode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
			$stockcategoryname = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
			
			array_push($tmpdata, [
				'stockcategorycode' => $stockcategorycode,
				'stockcategoryname' => $stockcategoryname
			]);
			
			$x++;
		}
		$data['data_excell'] = $tmpdata;
		$data['filename'] = $filename;
		
        $this->load->view('v_stock_category_import',$data);
    }
    
    public function import_post()
	{
		$filename = $this->input->post('filename');
		$datafile = 'public/' . $filename;
		
		$excel = new Spreadsheet_Excel_Reader();
		$excel->read($datafile);
		
		$x = 2;
        while($x <= $excel->sheets[0]['numRows']){
			$stockcategorycode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
			$stockcategoryname = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
			
			$isexist = $this->check_stockcategorycode($stockcategorycode);
			if($isexist == 0){
				$res = $this->model_stock_category->save_data($stockcategorycode,$stockcategoryname);
			}
			else{
				$res = $this->model_stock_category->update_data_excel($stockcategorycode,$stockcategoryname);
			}
			
			$x++;
        }
		
		if(file_exists($datafile)){
		   unlink($datafile);
		}
		
		redirect('master/stock_category/index');
	}
}
