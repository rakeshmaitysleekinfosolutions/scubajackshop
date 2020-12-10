<?php
class Cart extends AppController {


    /**
     * @var object
     */
    private $product;
    private $coupon;
    private $code;
    /**
     * @var string
     */
    private $total;

    public function __construct() {
        parent::__construct();
        $this->template->set_template('layout/store');

         //dd($_SESSION);
        //dd(getSession('total'));
    }
    public function init() {

    }

    /**
     * @Index
     */
    public function index() {
        $this->data['form'] = array(
          'action' => url('checkout/cart/update'),
            'name' => 'frmCart'
        );
        $this->data['logged'] = $this->user->isLogged();
        if ($this->ecart->hasProducts()) {
            if (!$this->ecart->hasStock()) {
                $this->data['warning'] = 'Products marked with *** are not available in the desired quantity or not in stock!';
            } elseif (isset($this->session->data['error'])) {
                $this->data['warning'] = getSession('error');
                unsetSession(getSession('error'));
            } else {
                $this->data['warning'] = '';
            }

            if(!empty($this->ecart->hasProducts())) {
                $this->product = $this->ecart->getProducts();
            }
            $totals = array();
            if(!empty($this->ecart->totals())) {
                //dd($this->ecart->totals());
                $totals = $this->ecart->totals()['totals'];
                //dd($totals);
            }
           // dd($this->product);
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
            //dd($totals);
            render('cart/index', $this->data);
        } else {
            $this->data['error'] = 'Your shopping cart is empty!';
            render('errors/not_found', $this->data);
        }
    }

    /**
     * @return mixed
     */
    public function add() {
        if($this->isAjaxRequest()) {
            $this->json = array();

            if($this->input->post('product_id')) {
                $this->data['product_id'] = (int)$this->input->post('product_id');
            } else {
                $this->data['product_id'] = 0;
            }

            $this->product = Shop_model::factory()->findOne($this->data['product_id']);
            //dd($this->product->price);
            if($this->product) {
                if ($this->input->post('quantity')) {
                    $this->data['quantity'] = (int)$this->input->post('quantity');
                } else {
                    $this->data['quantity'] = 1;
                }

                $this->data['name']  = $this->product['name'];
            }
            if (!$this->json) {

                $this->data['price'] = $this->product->price;
                $this->data['total'] = ($this->product->price * $this->data['quantity']);

                if($this->ecart->previousUsed >= $this->data['quantity']) {
                    return $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(200)
                        ->set_output(json_encode(array('status' => false,'message' => 'Already Booked or Added in cart')));
                }

                unsetSession('payment_address', array());
                unsetSession('shipping_address', array());

                $this->ecart->add($this->data);
                $this->json['success']  = 'Success: Product has been successfully added to cart';
                $this->json['total']    = sprintf('%s item(s) - %s', $this->ecart->countProducts() , $this->currency->format($this->ecart->totals()['total'], $this->options['currency']['code']));

            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }
    }

    /**
     * @return mixed
     */
    public function update() {
        if($this->isAjaxRequest()) {
            $this->json = array();
            if($this->input->post('quantity')) {
                foreach ($this->input->post('quantity') as $key => $value) {
                    $this->ecart->update($key, $value);
                }
                $this->json['success'] = 'Success: You have modified your shopping cart!';
                $this->json['total']    = sprintf('%s item(s) - %s', $this->ecart->countProducts() , $this->currency->format($this->ecart->totals()['total'], $this->options['currency']['code']));
                $this->json['redirect'] = url('checkout/cart');
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }
    }

    public function coupon() {
        if($this->isAjaxRequest()) {
            $this->json = array();
            if ($this->input->post('code')) {
                $this->code = $this->input->post('code');
            } else {
                $this->code = '';
            }
            $this->coupon = $this->code->getCoupon($this->code);

            if (empty($this->input->post('coupon'))) {
                $json['error'] = $this->config->item('error_empty');
            } elseif ($this->coupon) {
                setSession('coupon',$this->input->post('coupon'));
                setSession('success',$this->config->item('text_success'));
                $this->json['redirect'] = url('cart');
            } else {
                $this->json['error'] = $this->config->item('error_coupon');
            }

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }

    }

    /**
     * @return mixed
     */
    public function remove() {
        if($this->isAjaxRequest()) {
            $this->ecart->remove($this->input->post('cart_id'));
            $this->json['success'] = true;
            $this->json['redirect'] = url('checkout/cart');
            $this->json['total']    = sprintf('%s item(s) - %s', $this->ecart->countProducts() , $this->currency->format($this->ecart->totals()['total'], $this->options['currency']['code']));
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }

    }
}