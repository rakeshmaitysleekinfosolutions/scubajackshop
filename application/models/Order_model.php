<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Order_model extends BaseModel {
    
    protected $table = "orders";

    protected $primaryKey = 'id';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Order_model($attr);
    }
    public function getOrder($order_id) {
        $order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM users c WHERE c.id = o.user_id) AS customer,(SELECT c.gender FROM users c WHERE c.id = o.user_id) AS gender, (SELECT os.name FROM orders_status os WHERE os.id = o.order_status_id) AS order_status FROM `orders` o WHERE o.id = '" . $order_id . "'");
        if ($order_query->num_rows()) {
            $country_query = $this->db->query("SELECT * FROM `country` WHERE id = '" . (int)$order_query->row_array()['payment_country_id'] . "'");

            if ($country_query->num_rows()) {
                $payment_iso_code_2 = $country_query->row_array()['iso_code_2'];
                $payment_iso_code_3 = $country_query->row_array()['iso_code_3'];
            } else {
                $payment_iso_code_2 = '';
                $payment_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `states` WHERE id = '" . (int)$order_query->row_array()['payment_zone_id'] . "'");

            if ($zone_query->num_rows()) {
                $payment_zone_code = $zone_query->row_array()['code'];
            } else {
                $payment_zone_code = '';
            }

            $country_query = $this->db->query("SELECT * FROM `country` WHERE id = '" . (int)$order_query->row_array()['shipping_country_id'] . "'");

            if ($country_query->num_rows) {
                $shipping_iso_code_2 = $country_query->row_array()['iso_code_2'];
                $shipping_iso_code_3 = $country_query->row_array()['iso_code_3'];
            } else {
                $shipping_iso_code_2 = '';
                $shipping_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `states` WHERE id = '" . (int)$order_query->row_array()['shipping_zone_id'] . "'");

            if ($zone_query->num_rows) {
                $shipping_zone_code = $zone_query->row_array()['code'];
            } else {
                $shipping_zone_code = '';
            }
            return array(
                'order_id'                => $order_query->row_array()['id'],
                'uuid'                => $order_query->row_array()['uuid'],
                'invoice_no'              => $order_query->row_array()['invoice_no'],
                'invoice_prefix'          => $order_query->row_array()['invoice_prefix'],
                'user_id'                 => $order_query->row_array()['user_id'],
                'customer'                => $order_query->row_array()['customer'],
                'firstname'               => $order_query->row_array()['firstname'],
                'lastname'                => $order_query->row_array()['lastname'],
                'email'                   => $order_query->row_array()['email'],
                'gender'                   => $order_query->row_array()['gender'],
                'phone'               => $order_query->row_array()['phone'],
                'payment_firstname'       => $order_query->row_array()['payment_firstname'],
                'payment_lastname'        => $order_query->row_array()['payment_lastname'],
                'payment_address_1'       => $order_query->row_array()['payment_address_1'],
                'payment_address_2'       => $order_query->row_array()['payment_address_2'],
                'payment_postcode'        => $order_query->row_array()['payment_postcode'],
               // 'payment_address_format'  => $order_query->row_array()['payment_address_format'],
                'payment_city'            => $order_query->row_array()['payment_city'],
                'payment_zone_id'         => $order_query->row_array()['payment_zone_id'],
                'payment_zone'            => $order_query->row_array()['payment_zone'],
                'payment_zone_code'       => $payment_zone_code,
                'payment_country_id'      => $order_query->row_array()['payment_country_id'],
                'payment_country'         => $order_query->row_array()['payment_country'],
                'payment_iso_code_2'      => $payment_iso_code_2,
                'payment_iso_code_3'      => $payment_iso_code_3,
                'payment_method'          => $order_query->row_array()['payment_method'],
                'payment_code'            => $order_query->row_array()['payment_code'],
                'shipping_firstname'      => $order_query->row_array()['shipping_firstname'],
                'shipping_lastname'       => $order_query->row_array()['shipping_lastname'],
                'shipping_address_1'      => $order_query->row_array()['shipping_address_1'],
                'shipping_address_2'      => $order_query->row_array()['shipping_address_2'],
                'shipping_postcode'       => $order_query->row_array()['shipping_postcode'],
                'shipping_city'           => $order_query->row_array()['shipping_city'],
               // 'shipping_address_format' => $order_query->row_array()['shipping_address_format'],
                'shipping_zone_id'        => $order_query->row_array()['shipping_zone_id'],
                'shipping_zone'           => $order_query->row_array()['shipping_zone'],
                'shipping_zone_code'      => $shipping_zone_code,
                'shipping_country_id'     => $order_query->row_array()['shipping_country_id'],
                'shipping_country'        => $order_query->row_array()['shipping_country'],
                'shipping_iso_code_2'     => $shipping_iso_code_2,
                'shipping_iso_code_3'     => $shipping_iso_code_3,
                'shipping_method'         => $order_query->row_array()['shipping_method'],
                'shipping_code'           => $order_query->row_array()['shipping_code'],
                'total'                   => $order_query->row_array()['total'],
                'order_status_id'         => $order_query->row_array()['order_status_id'],
                'order_status'            => $order_query->row_array()['order_status'],
                'currency_id'             => $order_query->row_array()['currency_id'],
                'currency_code'           => $order_query->row_array()['currency_code'],
                'currency_value'          => $order_query->row_array()['currency_value'],
                'ip'                      => $order_query->row_array()['ip'],
                'forwarded_ip'            => $order_query->row_array()['forwarded_ip'],
                'user_agent'              => $order_query->row_array()['user_agent'],
                'created_at'              => $order_query->row_array()['created_at'],
                'updated_at'              => $order_query->row_array()['updated_at']
            );
        } else {
            return 1;
        }
    }
    public function getOrders($data = array()) {
        $sql = "SELECT o.id as order_id,o.uuid, CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM orders_status os WHERE os.id = o.order_status_id) AS order_status, o.shipping_code, o.total, o.currency_code, o.currency_value, o.created_at, o.updated_at, o.order_status_id FROM `orders` o WHERE is_deleted != 1 ORDER BY o.id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getOrderProducts($order_id) {
        $query = $this->db->query("SELECT * FROM orders_products WHERE order_id = '" . $order_id . "'");

        return $query->result_array();
    }
    public function getOrderTotals($order_id) {
        $query = $this->db->query("SELECT * FROM orders_total WHERE order_id = '" . $order_id . "' ORDER BY sort_order");

        return $query->result_array();
    }

}