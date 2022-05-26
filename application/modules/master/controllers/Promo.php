<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo extends MX_Controller {

	public function __construct(){
		parent::__construct();		
        $this->load->model('model_promo');	
        $this->load->helper('form_helper');
	}
	
	public function index()
	{
        if($this->session->userdata('userid') != ''){
            
            $branchid = $this->session->userdata('branchid');
            $officetype = $this->session->userdata('officetype');
            if($officetype == 1){
                $data['branch'] = $this->model_promo->dd_branch();
            }
            else{
                $data['branch'] = $this->model_promo->dd_branch_only($branchid);
            }

            $data['promo'] = $this->model_promo->get_all();
            $data['stockcategory'] = $this->model_promo->dd_stock_category();
            $this->load->view('v_promo_index', $data);
        }
        else{
            $this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
            redirect('home/index');
        }
    }
    
	public function get_item()
    {
        if($this->session->userdata('userid') != ''){
			$id = $this->input->post('stockcategoryid');
			$data = $this->model_promo->get_item($id);
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
            $data = $this->model_promo->get_by_id($id);
            echo json_encode($data);
        }
		else{
			echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
		}
	}
	
	public function ajax_add()
    {
        if($this->session->userdata('userid') != ''){

			$result = $this->model_promo->last_promo_code();
            if($result){
                $last_number = $result->last_number;
                $last_number = $last_number + 1;
                $promocode = "PR" . date("Y") . date("m") . substr("000" . $last_number,-4);
            }else{
                $promocode = "PR" . date("Y") . date("m") . "0001";
            }

			$promoname = $this->input->post('promoname');
			$branchid = $this->input->post('branchid');
			$stockcategoryid = $this->input->post('stockcategoryid');
			$itemid = $this->input->post('itemid');
			$startperiod = $this->input->post('startperiod');
			$endperiod = $this->input->post('endperiod');
			$discpercentage = $this->input->post('discpercentage');
			$discamount = $this->input->post('discamount');
			$creatorid = $this->session->userdata('userid');
				
			$dtstartperiod = date('Y-m-d',strtotime($startperiod));
			$dtendperiod = date('Y-m-d',strtotime($endperiod));
			
			$insert = $this->model_promo->save_data($promocode,$promoname,$branchid,$stockcategoryid,$itemid,$dtstartperiod,$dtendperiod,$discpercentage,$discamount,$creatorid);
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

			$id = $this->input->post('priceid');
			$endperiod = $this->input->post('endperiod');
			$modificatorid = $this->session->userdata('userid');
				
			$dtendperiod = date('Y-m-d',strtotime($endperiod));
			
            $insert = $this->model_promo->edit_data($dtendperiod,$modificatorid,$id);
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
            $res = $this->model_promo->delete_data($id);
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
        $data['promo'] = $this->model_promo->get_by_id($id);
        if(!empty($data['promo'])){
            $this->load->view('v_promo_view',$data);
        }else{
            redirect('master/promo/index');
        }
    }
    
    public function create()
    {
        $data['stockitem'] = $this->model_promo->dd_stockitem();
        $this->load->view('v_promo_add', $data);
    }
    
    public function create_post()
    {
        $itemid = $this->input->post('itemid');
        $startperiod = $this->input->post('startperiod');
		$endperiod = $this->input->post('endperiod');
        $promotype = $this->input->post('promotype');
        $discpercentage = $this->input->post('discpercentage');
        $discamount = $this->input->post('discamount');
        
        $dtstartperiod = date('Y-m-d',strtotime($startperiod));
        $dtendperiod = date('Y-m-d',strtotime($endperiod));

        if($discpercentage == ''){
            $discpercentage = 0;
        }

        if($discamount == ''){
            $discamount = 0;
        }
        
        $isexist = $this->check_promo($itemid,$dtstartperiod,$dtendperiod,$promotype);
        
        if($isexist == 0){
            $res = $this->model_promo->save_data($itemid,$dtstartperiod,$dtendperiod,$promotype,$discpercentage,$discamount);
            if($res == "success"){
                redirect('master/promo/index');
            }else{
                redirect('master/promo/index');
            }
        }
        else{
            redirect('master/promo/index');
        }
    }
    
    public function edit($id)
    {
        $data['promo'] = $this->model_promo->get_by_id($id);
        if(!empty($data['promo'])){
            $this->load->view('v_promo_edit',$data);
        }else{
            redirect('master/promo/index');
        }
    }

    public function edit_post()
    {
		$id = $this->input->post('itempromoid');
		$endperiod = $this->input->post('endperiod');
        $promotype = $this->input->post('promotype');
        $discpercentage = $this->input->post('discpercentage');
        $discamount = $this->input->post('discamount');
 
        $dtstartperiod = date('Y-m-d',strtotime($startperiod));
        $dtendperiod = date('Y-m-d',strtotime($endperiod));

        if($discpercentage==''){
            $discpercentage=0;
        }

        if($discamount==''){
            $discamount=0;
        }
 
        $result = $this->model_promo->check_promo_exist($itemid,$dtstartperiod,$dtendperiod,$promotype);
		if($result){
			$isexist = $result->is_exist;
		}else{
			$isexist = -1;
        }
        
        if($isexist == 0){
            $res = $this->model_promo->edit_data($dtendperiod,$promotype,$discpercentage,$discamount,$id);
            if($res == "success"){
                redirect('master/promo/index');
            }else{
                redirect('master/promo/index');
            }
        }
        else{
            redirect('master/promo/index');
        }
    }

    public function delete(){
        $id = $this->input->post('itempromoid');

        $res = $this->model_promo->delete($id);
        echo json_encode($data['response'] = $res);
    }

    public function check_promo($itemid,$dtstartperiod,$dtendperiod,$promotype){
        $result = $this->model_promo->check_promo_exist($itemid,$dtstartperiod,$dtendperiod,$promotype);
        return $result->is_exist;
    }

    public function get_export()
    {
        $result['report'] = $this->model_promo->get_all();
        $this->load->view('v_promo_excel', $result);
    }
}
