<?php

class Extension {
	
	private $ci;
	public function __construct()
	{
		$this->ci = &get_instance();
	}

	function getExtensions($type) {
		$query = $this->ci->db->query("SELECT * FROM `extension` WHERE `type` = '" . $this->ci->db->escape_str($type) . "'");
		return $query->result_array();
    }
    
    public function getAllExtensions() {
        $query = $this->ci->db->query("SELECT * FROM `extension` WHERE `is_deleted` = '0'");
		return $query->result_array();
    }
}
