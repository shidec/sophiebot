<?php

class MY_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		$this->user = $this->session->userdata('user');
		if(!isset($this->user->id)){
			$user = new stdClass();
			$user->id = null;
			$user->usertype = null;
			$this->user = $user;
		}

		$this->data['error'] = $this->session->flashdata('error');
		$this->data['success'] = $this->session->flashdata('success');
		$title = $this->option->get('line_name');
		$this->data['title'] = $title ? $title . ' Control Panel': 'Customer Engangement LINE Bot';	
    }
}