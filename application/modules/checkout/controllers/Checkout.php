<?php
class Checkout extends AppController {
    /**
     * @var object
     */
    private $country;
    private $product;

    public function __construct() {
        parent::__construct();
        $this->template->set_template('layout/store');
    }

    public function index() {
        if(!$this->ecart->hasProducts()) {
            redirect(url('cart'));
        }
        // Validate minimum quantity requirements.
//        $products = $this->ecart->getProducts();
//        foreach ($products as $product) {
//            //dd($product);
//            $product_total = 0;
//            foreach ($products as $product_2) {
//                if ($product_2['product_id'] == $product['product_id']) {
//                    $product_total += $product_2['quantity'];
//                }
//            }
//            if ($product['minimum'] > $product_total) {
//                redirect(url('/cart'));
//            }
//        }
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
        //dd($_SESSION);
        $this->data['countries']    = Country_model::factory()->findAll([],null,'id', 'asc');
        $this->data['states']       = State_model::factory()->findAll([],null,'id', 'asc');

        // Payment Address
        $this->data['payment_address'] = array();
        if (!empty(getSession('payment_address'))) {
            $this->data['payment_address'] = getSession('payment_address');
        }
        // Shipping Address
        $this->data['shipping'] = false;
        $this->data['shipping_address'] = array();
        if (!empty(getSession('shipping_address'))) {
            $this->data['shipping_address'] = getSession('payment_address');
            $this->data['shipping'] = true;
        }

        attach('assets/js/jquery.validate.js', 'js');
        attach('assets/js/additional-methods.js', 'js');
        render('checkout/index', $this->data);
    }
    public function states() {
        if($this->isAjaxRequest()) {
            $json = array();
            $this->country =  Country_model::factory()->findOne($this->input->post('country_id'));
            if ($this->country) {
                $json = array(
                    'country_id'        => $this->country->id,
                    'states'            => $this->country->states(),
                );
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($json));
        }
    }
    public function savePaymentAddress() {
        if($this->isAjaxRequest()) {
            // Payment Address
            $paymentAddress = array();
            if(!empty($this->input->post('payment_address')) && is_array($this->input->post('payment_address'))) {
                $paymentAddress = $this->input->post('payment_address');
            }
            if(!empty($paymentAddress)) {
               //dd($this->user->getId());
               UserAddress_model::factory()->update([
                   'firstname'  => $paymentAddress['firstname'],
                   'lastname'   => $paymentAddress['lastname'],
                   'address_1'  => $paymentAddress['address_1'],
                   'address_2'  => $paymentAddress['address_2'],
                   'country_id' => $paymentAddress['country_id'],
                   'state_id'   => $paymentAddress['state_id'],
                   'city'       => $paymentAddress['city'],
                   'postcode'   => $paymentAddress['postcode'],
               ],['user_id' => $this->user->getId()]);
                setSession('payment_address', [
                    'firstname'  => $paymentAddress['firstname'],
                    'lastname'   => $paymentAddress['lastname'],
                    'address_1'  => $paymentAddress['address_1'],
                    'address_2'  => $paymentAddress['address_2'],
                    'country_id' => $paymentAddress['country_id'],
                    'state_id'   => $paymentAddress['state_id'],
                    'city'       => $paymentAddress['city'],
                    'postcode'   => $paymentAddress['postcode'],
                ]);
                $this->json['success'] = true;
            }
            // Shipping Address
            $shippingAddress = array();
            if(!empty($this->input->post('shipping_address')) && is_array($this->input->post('shipping_address'))) {
                $shippingAddress = $this->input->post('shipping_address');
            }
            if(!empty($shippingAddress)) {
                UserAddress_model::factory()->insert([
                    'user_id'    => $this->user->getId(),
                    'type'       => 2,
                    'firstname'  => $shippingAddress['firstname'],
                    'lastname'   => $shippingAddress['lastname'],
                    'address_1'  => $shippingAddress['address_1'],
                    'address_2'  => $shippingAddress['address_2'],
                    'country_id' => $shippingAddress['country_id'],
                    'state_id'   => $shippingAddress['state_id'],
                    'city'       => $shippingAddress['city'],
                    'postcode'   => $shippingAddress['postcode'],
                ]);
                setSession('shipping_address', [
                    'firstname'  => $shippingAddress['firstname'],
                    'lastname'   => $shippingAddress['lastname'],
                    'address_1'  => $shippingAddress['address_1'],
                    'address_2'  => $shippingAddress['address_2'],
                    'country_id' => $shippingAddress['country_id'],
                    'state_id'   => $shippingAddress['state_id'],
                    'city'       => $shippingAddress['city'],
                    'postcode'   => $shippingAddress['postcode'],
                ]);
                $this->json['success'] = true;

            }
            $this->json['redirect'] = url('/payment-method');
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }
    }

    public function payment() {
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => 'Home',
            'href' => url('/home-store')
        );
        $this->data['breadcrumbs'][] = array(
            'text' => 'Checkout',
            'href' => url('/checkout')
        );
        $this->data['breadcrumbs'][] = array(
            'text' => 'Payment Method',
            'href' => url('/payment')
        );
        if ($this->ecart->hasProducts()) {
            if(!empty($this->ecart->hasProducts())) {
                $this->product = $this->ecart->getProducts();
            }
            $totals = array();
            if(!empty($this->ecart->totals())) {
                $totals = $this->ecart->totals()['totals'];
            }
            if($this->product) {
                foreach ($this->product as $key => $value) {
                    $this->data['products'][] = array(
                        'cart_id'   => $value['cart_id'],
                        'name'      => $value['name'],
                        'href'      => url('/product/'.$value['slug']),
                        'thumb'     => resize($value['image'],100,100),
                        'stock'     => $value['stock'] ? true : 'Out Of Stock',
                        'price'     => $this->format($value['price'], $this->options['currency']['code'], $this->getValue($this->options['currency']['code'])),
                        'quantity'       => $value['quantity'],
                        'total'     => $this->format($value['total'], $this->options['currency']['code'], $this->getValue($this->options['currency']['code'])),
                        'value'     => $value['total']

                    );
                }
            }

            if($totals) {
                foreach ($totals as $total) {
                    $this->data['totals'][] = array(
                        'title' => $total['title'],
                        'text'  => $this->format($total['value'],$this->options['currency']['code'],$this->getValue($this->options['currency']['code']))
                    );
                }
            }
        }
        $this->data['years'] = array(2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030);
        render('checkout/payment', $this->data);
    }
}