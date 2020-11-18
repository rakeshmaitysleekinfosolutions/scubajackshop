<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Currency_model extends BaseModel {
    
    protected $table = "currency";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Mainstream creating field name
    const CREATED_AT = 'created_at';

    // Mainstream updating field name
    const UPDATED_AT = 'updated_at';

    // Use unixtime for saving datetime
    protected $dateFormat = 'datetime';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    // 0: actived, 1: deleted
    protected $recordDeletedFalseValue = '1';

    protected $recordDeletedTrueValue = '0';

    public static function factory($attr = array()) {
        return new Currency_model($attr);
    }
    public function  refresh($force = false, $code) {
		$data = array();

		if ($force) {

			$query = $this->db->query("SELECT * FROM currency WHERE code != '" . $code . "'");

		} else {
			$query = $this->db->query("SELECT * FROM currency WHERE code != '" . $code . "' AND updated_at < '" .  $this->db->escape_str(date('Y-m-d H:i:s', strtotime('-1 day'))) . "'");
		}

		foreach ($query->result_array() as $result) {
			$data[] = $code . $result['code'] . '=X';
		}

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, 'http://download.finance.yahoo.com/d/quotes.csv?s=' . implode(',', $data) . '&f=sl1&e=.csv');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);

		$content = curl_exec($curl);

		curl_close($curl);

		$lines = explode("\n", trim($content));

		foreach ($lines as $line) {
			$currency = substr($line, 4, 3);
			$value = substr($line, 11, 6);

			if ((float)$value) {
				$this->db->query("UPDATE currency SET value = '" . (float)$value . "', updated_at = '" .  $this->db->escape_str(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape_str($currency) . "'");
			}
		}

		$this->db->query("UPDATE currency SET value = '1.00000', updated_at = '" .  $this->db->escape_str(date('Y-m-d H:i:s')) . "' WHERE code = '" . $code . "'");

		//$this->cache->delete('currency');
	}
    
}