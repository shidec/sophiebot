<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Option {

	public function __construct($params = array())
	{
		$this->CI =& get_instance();
	}

	public function get($name){
		$row = $this->CI->db->query('SELECT option_value FROM options WHERE option_name = ?', array($name))->row();
		return $row ? $row->option_value : '';
	}

	public function set($name, $value){
		$row = $this->CI->db->query('SELECT id FROM options WHERE option_name = ?', array($name))->row();
		if($row){
			$this->CI->db->query('UPDATE options SET option_value = ? WHERE option_name = ?', array($value, $name));
		}else{
			$this->CI->db->query('INSERT INTO options (option_name, option_value) VALUES (?, ?)', array($name, $value));
		}
	}
}
