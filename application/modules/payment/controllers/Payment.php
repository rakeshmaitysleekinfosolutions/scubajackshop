<?php
class Payment extends AppController {
    private $customer;
    private $total;
    /**
     * @var object
     */
    //private $user;
    /**
     * @var string
     */
    private $paymentAddress = array();
    /**
     * @var string
     */
    private $shippingAddress = array();
    private $orderModelData = array();
    private $orderTotalModelData;
    private $orderProductModelData;
    /**
     * @var int
     */
    private $orderId;
    private $charge;
    private $transactionID;
    private $paymentStatus;
    private $product;
    //private $ecart;
    private $uuid;

    public function __construct() {
        parent::__construct();
        $this->template->set_template('layout/store');
    }
    private function init() {
        if(!empty($this->ecart->totals())) {
            $this->total = $this->ecart->getSubTotal();
        } else {
            $this->total = 0;
        }

        // If post data is not empty
        if(!empty($this->input->post('product'))) {
            $this->data['product'] = $this->input->post('product');
        } else {
            $this->data['product'] = array();
        }

        if(!empty($this->input->post('name'))) {
            $this->data['name'] = $this->input->post('name');
        } else {
            $this->data['name'] = '';
        }
        if(!empty($this->input->post('email'))) {
            $this->data['email'] = $this->input->post('email');
        } else {
            $this->data['email'] = '';
        }
        // Cart Details
        $this->data['card'] = array();
        if(!empty($this->input->post('number'))) {
            $this->data['card']['number'] = $this->input->post('number');
        } else {
            $this->data['card']['number'] = preg_replace('/\s+/', '', $this->input->post('number'));
        }
        if(!empty($this->input->post('exp_month'))) {
            $this->data['card']['exp_month'] = $this->input->post('exp_month');
        } else {
            $this->data['card']['exp_month'] = '';
        }
        if(!empty($this->input->post('exp_year'))) {
            $this->data['card']['exp_year'] = $this->input->post('exp_year');
        } else {
            $this->data['card']['exp_year'] = '';
        }
        if(!empty($this->input->post('cvc'))) {
            $this->data['card']['cvc'] = $this->input->post('cvc');
        } else {
            $this->data['card']['cvc'] = '';
        }

        if(!empty($this->data['card'])) {
            $this->data['token'] = $this->stripe->token($this->data['card']);
        }
    }
    private function breadcrumbs() {
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
    }
    private function payment() {
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
                        'price'     => $this->currency->format($value['price'], $this->options['currency']['code'], $this->currency->getValue($this->options['currency']['code'])),
                        'quantity'       => $value['quantity'],
                        'total'     => $this->currency->format($value['total'], $this->options['currency']['code'], $this->currency->getValue($this->options['currency']['code'])),
                        'value'     => $value['total']
                    );
                }
            }

            if($totals) {
                foreach ($totals as $total) {
                    $this->data['totals'][] = array(
                        'title' => $total['title'],
                        'text'  => $this->currency->format($total['value'],$this->options['currency']['code'],$this->currency->getValue($this->options['currency']['code']))
                    );
                }
            }
        }
    }
    private function saveOrderData() {
        if ($this->user->isLogged()) {
            $this->customer                               = User_model::factory()->findOne($this->user->getId());
            $this->orderModelData['customer_id']          = $this->customer->id;
            $this->orderModelData['firstname']            = $this->customer->firstname;
            $this->orderModelData['lastname']             = $this->customer->lastname;
            $this->orderModelData['email']                = $this->customer->email;
            $this->orderModelData['phone']                = $this->customer->phone;
        }
        if(!empty(getSession('payment_address'))) {
            $this->paymentAddress = getSession('payment_address');
        }
        if(!empty($this->paymentAddress)) {

            $this->orderModelData['payment_firstname']        = $this->paymentAddress['firstname'];
            $this->orderModelData['payment_lastname']         = $this->paymentAddress['lastname'];
            $this->orderModelData['payment_address_1']        = $this->paymentAddress['address_1'];
            $this->orderModelData['payment_address_2']        = $this->paymentAddress['address_2'];
            $this->orderModelData['payment_city']             = $this->paymentAddress['city'];
            $this->orderModelData['payment_postcode']         = $this->paymentAddress['postcode'];
            $this->orderModelData['payment_zone']             = State_model::factory()->findOne($this->paymentAddress['state_id'])->name;
            $this->orderModelData['payment_zone_id']          = $this->paymentAddress['state_id'];
            $this->orderModelData['payment_country']          = Country_model::factory()->findOne($this->paymentAddress['country_id'])->name;
            $this->orderModelData['payment_country_id']       = $this->paymentAddress['country_id'];
        }


        if (getSession('payment_method')) {
            $this->orderModelData['payment_method'] = getSession('payment_method')['title'];
        } else {
            $this->orderModelData['payment_method'] = 'Credit Card';
        }

        if (getSession('payment_method')) {
            $this->orderModelData['payment_code'] = getSession('payment_method')['code'];
        } else {
            $this->orderModelData['payment_code'] = '';
        }

        if(!empty(getSession('shipping_address'))) {
            $this->shippingAddress = getSession('shipping_address');
        }

        if ($this->ecart->hasShipping()) {

            $this->orderModelData['shipping_firstname']       = $this->shippingAddress['firstname'];
            $this->orderModelData['shipping_lastname']        = $this->shippingAddress['lastname'];
            $this->orderModelData['shipping_address_1']       = $this->shippingAddress['address_1'];
            $this->orderModelData['shipping_address_2']       = $this->shippingAddress['address_2'];
            $this->orderModelData['shipping_city']            = $this->shippingAddress['city'];
            $this->orderModelData['shipping_postcode']        = $this->shippingAddress['postcode'];
            $this->orderModelData['shipping_zone']            = $this->shippingAddress['zone'];
            $this->orderModelData['shipping_zone_id']         = $this->shippingAddress['zone_id'];
            $this->orderModelData['shipping_country']         = $this->shippingAddress['country'];
            $this->orderModelData['shipping_country_id']      = $this->shippingAddress['country_id'];

//            if (isset(getSession('shipping_method']['title'])) {
//                $order_data['shipping_method'] = getSession('shipping_method']['title'];
//            } else {
//                $order_data['shipping_method'] = '';
//            }
//
//            if (isset(getSession('shipping_method']['code'])) {
//                $order_data['shipping_code'] = getSession('shipping_method']['code'];
//            } else {
//                $order_data['shipping_code'] = '';
//            }
        } else {
            $this->orderModelData['shipping_firstname']       = '';
            $this->orderModelData['shipping_lastname']        = '';
            $this->orderModelData['shipping_address_1']       = '';
            $this->orderModelData['shipping_address_2']       = '';
            $this->orderModelData['shipping_city']            = '';
            $this->orderModelData['shipping_postcode']        = '';
            $this->orderModelData['shipping_zone']            = '';
            $this->orderModelData['shipping_zone_id']         = '';
            $this->orderModelData['shipping_country']         = '';
            $this->orderModelData['shipping_country_id']      = '';
            $this->orderModelData['shipping_method']          = '';
            $this->orderModelData['shipping_code']            = '';
        }
        $this->orderModelData['currency_id']           = $this->options['currency']['id'];
        $this->orderModelData['currency_code']         = $this->options['currency']['code'];
        $this->orderModelData['currency_value']        = $this->currency->getValue($this->options['currency']['value']);
        $this->orderModelData['ip']                    = $this->input->server('REMOTE_ADDR');

        if (!empty($this->input->server('HTTP_X_FORWARDED_FOR'))) {
            $this->orderModelData['forwarded_ip'] = $this->input->server('HTTP_X_FORWARDED_FOR');
        } elseif (!empty($this->input->server('HTTP_CLIENT_IP'))) {
            $this->orderModelData['forwarded_ip'] = $this->input->server('HTTP_CLIENT_IP');
        } else {
            $this->orderModelData['forwarded_ip'] = '';
        }

        if ($this->input->server('HTTP_USER_AGENT')) {
            $this->orderModelData['user_agent'] = $this->input->server('HTTP_USER_AGENT');
        } else {
            $this->orderModelData['user_agent'] = '';
        }
        // Set Order Status
        $this->orderModelData['order_status_id'] = 5; // Complete
        $this->orderModelData['total'] = $this->ecart->getTotal(); // Total
        // Order Model
        if(!empty($this->orderModelData)) {
            Order_model::factory()->insert([
                'uuid'                          => $this->uuid,
                'invoice_prefix'                => 'INV-',
                'customer_id'                   => $this->orderModelData['customer_id'],
                'firstname'                     => $this->orderModelData['firstname'],
                'lastname'                      => $this->orderModelData['lastname'],
                'email'                         => $this->orderModelData['email'],
                'phone'                         => $this->orderModelData['phone'],
                'payment_firstname'             => $this->orderModelData['payment_firstname'],
                'payment_lastname'              => $this->orderModelData['payment_lastname'],
                'payment_address_1'             => $this->orderModelData['payment_address_1'],
                'payment_address_2'             => $this->orderModelData['payment_address_2'],
                'payment_city'                  => $this->orderModelData['payment_city'],
                'payment_postcode'              => $this->orderModelData['payment_postcode'],
                'payment_country'               => $this->orderModelData['payment_country'],
                'payment_country_id'            => $this->orderModelData['payment_country_id'],
                'payment_zone'                  => $this->orderModelData['payment_zone'],
                'payment_zone_id'               => $this->orderModelData['payment_zone_id'],
                'payment_method'                => $this->orderModelData['payment_method'],
                'payment_code'                  => $this->orderModelData['payment_code'],
                'shipping_firstname'            => $this->orderModelData['shipping_firstname'],
                'shipping_lastname'             => $this->orderModelData['shipping_lastname'],
                'shipping_address_1'            => $this->orderModelData['shipping_address_1'],
                'shipping_address_2'            => $this->orderModelData['shipping_address_2'],
                'shipping_city'                 => $this->orderModelData['shipping_city'],
                'shipping_postcode'             => $this->orderModelData['shipping_postcode'],
                'shipping_country'              => $this->orderModelData['shipping_country'],
                'shipping_country_id'           => $this->orderModelData['shipping_country_id'],
                'shipping_zone'                 => $this->orderModelData['shipping_zone'],
                'shipping_zone_id'              => $this->orderModelData['shipping_zone_id'],
                'shipping_method'               => $this->orderModelData['shipping_method'],
                'shipping_code'                 => $this->orderModelData['shipping_code'],
                'total'                         => $this->orderModelData['total'],
                'order_status_id'               => $this->orderModelData['order_status_id'],
                'currency_id'                   => $this->orderModelData['currency_id'],
                'currency_code'                 => $this->orderModelData['currency_code'],
                'currency_value'                => $this->orderModelData['currency_value'],
                'ip'                            => $this->orderModelData['ip'],
                'forwarded_ip'                  => $this->orderModelData['forwarded_ip'],
                'user_agent'                    => $this->orderModelData['user_agent'],
            ]);

            $this->orderId = Order_model::factory()->getLastInsertID();
        }

        // Order History

        if($this->transactionID) {
            OrderHistory_model::factory()->insert([
               'order_id'           => $this->orderId,
               'transaction_id'     => $this->transactionID,
               'payment_status'     => $this->paymentStatus,
               'order_status_id'    => $this->orderModelData['order_status_id'],
            ]);
        }
        // Order Product Model
        $this->orderProductModelData['products']              = array();
        if(!empty($this->ecart->hasProducts())) {
            foreach ($this->ecart->getProducts() as $key => $value) {
                $this->orderProductModelData['products'][] = array(
                    'order_id'      => $this->orderId,
                    'product_id'    => $value['product_id'],
                    'name'          => $value['name'],
                    'quantity'      => $value['quantity'],
                    'price'         => $this->currency->format($value['price'], $this->options['currency']['code'], $this->getValue($this->options['currency']['code'])),
                    'total'         => $this->currency->format($value['total'], $this->options['currency']['code'], $this->getValue($this->options['currency']['code'])),
                );
            }
        }

        if(!empty($this->orderProductModelData['products'])) {
            foreach ($this->orderProductModelData['products'] as $product) {
                OrderProduct_model::factory()->insert([
                    'order_id'          => $product['order_id'],
                    'product_id'        => $product['product_id'],
                    'name'              => $product['name'],
                    'quantity'          => $product['quantity'],
                    'price'             => $product['price'],
                    'total'             => $product['total'],
                ]);
            }
        }
        // Order Total Model
        $totals = array();
        if(!empty($this->ecart->totals())) {
            $totals = $this->ecart->totals()['totals'];
        }
        $this->orderTotalModelData = array();
        if($totals) {
            foreach ($totals as $total) {
                //print_r($total);
                $this->orderTotalModelData['totals'][] = array(
                    'title' => $total['title'],
                    'code'  => $total['code'],
                    'value' => $total['value'],
                    'sort_order' => $total['sort_order'],
                    'text'  => $this->currency->format($total['value'],$this->options['currency']['code'],$this->getValue($this->options['currency']['code']))
                );
            }
        }
        if(!empty($this->orderTotalModelData['totals'])) {
            foreach ($this->orderTotalModelData['totals'] as $orderTotalModelData) {
                OrderTotal_model::factory()->insert([
                    'order_id'          => $this->orderId,
                    'code'              => $orderTotalModelData['code'],
                    'title'             => $orderTotalModelData['title'],
                    'value'             => $orderTotalModelData['value'],
                    'sort_order'        => $orderTotalModelData['sort_order'],
                ]);
            }
        }
        if(!empty($this->uuid)) {
            seSession('order_id', $this->uuid);
        }

    }
    public function index() {
        if(!$this->ecart->hasProducts()) {
            redirect(url('/cart'));
        }
        // Pay Now
        if($this->isAjaxRequest() && $this->isPost()) {
            $this->init();
            if(!empty($this->data)){
                // Retrieve stripe token, card and user info from the submitted form data
                // Unique order ID
                $this->uuid = strtoupper(str_replace('.','',uniqid('', true)));
                // Add customer to stripe
                $user = User_model::factory()->findOne(userId());
                if($this->user) {
                    $this->customer = $this->stripe->addCustomer($user->email, $this->data['token']);
                }
                if($this->customer) {
                    $this->stripe->setDescription('Card Payment');
                    $this->stripe->setAmount($this->total);
                    $this->stripe->setOrderId($this->uuid);
                    $this->stripe->setCurrency($this->options['currency']['code']);
                    $this->charge = $this->stripe->createCharge();
                }
                if($this->charge) {
                    // Check whether the charge is successful
                    if($this->charge['amount_refunded'] == 0 && empty($this->charge['failure_code']) && $this->charge['paid'] == 1 && $this->charge['captured'] == 1){
                        // Transaction details
                        $this->transactionID = $this->charge['balance_transaction'];
                        $this->paymentStatus = $this->charge['status'];
                    }
                }
                if($this->paymentStatus == 'succeeded'){
                    $this->json['success'] = true;
                    $this->json['message'] = 'Your payment has been successfully complete';
                    $this->json['redirect'] = url('checkout/success');
                    $this->saveOrderData();
                }
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }

        $this->breadcrumbs();
        $this->payment();
        render('payment/index', $this->data);
    }

    public function success() {

    }
}