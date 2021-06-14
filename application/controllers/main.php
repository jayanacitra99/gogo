<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('main_model');
	}

	public function index()
	{
		if($this->session->userdata('logged_in') == TRUE){
			redirect(base_url('index.php/main/dashboard'));
		}else {
			$this->load->view('login');
		}
	}

	public function do_login(){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				if($this->main_model->do_login()){
					redirect(base_url('index.php/main/dashboard'));
				}else {
					$data['notif'] = 'Gagal Login !!';
					$this->load->view('login', $data);
				}
			} else {
				$data['notif'] = validation_errors();
				$this->load->view('login', $data);
			}
		}else {
			redirect(base_url());
		}
	}

	public function logout(){
		$data = array(
				'username' => '',
				'logged_in'=> FALSE
			);
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function register(){
		$this->load->view('register');
	}

	public function do_register(){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[user.username]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
			if ($this->form_validation->run() == TRUE) {
				if($this->main_model->do_register()){
					$data['success'] = 'Account Created !!';
					$this->load->view('login', $data);
				}else {
					$data['notif'] = 'Gagal Menambahkan !!';
					$this->load->view('register',$data);
				}
			} else {
				$data['notif'] = validation_errors();
				$this->load->view('register',$data);
			}
		}else {
			redirect(base_url('index.php/main/register'),'refresh');
		}
	}

	public function dashboard(){
		if($this->session->userdata('logged_in') == TRUE){
			$data['username'] = $this->session->userdata('username');
			$data['resto'] = $this->main_model->get_data_resto();
			$data['main_view'] = 'dashboard';
			$this->load->view('template',$data);
		}else {
			$this->load->view('login');
		}
	}

	public function menu(){
		if ($this->session->userdata('logged_in') == TRUE) {
			$digits = 10;
			$data['randVA'] =  rand(pow(10, $digits-1), pow(10, $digits)-1);
			$MENU = $this->uri->segment(3);
			$data['menu'] = $this->main_model->get_data_menu_by_resto($MENU);
			$username = $this->session->userdata('username');
			$data['username'] = $this->session->userdata('username');
			$data['resto'] = $this->main_model->get_data_resto();
			$data['id'] = $this->main_model->get_data_id_by_username($username);
			$data['main_view'] = 'menu';

			$this->load->view('template', $data);
		} else {
			redirect('main','refresh');
		}
	}

	public function place_order(){
		if ($this->session->userdata('logged_in') == TRUE) {	
			if($this->input->post('submit')){
				$this->main_model->place_orders();	
				redirect('main/history');
			} else {
				redirect('main','refresh');
			}
		} else {
			redirect('main','refresh');
		}
	}

	public function payment(){
		if ($this->session->userdata('logged_in') == TRUE) {	
			if($this->input->post('submit')){
				$this->main_model->payment();
				redirect('main/dashboard');
			} else {
				redirect('main','refresh');
			}
		} else {
			redirect('main','refresh');
		}
	}

	public function history(){
		if ($this->session->userdata('logged_in') == TRUE) {	
			$username = $this->session->userdata('username');
			$id = $this->main_model->get_data_id_by_username($username);
			$id_cust = $id->id_user;
			$data['username'] = $this->session->userdata('username');
			$data['resto'] = $this->main_model->get_data_resto();
			$data['list'] = $this->main_model->get_data_order_by_id($id_cust);
			$data['main_view'] = 'history';
			$this->load->view('template',$data);
		} else {
			redirect('main','refresh');
		}
	}

	public function detail_bill(){
		$orderid = $this->input->post('hello');
		$data['laos'] = $this->main_model->selects_bill($orderid);
		$data['menu'] = $this->main_model->getmenu($orderid);
		$this->load->view('bill', $data);
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */