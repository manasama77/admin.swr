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

class Bundling extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('model_bundling');
	}
	
	public function index()
	{
        $data['bundling'] = $this->model_bundling->get_all();
        $data['branch'] = $this->model_bundling->dd_branch();
        $data['item'] = $this->model_bundling->dd_item();
		$this->load->view('v_bundling_index', $data);
    }
    
    public function view($id)
    {
        $data['bundlingmaster'] = $this->model_bundling->get_by_id_master($id);
        $data['bundlingpromo'] = $this->model_bundling->get_by_id_promo($id);
        $data['bundlingprize'] = $this->model_bundling->get_by_id_prize($id);
        if(!empty($data['bundlingmaster'])){
            $this->load->view('v_bundling_view',$data);
        }else{
            redirect('master/bundling/index');
        }
    }
    
    public function import()
    {
        $this->load->view('v_bundling_import');
    }
    
    public function import_post()
    {
        if(isset($_POST["submit_file"]))
        { 
            $file = $_FILES["file"]["tmp_name"];
            $file_open = fopen($file,"r");
            while(($csv = fgetcsv($file_open, 1000, ",")) !== false) 
            { 
                $employee_name = $csv[0]; 
                $employee_designation = $csv[1]; 
                $employee_salary = $csv[2]; 
                
            }
        }
    }
    
    public function create()
    {
        $result = $this->model_bundling->last_bundling_code();
        if($result){
            $last_number = $result->last_number;
            $last_number = $last_number + 1;
            $bundlingcode = "BD" . date("Y") . date("m") . substr("000" . $last_number,-4);
        }else{
            $bundlingcode = "BD" . date("Y") . date("m") . "0001";
        }
        $data = array('bundlingcode' => $bundlingcode);
        $data['stockitem'] = $this->model_bundling->dd_stockitem();
        $this->load->view('v_bundling_add',$data);
    }
    
    public function create_post()
    {
        $bundlingcode = $this->input->post('bundlingcode');
        $bundlingname = $this->input->post('bundlingname');
        $startperiod = $this->input->post('startperiod');
        $endperiod = $this->input->post('endperiod');
        $information = $this->input->post('information');
        $status = $this->input->post('status');
        $listpromo = $this->input->post('listpromo');
        $listprize = $this->input->post('listprize');
 
        $dtstartperiod = date('Y-m-d',strtotime($startperiod));
        $dtendperiod = date('Y-m-d',strtotime($endperiod));
 
		$res = $this->model_bundling->save_data($bundlingcode,$bundlingname,$dtstartperiod,$dtendperiod,$information,$status,$listpromo,$listprize);
		if($res == "success"){
			redirect('master/bundling/index');
		}else{
			redirect('master/bundling/add');
		}
    }
    
    public function edit($id)
    {
        $data['bundling'] = $this->model_bundling->get_by_id($id);
        if(!empty($data['bundling'])){
            $this->load->view('v_bundling_edit',$data);
        }else{
            redirect('master/bundling/index');
        }
    }

    public function edit_post()
    {
        $id = $this->input->post('memberid');
        $bundlingname = $this->input->post('bundlingname');
        $startperiod = $this->input->post('startperiod');
        $endperiod = $this->input->post('endperiod');
        $status = $this->input->post('status');
        $itempromo = $this->input->post('itempromo');
        $itemprize = $this->input->post('itemprize');
 
        $dtstartperiod = date('Y-m-d',strtotime($startperiod));
        $dtendperiod = date('Y-m-d',strtotime($endperiod));
 
		$res = $this->model_bundling->update_data($bundlingname,$dtstartperiod,$dtendperiod,$status,$itempromo,$itemprize,$id);
		if($res == "success"){
			redirect('master/bundling/index');
		}else{
			redirect('master/bundling/index');
		}
    }

    public function delete(){
        $id = $this->input->post('itembundlingid');

        $res = $this->model_bundling->delete($id);
        echo json_encode($data['response'] = $res);
    }

    public function bundling_isexist(){
        $itemid = $this->input->post('itemid');
        $startperiod = $this->input->post('startperiod');
        $endperiod = $this->input->post('endperiod');

        $dtstartperiod = date('Y-m-d',strtotime($startperiod));
        $dtendperiod = date('Y-m-d',strtotime($endperiod));
 
        $isexist = $this->check_bundling($itemid,$dtstartperiod,$dtendperiod);
        echo json_encode($data['response'] = $isexist);
    }

    public function check_bundling($itemid,$dtstartperiod,$dtendperiod){
        $result = $this->model_bundling->check_bundling_exist($itemid,$dtstartperiod,$dtendperiod);
        return $result->is_exist;
    }

    public function get_export()
    {
        $result['report'] = $this->model_bundling->get_all();
        $this->load->view('v_bundling_excel', $result);
    }

}
