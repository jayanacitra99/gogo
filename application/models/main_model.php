<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {

	public function do_login()
	{
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));

		$query = $this->db 	->where('username',$username)
							->where('password', $password)
							->get('user'); 

		if($query->num_rows() > 0 ) {
			$data = array (
					'username'	=> $username,
					'logged_in'	=> TRUE
				);
			$this->session->set_userdata($data);

			return TRUE;
		}else {
			return FALSE;
		}
	}

	public function do_register(){
		$data = array (
				'username' 		=> $this->input->post('username'),
				'email' 	=> $this->input->post('email'),
				'password' 		=> md5($this->input->post('password')),
			);
		$this->db->insert('user', $data);

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	public function get_data_resto(){
		return $this->db->order_by('id_resto','ASC')
						->get('resto')
						->result();
	}

	public function get_data_menu_by_resto($RESTO){
		return $this->db->where('id_resto', $RESTO)
						->get('menu')
						->result();
	}

	public function get_data_id_by_username($user){
		return $this->db->where('username', $user)
						->get('user')
						->row();
	}

	public function place_orders(){
		date_default_timezone_set('Asia/Jakarta');
        $timestamp = date('Y-m-d H:i:s');
		$data_order = array (
			'id_user'		=> $this->input->post('id_cust'),
			'id_resto'		=> $this->input->post('id_resto'),
			'total_bayar'	=> NULL,
			'no_table'		=> $this->input->post('table'),
			'created_at'	=> $timestamp,
			'status'		=> 'WAITING'
		);

		$this->db->insert('order_list',$data_order);

		$orders = $_POST['orders'];
		$quantity = $_POST['quantity'];
		$totalbayar = 0;

		foreach ($orders as $index => $orderlist) {
			$query = $this->db->select("MAX(id_order) AS idOrder")
							->from('order_list')
							->get();
			$order = $query->row()->idOrder;

			$menu = $this->db->select('id_menu')
							->where('menu',$orders[$index])
							->get('menu')
							->result_array()[0]['id_menu'];

			$data_details = array(
				'id_order'	=> $order,
				'id_menu' 	=> $menu,
				'quantity'	=> $quantity[$index] 
			);

			$this->db->insert('order_details',$data_details);

			$total = $this->db->select('*')
								->where('id_order',$order)
								->join('menu', 'menu.id_menu = order_details.id_menu')
								->get('order_details')
								->row();
			$temp = $total->harga * $total->quantity;
			$totalbayar = $totalbayar + $temp;

		}

		$data = array (
			'total_bayar' => $totalbayar,
		);

		$this->db->where('id_order',$order)
				->update('order_list',$data);

		if($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function payment(){
		$query = $this->db->select("MAX(id_order) AS idOrder")
							->from('order_list')
							->get();
		$order = $query->row()->idOrder;
		$data = array(
			'id_order' 	=> $order,
			'payment' 	=> $this->input->post('payment_method'),
			'va'		=> $this->input->post('va'),
		);
		$this->db->insert('invoice',$data);
		$dataa = array(
			'status'		=> 'FINISH'
		);

		$this->db->where('id_order', $order)->update('order_list', $dataa);

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_data_order_by_id($id){
		return $this->db->select('*')
						->order_by('order_list.id_order','DESC')
						->where('order_list.id_user',$id)
						->join('resto', 'resto.id_resto = order_list.id_resto')
						->join('user', 'user.id_user = order_list.id_user')
						->get('order_list')
						->result();
	}

	public function selects_bill($id){
		return $this->db->where('order_list.id_order',$id)
						->join('resto', 'resto.id_resto = order_list.id_resto')
						->join('order_details', 'order_details.id_order = order_list.id_order')
						->join('user', 'user.id_user = order_list.id_user')
						->join('menu', 'menu.id_menu = order_details.id_menu')
						->get('order_list')
						->row();
	}

	public function getmenu($id){
		return $this->db->where('order_list.id_order',$id)
						->join('order_list', 'order_list.id_order = order_details.id_order')
						->join('menu', 'menu.id_menu = order_details.id_menu')
						->get('order_details')
						->result();
	}

}

/* End of file main_model.php */
/* Location: ./application/models/main_model.php */