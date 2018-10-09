<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!isset($this->user) || !$this->user->id) redirect('');
	}

	public function index()
	{		
		$this->data['records'] = $this->db->query("SELECT * FROM customers WHERE user_id <> 'Udeadbeefdeadbeefdeadbeefdeadbeef' ORDER BY joined DESC LIMIT 100")->result();
		$this->load->view('customers/index', $this->data);
	}
}
