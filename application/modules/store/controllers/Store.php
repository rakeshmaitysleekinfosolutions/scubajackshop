<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends AppController {
    /**
     * @var object
     */
    private $product;
    /**
     * @var array|int
     */
    private $products;
    private $productSlug;

    public function __construct() {
        parent::__construct();
        $this->template->set_template('layout/store');

       // dd($this->options);
    }
    // product List where status = 1
    public function index() {
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => 'Home',
            'href' => url('/')
        );
        $this->products = Shop_model::factory()->findAll(['status' => 1]);
        $this->data['products'] = array();

        if($this->products) {

            foreach ($this->products as $product) {
                $this->data['breadcrumbs'][] = array(
                    'text' => $product->category($product->id)['name'],
                    'href' => url($product->category($product->id)['slug'])
                );

                $this->data['products'][] = array(
                  'id'          => $product->id,
                  'name'        => $product->name,
                  'img'         => resize($product->image,100,100),
                  'slug'        => $product->slug,
                  'url'         => url('product/'.$product->slug),
                  'price'       => currencyFormat($product->price, $this->options['currency']['code']),
                  'description' => $product->description->description,
                );
            }
        }
        render('index', $this->data);
    }
    // product details
    public function view($slug) {
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => 'Home',
            'href' => url('/')
        );
        // if slug else redirect to product list page
        if($slug) $this->productSlug = $slug;
        if($this->productSlug) $this->product = Shop_model::factory()->findOne(['slug' => $this->productSlug,'status' => 1]);
        if(!$this->product) {
            redirect('home-store');
        }
        $productID = $this->product['id'];
        if($this->product) {
            $this->data['breadcrumbs'][] = array(
                'text' => $this->product->category($productID)['name'],
                'href' => url($this->product->category($productID)['slug'])
            );
            $this->data['product'] = array(
                'id'          => $this->product->id,
                'name'        => $this->product->name,
                'img'         => resize($this->product->image,100,100),
                'slug'        => $this->product->slug,
                'url'         => url('/product/'.$this->product->slug),
                'price'       => currencyFormat($this->product->price, $this->options['currency']['code']),
                'mrp'       => currencyFormat($this->product->mrp, $this->options['currency']['code']),
                'description' => $this->product->description->description,
            );
            $this->data['breadcrumbs'][] = array(
                'text' => $this->product->name,
                'href' => url('/product/'.$this->product->slug)
            );
        }
        $this->data['images'] = Shop_model::factory()->images($productID);
        $this->data['description'] = ShopDescription_model::factory()->findOne(['shop_id' => $productID]);
        //dd($this->data['description']);
        attach('assets/css/elastislide.css', 'css');
        attach('assets/js/modernizr.custom.17475.js', 'js');
        attach('assets/js/jquery.elastislide.js', 'js');
        render('view',$this->data);
    }
}