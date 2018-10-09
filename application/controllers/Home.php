<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct(){
		parent::__construct();
		if(!isset($this->user) || !$this->user->id) redirect('');
	}

	public function index()
	{
		$this->data['current_event'] = $this->option->get('current_event');
		if($this->data['current_event'] == 'flash_sales'){
			$this->data['current_event_id'] = $this->option->get('current_event_id');
			$this->data['event'] = $this->db->query('SELECT * FROM sales WHERE id = ?', array($this->data['current_event_id']))->row();
			$this->data['users'] = $this->db->query('SELECT a.id, a.picture_url, a.display_name, b.time
				 FROM customers a INNER JOIN sale_buyers b ON a.id = b.customer_id
				 WHERE b.sale_id = ? ORDER BY b.time DESC', array($this->data['current_event_id']))->result();
		}else if($this->data['current_event'] == 'auctions'){
			$this->data['current_event_id'] = $this->option->get('current_event_id');
			$this->data['event'] = $this->db->query('SELECT * FROM auctions WHERE id = ?', array($this->data['current_event_id']))->row();
			$this->data['users'] = $this->db->query('SELECT a.id, a.picture_url, a.display_name, MAX(b.time) AS time, MAX(b.price) AS price
				 FROM customers a INNER JOIN auction_bids b ON a.id = b.customer_id
				 WHERE b.auction_id = ? GROUP BY a.id, a.picture_url, a.display_name ORDER BY time DESC', array($this->data['current_event_id']))->result();
		}else if($this->data['current_event'] == 'polls'){
			$this->data['current_event_id'] = (int) $this->option->get('current_event_id');
			$this->data['event'] = $this->db->query('SELECT * FROM polls WHERE id = ?', array($this->data['current_event_id']))->row();
			$result = $this->db->query('SELECT answer, count(id) as total FROM poll_participants WHERE poll_id = ? GROUP BY answer ORDER BY answer', array($this->data['current_event_id']))->result();

			$this->data['answer'] = json_decode($this->data['event']->options);
			$this->data['result'] = array_pad(array(), count($this->data['answer']), 0);
			foreach ($result as $r) {
				$this->data['result'][$r->answer] = (int) $r->total;
			}
			$this->data['result'] = json_encode($this->data['result']);

			$this->data['users'] = $this->db->query('SELECT a.id, a.picture_url, a.display_name, b.time
				 FROM customers a INNER JOIN poll_participants b ON a.id = b.customer_id
				 WHERE b.poll_id = ? ORDER BY b.time DESC', array($this->data['current_event_id']))->result();
		}
		$this->load->view('home/index', $this->data);
	}
}
