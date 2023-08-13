<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Load library phpspreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Price extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_price');
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        if ($this->session->userdata('userid') != '') {
            $this->load->view('v_price_index');
        } else {
            $this->session->set_flashdata('flash_login', 'Silahkan login ulang untuk dapat melanjutkan proses ini');
            redirect('home/index');
        }
    }

    public function get_all_price()
    {
        $limit  = $this->input->post('length');
        $start  = $this->input->post('start');
        $search = $this->input->post('search')['value'];

        $price        = $this->model_price->get_all($limit, $start, $search);
        $price_count  = $this->model_price->get_count_all($search);
        $tot_all_data = $price_count->tot_data;

        $data = array();
        foreach ($price->result_array() as $row) {
            $keuntungan = $row['selling_price'] - $row['buying_price'];
            if ($row['buying_price'] <= 0) {
                $persen_keuntungan = "0";
            } else {
                $persen_keuntungan = number_format((($keuntungan / $row['buying_price']) * 100), 0);
            }
            // $profit = $row['selling_price'] - $row['buying_price'] . " <small>(" . ($row['buying_price'] == 0) ? 0 : (($row['selling_price'] - $row['buying_price']) / $row['buying_price']  * 100) . "%)</small>";
            $profit = number_format($keuntungan, 0) . " <small>(" . $persen_keuntungan . "%)</small>";

            // $action = '<button class="btn btn-sm btn-success bold" onclick="view_data(' . $row['item_price_id'] . ')"><i class="fa fa-file-text-o"></i></button>&nbsp;<button class="btn btn-sm btn-warning bold" onclick="edit_data(' . $row['item_price_id'] . ')"><i class="fa fa-pencil"></i></button>&nbsp<button class="btn btn-sm btn-danger bold" onclick="delete_data(' . $row['item_price_id'] . ')"><i class="fa fa-ban"></i></button>';

            $harga_grosir      = number_format($row['harga_grosir']);
            $minimal_pembelian = $row['minimal_pembelian'];

            $action = '<button class="btn btn-sm btn-success bold" onclick="view_data(' . $row['item_price_id'] . ')"><i class="fa fa-file-text-o"></i></button>';

            $nested = [
                'item_name'         => $row['item_name'],
                'period'            => date('d M Y', strtotime($row['start_period'])),
                'buying_price'      => $row['buying_price'],
                'selling_price'     => $row['selling_price'],
                'profit'            => $profit,
                'harga_grosir'      => $harga_grosir,
                'minimal_pembelian' => $minimal_pembelian,
                'action'            => $action,
            ];
            // $sub_array[]          = $row['item_name'];
            // $sub_array[]          = date('d M Y', strtotime($row['start_period']));
            // $sub_array[]          = number_format($row['buying_price'], 0, ",", ".");
            // $sub_array[]          = number_format($row['selling_price'], 0, ",", ".");
            // $sub_array[]          = number_format($row['selling_price'] - $row['buying_price'], 0, ",", ".") . " <small>(" . number_format(($row['buying_price'] == 0) ? 0 : (($row['selling_price'] - $row['buying_price']) / $row['buying_price']  * 100), 2, ",", ".") . "%)</small>";
            // $sub_array[]          = '<button class="btn btn-sm btn-success bold" onclick="view_data(' . $row['item_price_id'] . ')"><i class="fa fa-file-text-o"></i></button>&nbsp;<button class="btn btn-sm btn-warning bold" onclick="edit_data(' . $row['item_price_id'] . ')"><i class="fa fa-pencil"></i></button>&nbsp<button class="btn btn-sm btn-danger bold" onclick="delete_data(' . $row['item_price_id'] . ')"><i class="fa fa-ban"></i></button>';
            // $data[]          = $sub_array;
            array_push($data, $nested);
        }
        $output = array(
            "draw"              => intval($_POST["draw"]),
            "recordsTotal"      => intval($tot_all_data),
            "recordsFiltered"   => intval($tot_all_data),
            "data"              => $data
        );
        echo json_encode($output);
    }

    public function prepare_data()
    {
        $branchid = $this->session->userdata('branchid');
        $officetype = $this->session->userdata('officetype');
        if ($officetype == 1) {
            $data['branch'] = $this->model_price->dd_branch();
        } else {
            $data['branch'] = $this->model_price->dd_branch_only($branchid);
        }

        $data['item'] = $this->model_price->dd_item();
        echo json_encode($data);
    }

    public function ajax_view()
    {
        if ($this->session->userdata('userid') != '') {
            $id = $this->input->post('id');
            $arr = $this->model_price->get_by_id($id);

            $data = [];
            foreach ($arr->result() as $key) {
                $keuntungan = $key->selling_price - $key->buying_price;
                $persen_keuntungan = number_format((($keuntungan / $key->buying_price) * 100), 0);

                $data['item_price_id']       = $key->item_price_id;
                $data['branch_id']           = $key->branch_id;
                $data['item_id']             = $key->item_id;
                $data['start_period']        = $key->start_period;
                $data['buying_price']        = number_format($key->buying_price, 0, ',', '.');
                $data['buying_price_plain']  = $key->buying_price;
                $data['selling_price']       = number_format($key->selling_price, 0, ',', '.');
                $data['selling_price_plain'] = $key->selling_price;
                $data['keuntungan']          = number_format($keuntungan, 0, ',', '.');
                $data['persen']              = number_format($persen_keuntungan, 0, ',', '.');
                $data['branch_name']         = $key->branch_name;
                $data['item_name']           = $key->item_name;
            }
            echo json_encode($data);
        } else {
            echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
        }
    }

    public function ajax_add()
    {
        if ($this->session->userdata('userid') != '') {

            $branchid          = $this->input->post('branchid');
            $itemid            = $this->input->post('itemid');
            $startperiod       = $this->input->post('startperiod');
            $buyingprice       = $this->input->post('buyingprice');
            $sellingprice      = $this->input->post('sellingprice');
            $harga_grosir      = $this->input->post('harga_grosir');
            $minimal_pembelian = $this->input->post('minimal_pembelian');
            $creatorid         = $this->session->userdata('userid');

            $dtstartperiod = date('Y-m-d', strtotime($startperiod));

            $insert = $this->model_price->save_data($branchid, $itemid, $dtstartperiod, $buyingprice, $sellingprice, $harga_grosir, $minimal_pembelian, $creatorid);
            if ($insert) {
                echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Tambah Data'));
            } else {
                echo json_encode(array('status' => FALSE, 'message' => 'Gagal Tambah Data'));
            }
        } else {
            echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
        }
    }

    public function ajax_update()
    {
        if ($this->session->userdata('userid') != '') {

            $id            = $this->input->post('priceid');
            $buyingprice   = $this->input->post('buyingprice');
            $sellingprice  = $this->input->post('sellingprice');
            $startperiod   = $this->input->post('startperiod');
            $modificatorid = $this->session->userdata('userid');

            $insert = $this->model_price->edit_data($buyingprice, $sellingprice, $modificatorid, $id, $startperiod);
            if ($insert) {
                echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Ubah Data'));
            } else {
                echo json_encode(array('status' => FALSE, 'message' => 'Gagal Ubah Data'));
            }
        } else {
            echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
        }
    }

    public function ajax_delete()
    {
        if ($this->session->userdata('userid') != '') {
            $id = $this->input->post('id');
            $res = $this->model_price->delete_data($id);
            if ($res) {
                echo json_encode(array('status' => TRUE, 'message' => 'Berhasil Hapus Data'));
            } else {
                echo json_encode(array('status' => TRUE, 'message' => 'Gagal Hapus Data'));
            }
        } else {
            echo json_encode(array('status' => FALSE, 'message' => 'Silahkan login ulang untuk dapat melanjutkan proses ini'));
        }
    }

    public function price_period_isexist()
    {
        $itemid = $this->input->post('itemid');
        $startperiod = $this->input->post('startperiod');
        $endperiod = $this->input->post('endperiod');

        $dtstartperiod = date('Y-m-d', strtotime($startperiod));
        $dtendperiod = date('Y-m-d', strtotime($endperiod));

        $isexist = $this->check_price($itemid, $dtstartperiod, $dtendperiod);
        echo json_encode($data['response'] = $isexist);
    }

    public function check_price($itemid, $dtstartperiod, $dtendperiod)
    {
        $result = $this->model_price->check_price_exist($itemid, $dtstartperiod, $dtendperiod);
        return $result->is_exist;
    }

    public function get_export()
    {
        $result['report'] = $this->model_price->get_all();
        $this->load->view('v_price_excel', $result);
    }

    function file_upload()
    {
        $config['upload_path'] = "./././public";
        $config['allowed_types'] = 'xls|xlsx';

        $this->load->library('upload', $config);
        if ($this->upload->do_upload("file")) {
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
        while ($x <= $excel->sheets[0]['numRows']) {
            $barcode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
            $startperiod = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
            $endperiod = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
            $minprice = isset($excel->sheets[0]['cells'][$x][4]) ? $excel->sheets[0]['cells'][$x][4] : '';
            $memberprice = isset($excel->sheets[0]['cells'][$x][5]) ? $excel->sheets[0]['cells'][$x][5] : '';

            $y = date('Y', strtotime($startperiod));
            $m = date('m', strtotime($startperiod));
            $d = date('d', strtotime($startperiod));

            array_push($tmpdata, [
                'barcode' => $y,
                'startperiod' => $m,
                'endperiod' => $d,
                'minprice' => $startperiod,
                'memberprice' => $endperiod
            ]);

            $x++;
        }
        $data['data_excell'] = $tmpdata;
        $data['filename'] = $filename;

        $this->load->view('v_price_import', $data);
    }

    public function import_post()
    {
        $filename = $this->input->post('filename');
        $datafile = 'public/' . $filename;

        $excel = new Spreadsheet_Excel_Reader();
        $excel->read($datafile);

        $x = 2;
        while ($x <= $excel->sheets[0]['numRows']) {
            $barcode = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
            $dtstartperiod = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
            $dtendperiod = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
            $minprice = isset($excel->sheets[0]['cells'][$x][4]) ? $excel->sheets[0]['cells'][$x][4] : '';
            $memberprice = isset($excel->sheets[0]['cells'][$x][5]) ? $excel->sheets[0]['cells'][$x][5] : '';

            $item = $this->model_price->search_item($barcode);
            $itemid = $item->item_id;

            $isexist = $this->check_price($itemid, $dtstartperiod, $dtendperiod);
            if ($isexist == 0) {
                $res = $this->model_price->save_data($itemid, $dtstartperiod, $dtendperiod, $minprice, $memberprice);
            } else {
                $res = $this->model_price->update_data_excel($itemid, $dtstartperiod, $dtendperiod, $minprice, $memberprice);
            }

            $x++;
        }

        if (file_exists($datafile)) {
            unlink($datafile);
        }

        redirect('master/price/index');
    }
}
