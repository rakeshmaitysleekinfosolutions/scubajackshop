<?php
class Coupon {
	private $ci;
	public function __construct()
	{
		$this->ci = &get_instance();
	}
	public function getCoupon($code) {
		$status = true;

		$coupon_query = $this->ci->db->query("SELECT * FROM `coupon` WHERE code = '" . $this->ci->db->escape_str($code) . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) AND status = '1'");
		$row = $coupon_query->row_array();
		if ($coupon_query->num_rows()) {
			if ($row['total'] > $this->ci->ecart->getSubTotal()) {
				$status = false;
			}

			$coupon_history_query = $this->ci->db->query("SELECT COUNT(*) AS total FROM `coupon_history` ch WHERE ch.coupon_id = '" . (int)$row['coupon_id'] . "'");

			if ($row['uses_total'] > 0 && ($coupon_history_query->row_array()['total'] >= $row['uses_total'])) {
				$status = false;
			}

			if ($row['logged'] && !$this->user->getId()) {
				$status = false;
			}

			if ($this->user->getId()) {
				$coupon_history_query = $this->ci->db->query("SELECT COUNT(*) AS total FROM `coupon_history` ch WHERE ch.coupon_id = '" . (int)$row['coupon_id'] . "' AND ch.user_id = '" . (int)$this->ci->customer->getId() . "'");
				if ($row['uses_customer'] > 0 && ($coupon_history_query->row_array()['total'] >= $row['uses_customer'])) {
					$status = false;
				}
			}

			// Products
			$coupon_events_data = array();
			$coupon_events_query = $this->ci->db->query("SELECT * FROM `coupon_events` WHERE coupon_id = '" . (int)$row['coupon_id'] . "'");
			foreach ($coupon_events_query->result_array() as $product) {
				$coupon_events_data[] = $product['id_events'];
			}

		
			// Categories
			// $coupon_category_data = array();

			// $coupon_category_query = $this->ci->db->query("SELECT * FROM `coupon_category` cc LEFT JOIN `category_path` cp ON (cc.category_id = cp.path_id) WHERE cc.coupon_id = '" . (int)$row['coupon_id'] . "'");

			// foreach ($coupon_category_query->result_array() as $category) {
			// 	$coupon_category_data[] = $category['category_id'];
			// }

			$product_data = array();

			if ($coupon_events_data) {
				
				foreach ($this->ci->ecart->getProducts() as $product) {
					if (in_array($product['id_events'], $coupon_events_data)) {
						$product_data[] = $product['id_events'];
						
						continue;
					}
					/*
					foreach ($coupon_category_data as $category_id) {
						$coupon_category_query = $this->db->query("SELECT COUNT(*) AS total FROM `product_to_category` WHERE `product_id` = '" . (int)$product['product_id'] . "' AND category_id = '" . (int)$category_id . "'");

						if ($coupon_category_query->row['total']) {
							$product_data[] = $product['product_id'];

							continue;
						}
					}
					*/
				}

				if (!$product_data) {
					$status = false;
				}
			}
		} else {
			$status = false;
		}

		if ($status) {
			return array(
				'coupon_id'     => $row['coupon_id'],
				'code'          => $row['code'],
				'name'          => $row['name'],
				'type'          => $row['type'],
				'discount'      => $row['discount'],
				'shipping'      => $row['shipping'],
				'total'         => $row['total'],
				'product'       => $product_data,
				'date_start'    => $row['date_start'],
				'date_end'      => $row['date_end'],
				'uses_total'    => $row['uses_total'],
				'uses_customer' => $row['uses_customer'],
				'status'        => $row['status'],
				'date_added'    => $row['date_added']
			);
		}
	}

	public function getTotal($total) {
		if ($this->ci->session->userdata('coupon')) {

			$coupon_info = $this->getCoupon($this->ci->session->userdata('coupon'));
			
			if ($coupon_info) {
				$discount_total = 0;

				if (!$coupon_info['product']) {
					$sub_total = $this->ci->ecart->getSubTotal();
				} else {
					$sub_total = 0;
					// echo "<pre>";
					// print_r($this->ci->ecart->getProducts());
					// exit;
					foreach ($this->ci->ecart->getProducts() as $product) {
						if (in_array($product['id_events'], $coupon_info['product'])) {
							$sub_total += $product['total'];
						}
					}
				}

				if ($coupon_info['type'] == 'F') {
					$coupon_info['discount'] = min($coupon_info['discount'], $sub_total);
				}

				foreach ($this->ci->ecart->getProducts() as $product) {
					$discount = 0;

					if (!$coupon_info['product']) {
						$status = true;
					} else {
						$status = in_array($product['id_events'], $coupon_info['product']);
					}

					if ($status) {
						if ($coupon_info['type'] == 'F') {
							$discount = $coupon_info['discount'] * ($product['total'] / $sub_total);
						} elseif ($coupon_info['type'] == 'P') {
							$discount = $product['total'] / 100 * $coupon_info['discount'];
						}

						if ($product['tax_class_id']) {
							$tax_rates = $this->ci->tax->getRates($product['total'] - ($product['total'] - $discount), $product['tax_class_id']);

							foreach ($tax_rates as $tax_rate) {
								if ($tax_rate['type'] == 'P') {
									$total['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
								}
							}
						}
					}

					$discount_total += $discount;
				}
				/*
				if ($coupon_info['shipping'] && isset($this->session->data['shipping_method'])) {
					if (!empty($this->session->data['shipping_method']['tax_class_id'])) {
						$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);

						foreach ($tax_rates as $tax_rate) {
							if ($tax_rate['type'] == 'P') {
								$total['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
							}
						}
					}

					$discount_total += $this->session->data['shipping_method']['cost'];
				}
				*/
				// If discount greater than total
				if ($discount_total > $total) {
					$discount_total = $total;
				}

				if ($discount_total > 0) {
					$total['totals'][] = array(
						'code'       => 'coupon',
						'title'      => sprintf('Coupon (%s)', $this->ci->session->userdata('coupon')),
						'value'      => -$discount_total,
						'sort_order' => __('settings', 'coupon_sort_order', true, true)
					);

					$total['total'] -= $discount_total;
				}
				// echo "<pre>";
				// print_r($total['totals']);
				// exit;
			}
		}
	}

	public function confirm($order_info, $order_total) {
		$code = '';

		$start = strpos($order_total['title'], '(') + 1;
		$end = strrpos($order_total['title'], ')');

		if ($start && $end) {
			$code = substr($order_total['title'], $start, $end - $start);
		}

		if ($code) {
			$coupon_info = $this->getCoupon($code);

			if ($coupon_info) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "coupon_history` SET coupon_id = '" . (int)$coupon_info['coupon_id'] . "', order_id = '" . (int)$order_info['order_id'] . "', customer_id = '" . (int)$order_info['customer_id'] . "', amount = '" . (float)$order_total['value'] . "', date_added = NOW()");
			} else {
				return $this->config->get('config_fraud_status_id');
			}
		}
	}

	public function unconfirm($order_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "coupon_history` WHERE order_id = '" . (int)$order_id . "'");
	}
	public static   function factory($attr = array()) {
		return new Coupon($attr);
	}
}
