<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class UserActivity_model extends BaseModel {

    public function __construct()
    {
        parent::__construct();
    }
    
    protected $table = "users_activity";

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

    //const DELETED_AT = 'deleted_at';


    public function factory($attr = array()) {
        return new UserActivity_model($attr);
    }

    public function addActivity($key, $data) {
		if (isset($data['id_customers'])) {
			$id_customers = $data['id_customers'];
		} else {
			$id_customers = 0;
		}

		$this->db->query("INSERT INTO `users_activity` SET `id_customers` = '" . (int)$id_customers . "', `key` = '" . $this->db->escape_str($key) . "', `data` = '" . $this->db->escape_str(json_encode($data)) . "', `ip` = '" . $this->db->escape_str($this->input->server('REMOTE_ADDR')) . "', `created_at` = NOW()");
	}

    
}