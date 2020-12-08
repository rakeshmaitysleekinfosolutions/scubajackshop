<?php
class Wishlist extends AppController {
    private $product;
    /**
     * @var array|string
     */
    private $wishlist;

    public function __construct() {
        parent::__construct();
        $this->template->set_template('layout/store');
        //unsetSession('totalWishListed');
    }
    public function index() {
        if (!$this->user->isLogged()) {
          redirect(url('/'));
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => 'Home',
            'href' => url('/')
        );

        $data['breadcrumbs'][] = array(
            'text' => 'My Account',
            'href' => url('/account')
        );

        $data['breadcrumbs'][] = array(
            'text' => 'Wishlist',
            'href' => url('wishlist')
        );

        $this->data['products'] = array();

        $this->results = Wishlist_model::factory()->findAll(['user_id' => $this->user->getId()]);
        $this->data['totalWishListed'] = (int)0;
        $this->data['totalWishListed'] = Wishlist_model::factory()->getTotalWishlist();

        if(count($this->results)) {
            foreach ($this->results as $result) {
                $this->product = Shop_model::factory()->findOne($result['shop_id']);
                if ($this->product) {
                    $stockStatus = StockStatus_model::factory()->findOne($this->product->stock_status_id);
                    $status = '';
                    if($stockStatus) {
                        $status = $stockStatus->name;
                    }
                    if ($this->product->quantity <= 0) {
                        $stock = $status;
                    } elseif ($this->config->item('config_stock_display')) {
                        $stock = $this->product->quantity;
                    } else {
                        $stock = 'In Stock';
                    }
                    $this->data['products'][] = array(
                        'id'          => $this->product->id,
                        'name'        => $this->product->name,
                        'img'         => resize($this->product->image,100,100),
                        'slug'        => $this->product->slug,
                        'url'         => url('/product/'.$this->product->slug),
                        'price'       => currencyFormat($this->product->price, $this->options['currency']['code']),
                        'mrp'         => currencyFormat($this->product->mrp, $this->options['currency']['code']),
                        'description' => $this->product->description->description,
                        'stock_status' => $stock
                    );
                } else {
                    Wishlist_model::factory()->delete(['shop_id' => $this->product->id], true);
                }
            }
            render('wishlist/index', $this->data);
        } else {
            render('errors/empty_wishlist', $this->data);
        }
    }
    public function remove() {
        if($this->isAjaxRequest()) {
            $shopId = ($this->input->post('shop_id')) ? $this->input->post('shop_id')  : '';
            // Remove Wishlist
            Wishlist_model::factory()->delete(['shop_id' => $shopId], true);
            $this->json['redirect'] = url('wishlist');
            $this->json['success']  = 'Success: Product has been successfully added to cart';

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }
    }
    public function add() {
        if($this->isAjaxRequest()) {

            $this->json = array();
            if (!$this->user->isLogged()) {
                $this->json['success'] = false;
                $this->json['redirect'] = url('/login');
            } else {
                if($this->input->post('product_id')) {
                    $this->data['product_id'] = (int)$this->input->post('product_id');
                } else {
                    $this->data['product_id'] = 0;
                }
                $this->product = Shop_model::factory()->findOne($this->data['product_id']);
                if($this->product) {
                    if($this->user->isLogged()) {
                        Wishlist_model::factory()->delete([
                            'user_id'       => $this->user->getId(),
                            'shop_id'    => $this->product->id,
                        ], true);
                        Wishlist_model::factory()->insert([
                            'user_id'       => $this->user->getId(),
                            'shop_id'    => $this->product->id,
                        ]);
                        $this->json['success'] = true;
                        $this->json['totalWishListed'] = sprintf('Wish List (%s)', Wishlist_model::factory()->getTotalWishlist());
                        setSession('totalWishListed', Wishlist_model::factory()->getTotalWishlist());
                    } else {
                        $this->wishlist = (getSession('wishlist')) ? getSession('wishlist') : array();
                        if(!$this->wishlist) {
                            setSession('wishlist', $this->wishlist);
                        }
                        $this->wishlist[] = $this->input->post('product_id');
                        $this->wishlist = array_unique($this->wishlist);
                        if($this->wishlist) {
                            setSession('wishlist', $this->wishlist);
                            setSession('totalWishListed', ($this->wishlist) ? count($this->wishlist) : 0);
                        }
                        $this->json['success'] = true;
                        $this->json['totalWishListed'] = sprintf('Wish List (%s)', ($this->wishlist) ? count($this->wishlist) : 0);
                    }
                }
            }


            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }
    }
}