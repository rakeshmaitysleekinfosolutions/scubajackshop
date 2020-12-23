<?php
use Carbon\Carbon;
class Order extends AppController {
    private $order;
    public function __construct() {
        parent::__construct();
        $this->order = AccountOrder_model::factory();
        $this->template->set_template('layout/app');
    }

    public function index() {
        if(!$this->user->isLogged()) {
            redirect(url('login'));
        }
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => 'Home',
            'href' => url('/home-store')
        );
        $this->data['breadcrumbs'][] = array(
            'text' => 'Cart',
            'href' => url('/account')
        );
        $this->data['breadcrumbs'][] = array(
            'text' => 'Checkout',
            'href' => url('/account/order')
        );

        if (!$this->user->isLogged()) {
            $this->redirect($this->url('login'));
        }
       // if(!$this->isSubscribed()) redirect('viewplans');

        if(isLogged()) {
            $this->auser = User_model::factory()->findOne(userId());
        }
        if($this->auser) {
            $this->data['user']             = $this->auser;
            $this->data['registrationDate'] = Carbon::createFromTimeStamp(strtotime($this->auser->created_at));
        }

        $this->subscriber           = Subscriber_model::factory()->findOne(['user_id' => userId()]);
        $this->data['plan']         = array();
        $this->data['subscriber']   = array();
        $this->data['passports']    = array();

        if($this->subscriber) {
            $today              = time();
            $daysLeft           = floor((strtotime($this->subscriber->end_at)-$today)/(60*60*24));

            $this->data['plan'] = array(
                'name' => $this->subscriber->plan,
                'price' => $this->subscriber->price,
                'end_at' => $this->subscriber->end_at,
                'daysLeft' => $daysLeft,
            );
            $this->data['subscriber'] = array(
                'name' => $this->subscriber->user->firstname. " " .$this->subscriber->user->lastname,
                'email' => $this->subscriber->user->email,
            );
            $passports = UserPassport_model::factory()->findAll([
                'user_id'       => $this->subscriber->user_id,
            ]);
            if($passports) {
                foreach ($passports as $key => $passport) {
                    $stampedContinents[] = array(
                        'country' =>   $passport->country->continent->name,
                        'timestamp' =>   $passport->created_at
                    );
                }
            }
            if (isset($stampedContinents)) {
                $this->data['passports'] = array_unique(getDataPair($stampedContinents, 'timestamp', 'country'));
            } else {
                $this->data['passports'] = array();
            }
            // Passport close here
            // Get Points Query start from here
            $query = $this->db->query("SELECT SUM(points) AS points FROM `users_points` WHERE users_points.user_id = '".$this->subscriber->user_id."'");
            $points = array();
            if($query) {
                $points = $query->row_array();
            }

            $this->data['points'] = (isset($points['points'])) ? $points['points'] : 0;
            // Point close here


            //dd($this->data);
        }

        // Image
        if (!empty($this->input->post('image'))) {
            $this->data['image'] = $this->input->post('image');
        } elseif (!empty($this->auser)) {
            $this->data['image'] = $this->auser->image;
        } else {
            $this->data['image'] = '';
        }

        if (!empty($this->input->post('image')) && is_file(DIR_IMAGE . $this->input->post('image'))) {
            $this->data['thumb'] = $this->resize($this->input->post('image'), 100, 100);
        } elseif (!empty($this->auser) && is_file(DIR_IMAGE . $this->auser->image)) {
            $this->data['thumb'] = $this->resize($this->auser->image, 100, 100);
        } else {
            $this->data['thumb'] = $this->resize('no_image.png', 100, 100);
        }
        $this->data['placeholder']  = $this->resize('no_image.png', 100, 100);

        // Orders
        $this->data['order_total'] = $this->order->getTotalOrders();
        $this->results = $this->order->getOrders();
        foreach ($this->results as $result) {
            //echo $this->options['currency']['code'];
            $product_total = $this->order->getTotalOrderProductsByOrderId($result['order_id']);
            $this->data['orders'][] = array(
                'order_id'   => $result['order_id'],
                'name'       => $result['firstname'] . ' ' . $result['lastname'],
                'status'     => $result['status'],
                'date'       => Carbon::createFromTimeStamp(strtotime($result['created_at'])),
                'products'   => $product_total,
                'total'      => $this->currency->format($result['total'], $this->options['currency']['code'], $this->options['currency']['value'], true),
                'view'       => url('account/order/info/'.$result['order_id']),
            );
        }
       // dd($this->data['orders']);
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/account/Account.js');
        $this->template->content->view('account/index', $this->data);
        $this->template->publish();


    }
}