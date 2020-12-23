<?php

class Currency {
	public $currencies = array();
    public $ci;
	public function __construct() {
        $this->ci = &get_instance();
		foreach ($this->all() as $result) {
			$this->currencies[$result['code']] = array(
				'id'   => $result['id'],
				'name'         => $result['name'],
				'code'         => $result['code'],
				'symbol_left'   => $result['symbol_left'],
				'symbol_right'  => $result['symbol_right'],
				'decimal_place' => $result['decimal_place'],
				'value'         => $result['value']
			);
		}
		//dd($this->currencies);
	}
	public function all() {
	    $query =  $this->ci->db->query("SELECT * FROM currency");
        return $query->result_array();
    }
	public function format($number, $currency, $value = '', $format = true) {
		$symbol_left = $this->currencies[$currency]['symbol_left'];
		$symbol_right = $this->currencies[$currency]['symbol_right'];
		$decimal_place = $this->currencies[$currency]['decimal_place'];

		if (!$value) {
			$value = $this->currencies[$currency]['value'];
		}

		$amount = $value ? (float)$number * $value : (float)$number;

		$amount = round($amount, (int)$decimal_place);
		if (!$format) {
			return $amount;
		}
		$string = '';
		if ($symbol_left) {
			$string .= $symbol_left;
		}
		$string .= number_format($amount, (int)$decimal_place, $this->ci->config->item('decimal_point'), $this->ci->config->item('thousand_point'));
		if ($symbol_right) {
			$string .= $symbol_right;
		}
		return $string;

	}

	public function convert($value, $from, $to) {
		if (isset($this->currencies[$from])) {
			$from = $this->currencies[$from]['value'];
		} else {
			$from = 1;
		}

		if (isset($this->currencies[$to])) {
			$to = $this->currencies[$to]['value'];
		} else {
			$to = 1;
		}

		return $value * ($to / $from);
	}
	
	public function getId($currency) {
		if (isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['currency_id'];
		} else {
			return 0;
		}
	}

	public function getSymbolLeft($currency) {
		if (isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['symbol_left'];
		} else {
			return '';
		}
	}

	public function getSymbolRight($currency) {
		if (isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['symbol_right'];
		} else {
			return '';
		}
	}

	public function getDecimalPlace($currency) {
		if (isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['decimal_place'];
		} else {
			return 0;
		}
	}

	public function getValue($currency) {
		if (isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['value'];
		} else {
			return 0;
		}
	}

	public function has($currency) {
		return isset($this->currencies[$currency]);
	}
    public function getCurrency($currency) {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency];
        } else {
            return [];
        }
    }
}
