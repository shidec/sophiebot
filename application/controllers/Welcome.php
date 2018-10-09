<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		if(isset($this->user) && $this->user->id) redirect('home');
		$this->load->view('welcome', $this->data);
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect();
	}

	public function login(){
		if(isset($this->user) && $this->user->id) redirect('home');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('userpasswd', 'Password', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('');
		}else{
			$username = $this->input->post('username');
			$userpasswd = md5($this->input->post('userpasswd'));

			$user = $this->db->query('SELECT * FROM users WHERE username = ? AND userpasswd = ?', array($username, $userpasswd))->row();
			if($user){
				$this->session->set_userdata('user', $user);
				redirect('home');
			}else{
				$this->session->set_flashdata('error', 'Login failed');
				redirect();
			}
		}
		
	}
}
