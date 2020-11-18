<?php
class Tax{
	
	private $ci;
	public $tax_rates = array();
	public function __construct()
	{
		
		$this->ci 	= &get_instance();
		$this->ci->load->helper('url_helper');
		$country_id = getConfigCountryId();
		$zone_id 	= getConfigZoneId();
		
		$tax_query 	= $this->ci->db->query("SELECT tr1.tax_class_id, tr2.tax_rate_id, tr2.name, tr2.rate, tr2.type, tr1.priority FROM tax_rule tr1 LEFT JOIN tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) LEFT JOIN zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_id) LEFT JOIN geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.based = 'payment' AND  z2gz.id_country = '" . (int)$country_id . "' AND (z2gz.id_zone = '0' OR z2gz.id_zone = '" . (int)$zone_id . "') ORDER BY tr1.priority ASC");

		foreach ($tax_query->result_array() as $result) {
			$this->tax_rates[$result['tax_class_id']][$result['tax_rate_id']] = array(
				'tax_rate_id' => $result['tax_rate_id'],
				'name'        => $result['name'],
				'rate'        => $result['rate'],
				'type'        => $result['type'],
				'priority'    => $result['priority']
			);
		}
	}

	public function factory($attr = array()) {
		return new Tax($attr);
	}
	public function unsetRates() {
		$this->tax_rates = array();
	}

	public function getTotal($total) {
		foreach ($total['taxes'] as $key => $value) {
			if ($value > 0) {
				$total['totals'][] = array(
					'code'       => 'tax',
					'title'      => $this->getRateName($key),
					'value'      => $value,
					'sort_order' => $this->ci->config->item('tax_sort_order')['key']
				);

				$total['total'] += $value;
			}
		}
	}
	public function getTaxes() {
		$tax_data = array();

		foreach ($this->ci->ecart->getProducts() as $product) {
			if ($product['tax_class_id']) {
				$tax_rates = $this->getRates($product['price'], $product['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
						$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['quantity']);
					} else {
						$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product['quantity']);
					}
				}
			}
		}

		return $tax_data;
	}
	public function setStoreAddress($country_id, $zone_id) {
		$tax_query = $this->db->query("SELECT tr1.tax_class_id, tr2.tax_rate_id, tr2.name, tr2.rate, tr2.type, tr1.priority FROM " . DB_PREFIX . "tax_rule tr1 LEFT JOIN " . DB_PREFIX . "tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN " . DB_PREFIX . "tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN " . DB_PREFIX . "zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN " . DB_PREFIX . "geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.based = 'store' AND tr2cg.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND z2gz.country_id = '" . (int)$country_id . "' AND (z2gz.zone_id = '0' OR z2gz.zone_id = '" . (int)$zone_id . "') ORDER BY tr1.priority ASC");

		foreach ($tax_query->result_array() as $result) {
			$this->tax_rates[$result['tax_class_id']][$result['tax_rate_id']] = array(
				'tax_rate_id' => $result['tax_rate_id'],
				'name'        => $result['name'],
				'rate'        => $result['rate'],
				'type'        => $result['type'],
				'priority'    => $result['priority']
			);
		}
	}
	public function setPaymentAddress($country_id, $zone_id) {
		$tax_query = $this->db->query("SELECT tr1.tax_class_id, tr2.tax_rate_id, tr2.name, tr2.rate, tr2.type, tr1.priority FROM tax_rule tr1 LEFT JOIN tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.based = 'payment' AND tr2cg.customer_group_id = '" . (int)__('settings','config_customer_group_id', true, false) . "' AND z2gz.country_id = '" . (int)$country_id . "' AND (z2gz.zone_id = '0' OR z2gz.zone_id = '" . (int)$zone_id . "') ORDER BY tr1.priority ASC");

		foreach ($tax_query->ressult_array() as $result) {
			$this->tax_rates[$result['tax_class_id']][$result['tax_rate_id']] = array(
				'tax_rate_id' => $result['tax_rate_id'],
				'name'        => $result['name'],
				'rate'        => $result['rate'],
				'type'        => $result['type'],
				'priority'    => $result['priority']
			);
		}
	}

	public function calculate($value, $tax_class_id, $calculate = true) {
		if ($tax_class_id && $calculate) {
			$amount = 0;

			$tax_rates = $this->getRates($value, $tax_class_id);

			foreach ($tax_rates as $tax_rate) {
				if ($calculate != 'P' && $calculate != 'F') {
					$amount += $tax_rate['amount'];
				} elseif ($tax_rate['type'] == $calculate) {
					$amount += $tax_rate['amount'];
				}
			}

			return $value + $amount;
		} else {
			return $value;
		}
	}

	public function getTax($value, $tax_class_id) {
		$amount = 0;

		$tax_rates = $this->getRates($value, $tax_class_id);

		foreach ($tax_rates as $tax_rate) {
			$amount += $tax_rate['amount'];
		}

		return $amount;
	}

	public function getRateName($tax_rate_id) {
		$tax_query = $this->ci->db->query("SELECT name FROM tax_rate WHERE tax_rate_id = '" . (int)$tax_rate_id . "'");

		if ($tax_query->num_rows()) {
			return $tax_query->row_array()['name'];
		} else {
			return false;
		}
	}

	public function getRates($value, $tax_class_id) {
		
		$tax_rate_data = array();

		if (isset($this->tax_rates[$tax_class_id])) {
			foreach ($this->tax_rates[$tax_class_id] as $tax_rate) {
				if (isset($tax_rate_data[$tax_rate['tax_rate_id']])) {
					$amount = $tax_rate_data[$tax_rate['tax_rate_id']]['amount'];
				} else {
					$amount = 0;
				}

				if ($tax_rate['type'] == 'F') {
					$amount += $tax_rate['rate'];
				} elseif ($tax_rate['type'] == 'P') {
					$amount += ($value / 100 * $tax_rate['rate']);
				}

				$tax_rate_data[$tax_rate['tax_rate_id']] = array(
					'tax_rate_id' => $tax_rate['tax_rate_id'],
					'name'        => $tax_rate['name'],
					'rate'        => $tax_rate['rate'],
					'type'        => $tax_rate['type'],
					'amount'      => $amount
				);
			}
		} 

		return $tax_rate_data;
	}
}
