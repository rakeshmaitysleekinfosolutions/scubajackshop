<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Stripe Library for CodeIgniter 3.x
 *
 * Library for Stripe payment gateway. It helps to integrate Stripe payment gateway
 * in CodeIgniter application.
 *
 * This library requires the Stripe PHP bindings and it should be placed in the third_party folder.
 * It also requires Stripe API configuration file and it should be placed in the config directory.
 *

 */

class Stripe{
    var $CI;
	var $api_error;
    /**
     * @var \Stripe\StripeClient
     */
    private $stripe;
    /**
     * @var \Stripe\Customer
     */
    private $customer;
    private $amount;
    private $orderId;
    private $description;
    private $currency;

    function __construct(){
		$this->api_error = '';
        $this->CI =& get_instance();
        $this->stripe = new \Stripe\StripeClient(
            $this->CI->config->item('stripe_secret_key')
        );
    }

    public function addCustomer($email, $token){
		try {
			// Add customer to stripe
			$this->customer =  $this->stripe->customers->create(array(
				'email' => $email,
				'source'  => $token
			));
			return $this->customer;
		}catch(Exception $e) {
			$this->api_error = $e->getMessage();
			return false;
		}
    }
    public function setAmount($value) {
        $this->amount = $value;
        return $this;
    }
    public function setCurrency($value) {
        $this->currency = $value;
        return $this;
    }
    public function setDescription($value) {
        $this->description = $value;
        return $this;
    }
    public function setOrderId($value) {
        $this->orderId = $value;
        return $this;
    }
    public function getCustomerId() {
        return $this->customer->id;
    }
    public function createCharge(){
		try {
		    //dd($this);
			// Charge a credit or a debit card
			return $this->stripe->charges->create(array(
				'customer' => $this->customer->id,
				'amount'   => $this->amount * 100,
				'currency' => $this->currency,
				'description' => $this->description,
				'metadata' => array(
					'order_id' => $this->orderId
				)
			))->jsonSerialize();
		}catch(Exception $e) {
			$this->api_error = $e->getMessage();
			return false;
		}
    }
    public function token(array $card) {
        return $this->stripe->tokens->create([
            'card' => [
                'number'    => $card['number'],
                'exp_month' => $card['exp_month'],
                'exp_year'  => $card['exp_year'],
                'cvc'       => $card['cvc'],
            ],
        ])->id;
    }

}