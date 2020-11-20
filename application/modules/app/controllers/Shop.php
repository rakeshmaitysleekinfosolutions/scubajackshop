<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends AppController {

    private $limit;
    private $categorySlug;
    /**
     * @var object
     */
    private $categoryId;
    /**
     * @var array|int
     */
    private $categoryToProducts;
    /**
     * @var object
     */
    private $category;
    private $productModelInstances;
    private $products;
    private $var = 'products';
    private $orderBy;
    /**
     * @var object
     */
    private $plan;
    private $slug;
    /**
     * @var Paypal
     */
    private $paypal;
    /**
     * @var object
     */
    private $subscriber;
    private $expiration;
    /**
     * @var float|int
     */
    private $expirationDate;
    /**
     * @var string
     */
    private $signUpTimestamp;
    /**
     * @var string
     */
    private $subscriberId;
    /**
     * @var object|null
     */
    private $country;
    /**
     * @var string
     */
    private $isoCode;
    /**
     * @var string
     */
    private $userId;
    /**
     * @var string
     */
    private $countryIso;
    /**
     * @var object
     */
    private $mapContinent;
    /**
     * @var object
     */
    private $passport;
    /**
     * @var object
     */
    private $countryDescription;
    /**
     * @var object
     */
    private $blog;
    private $blogImages;
    /**
     * @var string
     */
    private $settings = array();
    /**
     * @var object
     */
    private $information;
    /**
     * @var string
     */
    private $meta;
    private $currencyArray;

    public function __construct()
    {
        parent::__construct();
        $this->template->set_template('layout/app');
        $this->paypal = new Paypal();
        //$this->paypal->setApiContext($this->config->item('CLIENT_ID'),$this->config->item('CLIENT_SECRET'));
        $this->settings         = Settings_model::factory()->find()->get()->row_array();
        $this->meta             = SettingsMetaData_model::factory()->find()->get()->row_array();
        $this->currencyArray    = $this->currency->getCurrency(SettingsCurrencyConfiguration_model::factory()->getCurrency($this->settings['id']));

        // Set Session Data
        $this->setSession('settings', $this->settings);
        $this->setSession('meta', $this->meta);
        $this->setSession('currency', $this->currencyArray);
    }

    /**
     * @var object
     */
    private $categoryDescription;
    /**
     * @var string|void
     */
    private $image;
    /**
     * @var object
     */
    private $product;
    /**
     * @var array|object[]
     */
    private $featuresProduct;
    /**
     * @var object
     */
    private $productPdfs;
    /**
     * @var object
     */
    private $productImages;
    /**
     * @var object
     */
    private $productDescription;
    /**
     * @var object
     */
    private $productVideos;

    /**
     * @param $productModelInstance
     * @param null $limit
     * @param null $var
     */
    public function index()
    {
        echo 'there';
    }
    public function productList()
    {
        echo 'here';
    }
    public function viewProduct()
    {
        echo 'test';
    }
}