<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chats extends MY_Controller {

        public function __construct(){
		parent::__construct();
		if(!isset($this->user) || !$this->user->id) redirect('');
	}

	public function index()
	{
		$this->load->view('chats/index', $this->data);
	}
}
