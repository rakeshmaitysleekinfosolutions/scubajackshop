<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Application\Contracts\PaymentContract;
class Payment extends AppController implements PaymentContract {
    public function __construct() {
        $this->config();
    }
    public function config() {
        // TODO: Implement config() method.
        $this->load->config('stripe');
        Stripe\Stripe::setApiKey($this->config->item('stripeApyKey'));
    }

    public function setupWebHook() {
        // TODO: Implement setupWebHook() method.

    }
}