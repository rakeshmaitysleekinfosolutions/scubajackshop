<?php
class Success extends AppController {
    public function __construct() {
        parent::__construct();
        $this->template->set_template('layout/store');
    }
    public function index() {
        if (getSession('order_id')) {
            $this->ecart->clear();

            unsetSession('order_id');
            unsetSession('payment_address');
            unsetSession('payment_methods');
            unsetSession('shipping_address');
            unsetSession('shipping_methods');
            unsetSession('coupon');
            unsetSession('totals');
        }


        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => 'Home',
            'href' => url('/home-store')
        );
        $this->data['breadcrumbs'][] = array(
            'text' => 'Cart',
            'href' => url('/cart')
        );
        $this->data['breadcrumbs'][] = array(
            'text' => 'Checkout',
            'href' => url('/checkout')
        );
        $this->data['breadcrumbs'][] = array(
            'text' => 'Checkout',
            'href' => url('/checkout/success')
        );
        $this->data['continue'] = url('home-store');

        render('index', $this->data);
    }
}