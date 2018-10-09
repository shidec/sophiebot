<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!isset($this->user) || !$this->user->id) redirect('');
	}

	public function password()
	{
		$this->load->view('settings/password', $this->data);
	}

	public function line()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('submit', 'Submission', 'required');

        if ($this->form_validation->run() != FALSE)
        {
                $this->option->set('line_id', $this->input->post('line_id'));
                $this->option->set('line_name', $this->input->post('line_name'));
                $this->option->set('channel_access_token', $this->input->post('channel_access_token'));
                $this->option->set('channel_secret', $this->input->post('channel_secret'));

                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['file_name']           = 'logo' . date('Ymdhis') . rand(10000, 99999);

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('line_logo'))
                {
                	$data = $this->upload->data();
                	$old = './uploads/' . $this->option->get('line_logo');
                	if(file_exists($old)) unlink($old);
                    $this->option->set('line_logo', $data['file_name']);
                }
        }

		$this->data['line_id'] = $this->option->get('line_id');
		$this->data['line_name'] = $this->option->get('line_name');
		$this->data['line_logo'] = $this->option->get('line_logo');
		$this->data['channel_access_token'] = $this->option->get('channel_access_token');
		$this->data['channel_secret'] = $this->option->get('channel_secret');

		$this->load->view('settings/line', $this->data);
	}

	public function users()
	{		
		$this->data['usertypes'] = $this->config->item('usertypes');
		$this->data['records'] = $this->db->query('SELECT * FROM users ORDER BY username')->result();
		$this->load->view('settings/users', $this->data);
	}

	public function messages()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('submit', 'Submission', 'required');

        if ($this->form_validation->run() != FALSE)
        {
                $this->option->set('birthday_message', $this->input->post('birthday_message'));
                $this->option->set('welcome_message', $this->input->post('welcome_message'));
        }
		$this->data['birthday_message'] = $this->option->get('birthday_message');
		$this->data['welcome_message'] = $this->option->get('welcome_message');
		$this->load->view('settings/messages', $this->data);
	}
}
