<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class User_model extends BaseModel {
    
    protected $table = "users";

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
        return new User_model($attr);
    }


    /**
     * @desc Get All User 
     * @return Array
     */
    public function getUsers() {
        $this->results = User_model::factory()->find()->get()->result_array();
        foreach ($this->results as $result) {
            $this->data[] = array(
                'id'                => $result['id'],
                'name'              => strip_tags(html_entity_decode($result['firstname'], ENT_QUOTES, 'UTF-8')). ' '. strip_tags(html_entity_decode($result['lastname'], ENT_QUOTES, 'UTF-8')),
                'firstname'         => $result['firstname'],
                'lastname'          => $result['lastname'],
                'email'             => $result['email'],
                'telephone'         => $result['telephone'],
                'address'           => Address_model::factory()->getAddressesByUserId($result['id'])
            );
        }

        if($this->data) {
            return $this->data;
        }
	}
    /**
	 * @method Add new user
	 * @param $data Array()
	 */
    public function addUser($data) {

		$salt = token(9);
		$this->db->query("INSERT INTO users SET firstname = '" . $this->db->escape_str($data['firstname']) . "', lastname = '" . $this->db->escape_str($data['lastname']) . "', email = '" . $this->db->escape_str($data['email']) . "', uuid = '" . $this->db->escape_str(time()) . "', salt = '" . $this->db->escape_str($salt) . "', password = '" . $this->db->escape_str(sha1($salt . sha1($salt . sha1($data['password'])))) . "', ip = '" . $this->db->escape_str($this->input->server('REMOTE_ADDR')) . "', status = 1");
		$user_id = $this->db->insert_id();
		$this->db->query("INSERT INTO users_address SET user_id = '" . (int)$user_id . "', firstname = '" . $this->db->escape_str($data['firstname']) . "', lastname = '" . $this->db->escape_str($data['lastname']) . "'");
		$address_id = $this->db->insert_id();
		$this->db->query("UPDATE users SET address_id = '" . (int)$address_id . "' WHERE id = '" . (int)$user_id . "'");
		return $user_id;
	}

	public function editUser($id, $data) {
		$this->db->query("UPDATE users SET firstname = '" . $this->db->escape_str($data['firstname']) . "', lastname = '" . $this->db->escape_str($data['lastname']) . "', email = '" . $this->db->escape_str($data['email']) . "', phone = '" . $this->db->escape_str($data['phone']) . "' , status = '" . $this->db->escape_str($data['status']) . "' WHERE id = '" . (int)$id . "'");
        if ($data['password']) {
            $salt = token(9);
            $this->db->query("UPDATE `users` SET salt = '" . $this->db->escape_str($salt) . "', password = '" . $this->db->escape_str(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE id = '" . (int)$id . "'");
        }
        $this->db->query("DELETE FROM users_address WHERE user_id = '" . (int)$id . "'");
        if (isset($data['address'])) {
            foreach ($data['address'] as $address) {
                //dd($address);
                $this->db->query("INSERT INTO users_address SET user_id = '" . (int)$id . "', firstname = '" . $this->db->escape_str($data['firstname']) . "', lastname = '" . $this->db->escape_str($data['lastname']) . "', address_1 = '" . $this->db->escape_str($address['address_1']) . "', address_2 = '" . $this->db->escape_str($address['address_2']) . "', city = '" . $this->db->escape_str($address['city']) . "', postcode = '" . $this->db->escape_str($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', state_id = '" . (int)$address['state_id'] . "'");
               // $address_id = $this->db->insert_id();
               // $this->db->query("UPDATE users SET address_id = '" . (int)$address_id . "' WHERE id = '" . (int)$id . "'");
            }
        }
	}
    public function updateStatus($userId, $status) {
//        echo $userId. $status;
//        exit;
        $this->db->query("UPDATE users SET status = '" . $this->db->escape_str($status) . "' WHERE id = '" . (int)$userId . "'");
    }
	public function editPassword($email, $password) {
		$this->db->query("UPDATE users SET salt = '" . $this->db->escape_str($salt = token(9)) . "', password = '" . $this->db->escape_str(sha1($salt . sha1($salt . sha1($password)))) . "', code = '' WHERE LOWER(email) = '" . $this->db->escape_str(strtolower($email)) . "'");
	}

	public function editCode($email, $code) {
		$this->db->query("UPDATE `users` SET code = '" . $this->db->escape_str($code) . "' WHERE LCASE(email) = '" . $this->db->escape_str(strtolower($email)) . "'");
	}

	public function editNewsletter($newsletter) {
		$this->db->query("UPDATE users SET newsletter = '" . (int)$newsletter . "' WHERE id = '" . (int)$this->User->getId() . "'");
	}

	public function getUser($user_id) {
		$query = $this->db->query("SELECT * FROM users WHERE id = '" . (int)$user_id . "'");

		return $query->row_array();
	}
	public function getUserById($id) {

    }

	public function getUserByEmail($email) {
		$query = $this->db->query("SELECT * FROM users WHERE LOWER(email) = '" . $this->db->escape_str(strtolower($email)) . "'");

		return $query->row_array();
	}

	public function getUserByCode($code) {
		$query = $this->db->query("SELECT id, firstname, lastname, email FROM `users` WHERE code = '" . $this->db->escape_str($code) . "' AND code != ''");

		return $query->row_array();
	}

	public function getUserByToken($token) {
		$query = $this->db->query("SELECT * FROM users WHERE token = '" . $this->db->escape_str($token) . "' AND token != ''");

		$this->db->query("UPDATE users SET token = ''");

		return $query->row_array();
	}

	public function getTotalusersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM users WHERE LOWER(email) = '" . $this->db->escape_str(strtolower($email)) . "'");

		return $query->row_array()['total'];
	}

	public function getRewardTotal($user_id) {
		$query = $this->db->query("SELECT SUM(points) AS total FROM User_reward WHERE user_id = '" . (int)$user_id . "'");

		return $query->row_array()['total'];
	}

	public function getIps($user_id) {
		$query = $this->db->query("SELECT * FROM `User_ip` WHERE user_id = '" . (int)$user_id . "'");

		return $query->result_array();
	}

	public function addLoginAttempt($email) {
		$query = $this->db->query("SELECT * FROM users_login WHERE email = '" . $this->db->escape_str(strtolower((string)$email)) . "' AND ip = '" . $this->db->escape_str($this->input->server('REMOTE_ADDR')) . "'");

		if (!$query->num_rows()) {
			$this->db->query("INSERT INTO users_login SET email = '" . $this->db->escape_str(strtolower((string)$email)) . "', ip = '" . $this->db->escape_str($this->input->server('REMOTE_ADDR')) . "', total = 1, created_at = '" . $this->db->escape_str(date('Y-m-d H:i:s')) . "', updated_at = '" . $this->db->escape_str(date('Y-m-d H:i:s')) . "'");
		} else {
			$this->db->query("UPDATE users_login SET total = (total + 1), updated_at = '" . $this->db->escape_str(date('Y-m-d H:i:s')) . "' WHERE User_login_id = '" . (int)$query->row['User_login_id'] . "'");
		}
	}

	public function getLoginAttempts($email) {
		$query = $this->db->query("SELECT * FROM `users_login` WHERE email = '" . $this->db->escape_str(strtolower($email)) . "'");

		return $query->row_array();
	}

	public function deleteLoginAttempts($email) {
		$this->db->query("DELETE FROM `users_login` WHERE email = '" . $this->db->escape_str(strtolower($email)) . "'");
	}

	public function user($id) {
        return User_model::factory()->findOne($id);
    }

	public function address() {
        return $this->hasMany('UserAddress_model', 'user_id', 'id')->get()->row_object();
    }

//    public function getAddress() {
//        return $this->address()->result_array();
//    }
//    public function toArray($relationNames =[]){
//        $data = parent::toArray();
//        foreach ($relationNames as $relationName){
//            try{
//                $data[$relationName] =  $this->$relationName;
//            }catch(\Exception $e){}
//        }
//        dd($data);
//        return $data;
//    }



    public function deleteUsers($user_id, $forceDelete = false) {
        if($forceDelete) {
            $this->db->query("DELETE FROM users WHERE id = '" . (int)$user_id . "'");
            //$this->db->query("DELETE FROM " . DB_PREFIX . "customer_activity WHERE customer_id = '" . (int)$customer_id . "'");
            //$this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "'");
            $this->db->query("DELETE FROM users_ip WHERE user_id = '" . (int)$user_id . "'");
            $this->db->query("DELETE FROM users_address WHERE user_id = '" . (int)$user_id . "'");
        }

        $this->db->query("UPDATE users SET is_deleted = 1 WHERE id = '" . (int)$user_id . "'");
        $this->db->query("UPDATE users_ip SET is_deleted = 1 WHERE user_id = '" . (int)$user_id . "'");
        $this->db->query("UPDATE users_address SET is_deleted = 1 WHERE user_id = '" . (int)$user_id . "'");
    }
    public function updateAccount($id, $data) {

        $this->db->query("UPDATE users SET firstname = '" . $this->db->escape_str($data['firstname']) . "', lastname = '" . $this->db->escape_str($data['lastname']) . "', email = '" . $this->db->escape_str($data['email']) . "',image = '" . $this->db->escape_str($data['image']) . "',guardian = '" . $this->db->escape_str($data['guardian']) . "',gender = '" . $this->db->escape_str($data['gender']) . "',phone = '" . $this->db->escape_str($data['phone']) . "' WHERE id = '" . (int)$id . "'");
        if (!empty($data['password'])) {
            $salt = token(9);
            $this->db->query("UPDATE `users` SET salt = '" . $this->db->escape_str($salt) . "', password = '" . $this->db->escape_str(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE id = '" . (int)$id . "'");
        }
    }
}