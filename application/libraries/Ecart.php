<?php  

class Ecart {
	
	private $ci;
	public $previousUsed = 0;
	public $nextUsed = 0;
	public function __construct()
	{
		$this->ci = &get_instance();
		// Remove all the expired carts with no customer ID
		$this->ci->db->query("DELETE FROM carts WHERE (user_id = '0') AND created_at < DATE_SUB(NOW(), INTERVAL 1 HOUR)");
		if ($this->ci->user->getId()) {
			// We want to change the session ID on all the old items in the customers cart
			$this->ci->db->query("UPDATE carts SET session_id = '" . session_id() . "' WHERE user_id = '" . (int)$this->ci->user->getId() . "'");
			// Once the customer is logged in we want to update the customers cart
			$cart_query = $this->ci->db->query("SELECT * FROM carts WHERE user_id = '0' AND session_id = '" . $this->ci->db->escape_str(session_id()) . "'");
			foreach ($cart_query->result_array() as $cart) {
				$this->ci->db->query("DELETE FROM carts WHERE id = '" . (int)$cart['id'] . "'");
				// The advantage of using $this->add is that it will check if the products already exist and increaser the quantity if necessary.
				$this->add($cart);
			}
		}
	}


    public function getSumOfTotalQty($id) {
        $result = $this->ci->db->select('SUM(qty) AS qty')
                ->from('carts')
                ->where('product_id', $id)
                ->get()
				->row_array();
		if($result) {
			return $result['qty'];
		}
    }
    public function add($data) {
		$query = $this->ci->db->query("SELECT COUNT(*) AS total FROM carts WHERE session_id = '" . $this->ci->db->escape_str(session_id()) . "' AND user_id = '" . (int)$this->ci->user->getId() . "' AND product_id = '" . (int)$data['product_id'] . "'");
        $row = $query->row_array();
		if (!$row['total']) {
			$this->ci->db->query("INSERT carts SET session_id = '" . $this->ci->db->escape_str(session_id()) . "', product_id = '" . (int)$data['product_id'] . "', name = '" . $this->ci->db->escape_str($data['name']) . "', quantity = '" . (int)$data['quantity'] . "',user_id = '" . (int)$this->ci->user->getId() . "',price = '" . (int)$data['price'] . "',total = '" . (int)$data['total'] . "'");
		} else {
			$this->ci->db->query("UPDATE carts SET quantity = (quantity + " . (int)$data['quantity'] . "),user_id = '" . (int)$this->ci->user->getId() . "' WHERE session_id = '" . $this->ci->db->escape_str(session_id()) . "'  AND product_id = '" . (int)$data['product_id'] . "'");
		}
	}
	public function remove($id_carts) {
		$this->ci->db->query("DELETE FROM `carts` WHERE id = '" . (int)$id_carts . "' AND session_id = '" . $this->ci->db->escape_str(session_id()) . "'");
	}
    public function update($cart_id, $quantity) {
        $this->ci->db->query("UPDATE `carts` SET quantity = '" . (int)$quantity . "' WHERE id = '" . (int)$cart_id . "' AND user_id = '" . (int)$this->ci->user->getId() . "' AND session_id = '" . $this->ci->db->escape_str(session_id()) . "'");
    }
	public function clear() {
		$this->ci->db->query("DELETE FROM carts WHERE  session_id = '" . $this->ci->db->escape_str(session_id()) . "'");
    }
    public function getProducts() {
		$product_data = array();
		$cart_query = $this->ci->db->query("SELECT * FROM carts WHERE user_id = '" . (int)$this->ci->user->getId() . "' AND session_id = '" . $this->ci->db->escape_str(session_id()) . "'");
		foreach ($cart_query->result_array() as $cart) {
            $stock = true;
            $product_query = $this->ci->db->query("SELECT * FROM shop p LEFT JOIN shop_description pd ON (p.id = pd.shop_id) WHERE p.id = '" . (int)$cart['product_id'] . "'  AND p.date_available <= NOW() AND p.status = '1'");
            // Stock
            if (!$product_query->row_array()['quantity'] || ($product_query->row_array()['quantity'] < $cart['quantity'])) {
                $stock = false;
            }

			if ($cart['quantity'] > 0) {
				$product_data[] = array(
					'cart_id'           => $cart['id'],
					'product_id'        => $cart['product_id'],
					'session_id'        => $cart['session_id'],
					'user_id'           => $cart['user_id'],
                    'name'              => $cart['name'],
                    'slug'              => $product_query->row_array()['slug'],
                    'image'             => $product_query->row_array()['image'],
					'price'             => $cart['price'],
					'quantity'          => $cart['quantity'],
					'stock'             => $stock,
					'total'             => (int)($cart['price'] * $cart['quantity']),
				);
			} else {
				$this->remove($cart['id']);
			}
		}
		return $product_data;
	}
    public function getSubTotal() {
		$total = 0;
		foreach ($this->getProducts() as $product) {
			$total += $product['total'];
		}
		return $total;
	}

	public function getTaxes() {
		$tax_data = array();

		foreach ($this->getProducts() as $product) {

			if ($product['tax_class_id']) {
				$tax_rates = $this->ci->tax->getRates($product['price'], $product['tax_class_id']);
				// echo "<pre>";
				// print_r($tax_rates);
				// exit;
				foreach ($tax_rates as $tax_rate) {
					if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
						$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['qty']);
					} else {
						$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product['qty']);
					}
				}
			}
		}

		return $tax_data;
	}

	public function getTotal() {
		$total = 0;

		foreach ($this->getProducts() as $product) {
			$total += $this->ci->tax->calculate($product['price'], $product['tax_class_id'], $this->ci->config->item('config_tax')) * $product['qty'];
		}

		return $total;
	}

	public function countProducts() {
		$product_total = 0;

		$products = $this->getProducts();

		foreach ($products as $product) {
			$product_total += $product['quantity'];
		}

		return $product_total;
	}

	public function hasProducts() {
		return count($this->getProducts());
	}
    public function hasStock() {
        foreach ($this->getProducts() as $product) {
            if (!$product['stock']) {
                return false;
            }
        }

        return true;
    }
	public function setPreviousUsed($value) {
        $this->previousUsed = $value;
	}
	public function setNextUsed($value) {
        $this->nextUsed = $value;
    }
    /**
     * @desc get seat details or insert seat info
     * @method getSeatInfoCreate
     * @return mixed
     */
    public function getSeatInfoCreate($id, $data) {
		$seat = $this->ci->seatinfo->find()->where(['id' => $id])->get()->row_array();
        if(!empty($seat)) {
			if($data['type'] == 'zone') {
				$this->setPreviousUsed((int)$seat['used']);
				$this->ci->db->query("UPDATE `seat_infos` SET used = (used + " . (int)$data['qty'] . ") WHERE id = '" . $this->ci->db->escape_str($id) . "'");
				$seatInfo = $this->ci->seatinfo->find()->where(['id' => $id])->get()->row_array();
				$this->setNextUsed((int)$seatInfo['used']);
			} else {

				$this->setPreviousUsed((int)$seat['used']);
				$this->ci->db->query("UPDATE `seat_infos` SET used = ".(int)$data['qty']. " WHERE id = '" . $this->ci->db->escape_str($id) . "'");
				$seatInfo = $this->ci->seatinfo->find()->where(['id' => $id])->get()->row_array();
				$this->setNextUsed((int)$seatInfo['used']);

			}


        } else {
            $this->ci->seatinfo->insert($data);
            $seatInfo = $this->ci->seatinfo->find()->where(['product_id' => $this->ci->seatinfo->getLastInsertID()])->get()->row_array();
            $this->setPreviousUsed((int)$seatInfo['used']);
		}
		if($seatInfo) {
			return $seatInfo;
		}
    }

	public function updateUsed($id, $qty) {
		$seat_query = $this->ci->db->query("SELECT `qty` FROM `seat_infos` WHERE product_id = '" . (int)$this->ci->db->escape_str($id) . "'");
		$row = $seat_query->row_array();
		if(!empty($row)) {
			$qty_ = ($row['used']-$qty);
			if($qty_ == (int)-1) {
				$used = 0;
			} else {
				$used = $qty_;
			}
			$this->ci->db->query("UPDATE `seat_infos` SET used = '" . (int)$used . "' WHERE product_id = '" . $this->ci->db->escape_str($id) . "'");
		}
	}
	/**
     * @desc check seat already in cart by seat_info id
     * @method inCart
     * @return int
     */
    public function inCart($id) {
        return $this->ci->ecart->getSumOfTotalQty($id);
    }
    /**
     * @desc check seat already in cart by seat_info id
     * @method inCart
     * @return int
     */
    public function inOrder($id) {
        return $this->ci->order_item->getSumOfTotalQty($id);

	}
	public function totals() {
        	$totals = array();
			$taxes = array();

			$total = 0;
			// Because __call can not keep var references so we put them into an array.
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);
			// Display prices
			//if ($this->ci->user->isLogged()) {
				$sort_order = array();
                $results = $this->ci->extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->getValue($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $index => $result) {
                   // print_r($result);
					if ($this->getValue($result['code'] . '_status')) {
						$type = ucfirst($result['code']);

						$field = new $type();
						get_class($field)::factory()->getTotal($total_data);
					}
				}
               
				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}
				array_multisort($sort_order, SORT_ASC, $totals);
			//}

			return $total_data;
		
			
            
    }
    public function getValue($key) {
        $query = $this->ci->db->query("SELECT `value` FROM `config` WHERE `key` = '" . $this->ci->db->escape_str($key) . "'");
        $row =  $query->row_array();
        if($row) {
            return $row['value'];
        }
    }
}