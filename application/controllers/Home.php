<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		// load model
		$this->load->model('model_home');

		// load Session Library
		$this->load->library('session');

		// load url helper
		$this->load->helper('url');
	}

	public function index()
	{
		$data['branch'] = $this->model_home->dd_branch();
		$this->load->view('login', $data);
	}

	public function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$result = $this->model_home->get_login($username, $password);

		if ($result) {
			$menu = $this->model_home->get_menu($result->user_group_id);

			if ($menu) {
				$html_admin = "";
				$html_supervisor = "";
				$html_kasir = "";
				$html_pramuniaga = "";

				$html = '<ul class="sidebar-menu" data-widget="tree">
					<li class="header">MENU</li>';

				$modulenamenew = '';
				$modulenameold = 'xx';

				foreach ($menu->result() as $item) {

					$modulenamenew = $item->module_name;

					if (($modulenameold != $modulenamenew) && ($modulenamenew != '')) {

						if (($modulenameold != 'xx') && ($modulenameold != '')) {
							$html .= '</ul>
							</li>';
						}

						$html .= '<li class="treeview">
						<a href="#">
						' . $item->module_icon . ' <span>' . $modulenamenew . '</span> <i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">';
					}

					if ($item->menu_name == 'Dashboard') {
						$html .= '<li><a href="' . base_url() . $item->menu_url . '"><i class="fa fa-book"></i><span> ' . $item->menu_name . '</span></a></li>';
					} else {
						$html .= '<li><a href="' . base_url() . $item->menu_url . '"><i class="fa fa-circle-o text-aqua"></i><span> ' . $item->menu_name . '</span></a></li>';
					}

					$modulenameold = $modulenamenew;
				}

				$html .= '</ul></li></ul>';

				if ($result->user_group_id == 1) {
					$html_admin = $html;
				} else if ($result->user_group_id == 9) {
					$html_supervisor = $html;
				} else if ($result->user_group_id == 10) {
					$html_kasir = $html;
				} else if ($result->user_group_id == 11) {
					$html_pramuniaga = $html;
				}
			}

			// set array of items in session
			$arraydata = array(
				'userid'          => $result->user_id,
				'usergroupid'     => $result->user_group_id,
				'fullname'        => $result->fullname,
				'branchid'        => $result->branch_id,
				'officetype'      => $result->office_type,
				'menu_admin'      => $html_admin,
				'menu_supervisor' => $html_supervisor,
				'menu_kasir'      => $html_kasir,
				'menu_pramuniaga' => $html_pramuniaga
			);
			$this->session->set_userdata($arraydata);

			$dash = $this->model_home->get_dash($result->user_group_id);
			$url_dash = $dash->menu_url;

			// if ($url_dash == 'sales/sales') {
			// 	$this->session->set_flashdata('flash_login', 'Untuk mengakses aplikasi kasir silahkan buka halaman <a href="' . URL_KASIR . '">' . URL_KASIR . '</a>');
			// 	redirect('home/index');
			// 	exit;
			// }
			redirect($url_dash);
		} else {
			// set flash data
			$this->session->set_flashdata('flash_login', 'Username / Password / Cabang tidak valid !!');
			redirect('home/index');
		}
	}

	public function logout()
	{
		// destroy session
		$this->session->sess_destroy();

		redirect('home/index');
	}
}
