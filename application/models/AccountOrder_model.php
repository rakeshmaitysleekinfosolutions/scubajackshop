<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class AccountOrder_model extends BaseModel {

    protected $table = "orders";

    protected $primaryKey = 'id';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new AccountOrder_model($attr);
    }

    public function getTotalOrders() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `orders` o WHERE user_id = '" . (int)$this->user->getId() . "' AND o.order_status_id > '0'");
        return $query->row_array()['total'];
    }
    public function getOrders($start = 0, $limit = 20) {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 1;
        }

        $query = $this->db->query("SELECT o.uuid as order_id, o.firstname, o.lastname, os.name as status, o.created_at, o.total, o.currency_code, o.currency_value FROM `orders` o LEFT JOIN `orders_status` os ON (o.order_status_id = os.id) WHERE o.user_id = '" . (int)$this->user->getId() . "' AND o.order_status_id > '0' ORDER BY o.id DESC LIMIT " . (int)$start . "," . (int)$limit);

        return $query->result_array();
    }
    public function getTotalOrderProductsByOrderId($order_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM  `orders_products` WHERE order_id = '" . (int)$order_id . "'");

        return $query->row_array()['total'];
    }
}