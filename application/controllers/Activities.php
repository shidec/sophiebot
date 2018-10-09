<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activities extends MY_Controller {

        public function __construct(){
		parent::__construct();
		if(!isset($this->user) || !$this->user->id) redirect('');
	}

	public function index()
	{
		$this->load->view('activities/index', $this->data);
	}

    public function quizzes(){

        $this->load->library('form_validation');
        $this->form_validation->set_rules('caption', 'Caption', 'required');

        if ($this->form_validation->run() != FALSE)
        {
            $options = array();
            $actions = array();
            $i = 0;
            foreach ($this->input->post('options') as $o) {
                if($o){ 
                    $options[] = $o;
                    $actions[] = array(
                                        "type" => "message",
                                        "label" => $o,
                                        "text" => "/answer " . chr(97 + $i++)
                                      );
                }
            }

            if(count($options) < 2){
                $this->data['error'] = 'at least 2 options required';
            }else{
                $config['upload_path']          = './uploads/quizzes/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['file_name']           = date('Ymdhis') . rand(10000, 99999);

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image'))
                {
                    $data = $this->upload->data();
                    $record['image'] = $data['file_name'];
                }

                $record['caption'] = $this->input->post('caption');
                $record['answer'] = $this->input->post('answer');
                $record['score'] = $this->input->post('score');
                $record['options'] = json_encode($options);
                $record['start_time'] = date('Y-m-d H:i:s');
                $record['end_time'] = date('Y-m-d H:i:s');
                $record['status'] = 1;

                $this->db->query('UPDATE auctions SET status = 2');
                $this->db->query('UPDATE polls SET status = 2');
                $this->db->query('UPDATE quizzes SET status = 2');
                $this->db->query('UPDATE sales SET status = 2');

                if($this->db->insert('quizzes', $record)){
                    $event_id = $this->db->insert_id();
                    $this->option->set('current_event', 'quizzes');
                    $this->option->set('current_event_id', $event_id);

                    $users = $this->db->query('SELECT user_id FROM customers')->result();
                    $us = array();
                    foreach ($users as $u) {
                            $us[] = $u->user_id;
                    }

                    $text = $this->input->post('caption');
                    $messages = array();
                    if(isset($record['image'])){
                        $image = base_url() . 'uploads/quizzes/' . $record['image'];
                        $messages[] = array(
                                          "type" => "template",
                                          "altText" => "Quiz",
                                          "template" => array(
                                              "type" => "buttons",
                                              "thumbnailImageUrl" => $image,
                                              "text" => $text,
                                              "actions" => $actions
                                          )
                                        );
                    }else{
                        $messages[] = array(
                                          "type" => "template",
                                          "altText" => "Quiz",
                                          "template" => array(
                                              "type" => "buttons",
                                              "text" => $text,
                                              "actions" => $actions
                                          )
                                        );
                    }

                    $message = array('to' => $us, 'messages' => $messages);

                    $this->load->library('LineBot');
                    $this->linebot->multicast($message);
                }
            }
        }

        $this->data['records'] = $this->db->query('SELECT * FROM quizzes ORDER BY start_time DESC, end_time DESC')->result();
        $answers = $this->db->query('SELECT quiz_id, answer, count(id) as total FROM quiz_participants GROUP BY quiz_id, answer')->result();
        $this->data['answers'] = array();
        foreach ($answers as $o) {
            if(!array_key_exists($o->quiz_id, $this->data['answers'])){
                $this->data['answers'][$o->quiz_id] = array(0, 0, 0, 0);
            }

            $this->data['answers'][$o->quiz_id][$o->answer] = (int) $o->total;
        }

        $this->load->view('activities/quizzes', $this->data);
    }

    public function polls(){

        $this->load->library('form_validation');
        $this->form_validation->set_rules('caption', 'Caption', 'required');

        if ($this->form_validation->run() != FALSE)
        {
            $options = array();
            $actions = array();
            $i = 0;
            foreach ($this->input->post('options') as $o) {
                if($o){ 
                    $options[] = $o;
                    $actions[] = array(
                                        "type" => "message",
                                        "label" => $o,
                                        "text" => "/vote " . $i++
                                      );
                }
            }

            if(count($options) < 2){
                $this->data['error'] = 'at least 2 options required';
            }else{
                $config['upload_path']          = './uploads/polls/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['file_name']           = date('Ymdhis') . rand(10000, 99999);

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image'))
                {
                    $data = $this->upload->data();
                    $record['image'] = $data['file_name'];
                }

                $record['caption'] = $this->input->post('caption');
                $record['options'] = json_encode($options);
                $record['start_time'] = date('Y-m-d H:i:s');
                $record['end_time'] = date('Y-m-d H:i:s');
                $record['status'] = 1;

                $this->db->query('UPDATE auctions SET status = 2');
                $this->db->query('UPDATE polls SET status = 2');
                $this->db->query('UPDATE quizzes SET status = 2');
                $this->db->query('UPDATE sales SET status = 2');

                if($this->db->insert('polls', $record)){
                    $event_id = $this->db->insert_id();
                    $this->option->set('current_event', 'polls');
                    $this->option->set('current_event_id', $event_id);

                    $users = $this->db->query('SELECT user_id FROM customers')->result();
                    $us = array();
                    foreach ($users as $u) {
                            $us[] = $u->user_id;
                    }

                    $text = $this->input->post('caption');
                    $messages = array();
                    if(isset($record['image'])){
                        $image = base_url() . 'uploads/polls/' . $record['image'];
                        $messages[] = array(
                                          "type" => "template",
                                          "altText" => "Poll",
                                          "template" => array(
                                              "type" => "buttons",
                                              "thumbnailImageUrl" => $image,
                                              "text" => $text,
                                              "actions" => $actions
                                          )
                                        );
                    }else{
                        $messages[] = array(
                                          "type" => "template",
                                          "altText" => "Poll",
                                          "template" => array(
                                              "type" => "buttons",
                                              "text" => $text,
                                              "actions" => $actions
                                          )
                                        );
                    }

                    $message = array('to' => $us, 'messages' => $messages);

                    $this->load->library('LineBot');
                    $this->linebot->multicast($message);
                }
            }
        }

        $this->data['records'] = $this->db->query('SELECT * FROM polls ORDER BY start_time DESC, end_time DESC')->result();
        $answers = $this->db->query('SELECT poll_id, answer, count(id) as total FROM poll_participants GROUP BY poll_id, answer')->result();
        $this->data['answers'] = array();
        foreach ($answers as $o) {
            if(!array_key_exists($o->poll_id, $this->data['answers'])){
                $this->data['answers'][$o->poll_id] = array(0, 0, 0, 0);
            }

            $this->data['answers'][$o->poll_id][$o->answer] = (int) $o->total;
        }

        $this->load->view('activities/polls', $this->data);
    }

    public function auctions(){

            $this->load->library('form_validation');
            $this->form_validation->set_rules('submit', 'Submission', 'required');

            if ($this->form_validation->run() != FALSE)
            {
                    $record['caption'] = $this->input->post('caption');
                    $record['start_time'] = date('Y-m-d H:i:s');
                    $record['status'] = 1;
                    $record['start_price'] = $this->input->post('start_price');
                    $record['last_price'] = $this->input->post('start_price');

                    $this->db->query('UPDATE auctions SET status = 2');
                    $this->db->query('UPDATE polls SET status = 2');
                    $this->db->query('UPDATE quizzes SET status = 2');
                    $this->db->query('UPDATE sales SET status = 2');

                    if($this->db->insert('auctions', $record)){

                            $event_id = $this->db->insert_id();
                            $this->option->set('current_event', 'auctions');
                            $this->option->set('current_event_id', $event_id);

                            $users = $this->db->query('SELECT user_id FROM customers')->result();
                            $us = array();
                            foreach ($users as $u) {
                                    $us[] = $u->user_id;
                            }

                            $caption = $this->input->post('caption');
                            $messages = array();
                            $messages[] = array("type" => "text",
                                                "text" => "{$caption}\nHarga awal : " . number_format($record['start_price'], 0, ',', '.')
                                            );

                            $messages[] = array("type" => "text",
                                                "text" => "Ikuti lelang dengan menulis /bid penawaran.\nmisal: /bid 5000"
                                            );

                            $message = array('to' => $us, 'messages' => $messages);

                            $this->load->library('LineBot');
                            $this->linebot->multicast($message);
                    }
            }
            $this->data['records'] = $this->db->query('SELECT a.*, b.display_name FROM auctions a
                    LEFT JOIN customers b ON a.last_customer = b.id 
                    ORDER BY start_time DESC')->result();
            $this->data['posttypes'] = $this->config->item('posttypes');

            $this->load->view('activities/auctions', $this->data);
    }
        
	public function flash_sales(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('submit', 'Submission', 'required');

                if ($this->form_validation->run() != FALSE)
                {
                	$record['text'] = $this->input->post('text');
                	$record['start_time'] = date('Y-m-d H:i:s');
                	$record['end_time'] = date('Y-m-d H:i:s');
                	$record['status'] = 1;
                	$record['price'] = $this->input->post('price');
                	$record['stock'] = $this->input->post('stock');
                	$record['current_stock'] = $this->input->post('stock');

                	$this->db->query('UPDATE auctions SET status = 2');
                    $this->db->query('UPDATE polls SET status = 2');
                    $this->db->query('UPDATE quizzes SET status = 2');
                    $this->db->query('UPDATE sales SET status = 2');
                    
                	if($this->db->insert('sales', $record)){

                		$event_id = $this->db->insert_id();
                		$this->option->set('current_event', 'flash_sales');
                		$this->option->set('current_event_id', $event_id);

                		$users = $this->db->query('SELECT user_id FROM customers')->result();
                		$us = array();
                		foreach ($users as $u) {
                			$us[] = $u->user_id;
                		}

                		$text = $this->input->post('text') . "\n\nStock : " . $this->input->post('stock');
                		$messages = array();
                		$messages[] = array(
						  "type" => "template",
						  "altText" => "Flash sale",
						  "template" => array(
						      "type" => "buttons",
						      "text" => $text,
						      "actions" => array(
						          array(
						            "type" => "message",
						            "label" => "Beli",
						            "text" => "/buy $event_id"
						          )
						      )
						  )
						);

                		$message = array('to' => $us, 'messages' => $messages);

                		$this->load->library('LineBot');
                		$this->linebot->multicast($message);
                	}
                }
		$this->data['records'] = $this->db->query('SELECT * FROM sales ORDER BY start_time DESC, end_time DESC')->result();
		$this->data['posttypes'] = $this->config->item('posttypes');

		$this->load->view('activities/flash_sales', $this->data);
	}

	public function posts(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('submit', 'Submission', 'required');

                if ($this->form_validation->run() != FALSE)
                {
                	$record['type'] = $this->input->post('type');
                	$record['content'] = $this->input->post('content');
                	$record['post_time'] = date('Y-m-d H:i:s');
                	$record['time'] = date('Y-m-d H:i:s');

                	if($this->db->insert('posts', $record)){
                		$users = $this->db->query('SELECT user_id FROM customers')->result();
                		$us = array();
                		foreach ($users as $u) {
                			$us[] = $u->user_id;
                		}

                		$messages = array();
        				$messages[] = array(
        								'type' => 'text',
        								'text' => $this->input->post('content')
        							);

                		$message = array('to' => $us, 'messages' => $messages);

                		$this->load->library('LineBot');
                		$this->linebot->multicast($message);
                	}
                }
		$this->data['records'] = $this->db->query('SELECT * FROM posts ORDER BY time DESC')->result();
		$this->data['posttypes'] = $this->config->item('posttypes');

		$this->load->view('activities/posts', $this->data);
	}
}
