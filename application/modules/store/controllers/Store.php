<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends AppController {
    public function __construct() {
        $this->template->set_template('layout/app');
    }
    // product List where status = 1
    public function index() {
        $products = Shop_model::factory()->findAll(['status' => 1]);
        $this->data['products'] = array();
        $this->data['products'] = $products;
        //dd($this->data['products']);
        attach('assets/css/elastislide.css', 'css');
        render('index', $this->data);
    }
    // product details
    public function view($productSlug) {
        // if slug else redirect to product list page
        if($productSlug) $this->productSlug = $productSlug;
        if($this->productSlug) $this->product = Shop_model::factory()->findOne(['slug' => $this->productSlug,'status' => 1]);
         //dd($this->product->images);
        if(!$this->product) {
            redirect('home-store');
        }
        $productID = $this->product['id'];
        $this->data['product'] = $this->product;
        $this->data['images'] = Shop_model::factory()->images($productID);
        $this->data['description'] = ShopDescription_model::factory()->findOne(['shop_id' => $productID]);
        //dd($this->data['description']);
        attach('assets/css/elastislide.css', 'css');
        //attach('assets/js/modernizr.custom.17475.js', 'js');
        //attach('assets/js/jquery.elastislide.js', 'js');
        render('view',$this->data);
    }
}