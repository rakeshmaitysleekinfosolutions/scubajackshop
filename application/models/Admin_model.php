<?php
class Admin_model extends BaseModel {

    protected $table = "bd_admins";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Admin_model($attr);
    }
	
	public function check_login($email="",$password=""){

		$this->db->select('*');
		$this->db->where('admin_email', $email);
		$this->db->where('admin_password', $password);
		return $this->db->get('bd_admins');

	}

	public function last_login($user_id=""){

		$this->db->where('admin_id',$user_id);
		$this->db->update('bd_admins',array('admin_last_login'=>date('Y-m-d H:i:s')));
		if($this->db->affected_rows() > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}