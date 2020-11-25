<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends AppController {

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

    public function __construct()
    {
        parent::__construct();
        $this->template->set_template('layout/app');
        $this->paypal = new Paypal();
        //$this->paypal->setApiContext($this->config->item('CLIENT_ID'),$this->config->item('CLIENT_SECRET'));
        $this->settings = Settings_model::factory()->find()->get()->row_array();
        $this->meta     = SettingsMetaData_model::factory()->find()->get()->row_array();


        $this->setSession('settings', $this->settings);
        $this->setSession('meta', $this->meta);
        if($this->settings) {
            $this->setSession('currency', $this->currency->getCurrency(SettingsCurrencyConfiguration_model::factory()->getCurrency($this->settings['id'])));
        }

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
    private function formatProductModelInstanceToArray($productModelInstance, $limit = null, $var = null) {
        if($limit) $this->limit = $limit;
        if($var) $this->var = $var;
        if($productModelInstance) $this->productModelInstances = $productModelInstance;

        if($this->productModelInstances) {
            foreach ($this->productModelInstances as $productModelInstance) {
                if (is_file(DIR_IMAGE . $productModelInstance->product->images->image)) {
                    $this->image = $this->resize($productModelInstance->product->images->image, 255, 325);
                } else {
                    $this->image = $this->resize('no_image.png', 255, 325);
                }
               // dd($productModelInstance->product->categoryToProduct->category);
                if($productModelInstance->product->status) {
                    $video = 'https://www.youtube.com';
                    if($productModelInstance->product->videos) {
                        $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=)([^&]{11})~x';
                        $has_match = preg_match($rx, $productModelInstance->product->videos->url, $matches);
                        if($has_match) {
                            $video = $productModelInstance->product->videos->url;
                        } else {
                            $extractUrl = explode('https://youtu.be/',$productModelInstance->product->videos->url);
                            $video = 'https://www.youtube.com/watch?v='.$extractUrl[1];
                        }
                    }

                    $this->data[$this->var][] = array(
                        'id' => $productModelInstance->product->id,
                        'name' => $productModelInstance->product->name,
                        'slug' => $productModelInstance->product->slug,
                        'description' => ($productModelInstance->product->description) ? $productModelInstance->product->description->description : "",
                        'img' => $this->image,
                        'video' => ($video) ? $video : "",
                        'pdf' => ($productModelInstance->product->pdf) ? $productModelInstance->product->pdf->pdf : "",
                        'quiz' => ($productModelInstance->product->quiz) ? base_url('quiz/' . $productModelInstance->product->quiz->slug) : "",
                        'category' => array(
                            'name' => $productModelInstance->product->categoryToProduct->category->name,
                            'description' => $productModelInstance->product->categoryToProduct->category->description->description
                        )
                    );
                }
            }
        }
    }

    /**
     * @param null $limit
     * @param null $orderBy
     * @throws Exception
     */
    private function getCategoryArray($limit = null, $orderBy = null) {
        if($limit) $this->limit = $limit;
        if($orderBy) $this->orderBy = $orderBy;
        $categories = Category_model::factory()->findAll([],$limit,$this->orderBy);
        //$this->dd($categories);
        if($categories) {
            foreach ($categories as $category) {
                //$this->dd($category);
                if (is_file(DIR_IMAGE . $category->description->image)) {
                    $this->image = $this->resize($category->description->image, 534, 205);
                } else {
                    $this->image = $this->resize('no_image.png', 534, 205);
                }

                $this->data['categories'][] = array(
                    'id'    => $category->id,
                    'name'  => $category->name,
                    'slug'  => $category->slug,
                    'img'   => $this->image,
                );
            }
        }
    }

    public function getTooltips($countryId) {
        $description = CountryDescription_model::factory()->findOne(['country_id' => $countryId]);
        $descriptionBlogs = array();
        if($description) {
            $descriptionBlogs = CountryDescriptionBlog_model::factory()->findAll(['country_descriptions_id ' => $description->id]);
        }
        $data = array();
        if($descriptionBlogs) {
            foreach ($descriptionBlogs as $blog) {
                $data[] = '<span style=\'color:#2badd9;\'>'.$blog->title.'</span><br>';
            }
        }

        if($data) {
            return $data;
        }
        return false;
    }
    /**
     * Home page features products and activity books
     * @throws Exception
     */
    public function index() {
        $this->getCategoryArray(4, 'sort_order');
        // Features Product
        $this->formatProductModelInstanceToArray(FeaturesProduct_model::factory()->findAll(),4);
        // Activity Books
        $this->formatProductModelInstanceToArray(FeaturesProduct_model::factory()->findAll(['activity_book' => 'YES']),4, 'activityBooks');

        $maps = Map_model::factory()->findAll(['status' => 1]);
        $this->data['maps'] = array();

        foreach ($maps as $map) {
            $this->data['maps'][] = array(
                'countryId'         => $map->country_id,
                'd'                 => (isset($map->path_d)) ? $map->path_d : '',
                'countryName'       => (isset($map->country->name)) ? $map->country->name : '',
                'countryIsoCode2'   => (isset($map->country->iso_code_2)) ? $map->country->iso_code_2 : '',
                'tooltip'           => ($this->getTooltips($map->country_id)) ? implode('',$this->getTooltips($map->country_id)): 'learning module not available'
            );
        }

        // Set the meta
        //$this->dd($this->meta);
        $this->template->title->set($this->meta['meta_title']);
        $this->template->meta->add('title', $this->meta['meta_title']);
        $this->template->meta->add('keywords', $this->meta['meta_keywords']);
        $this->template->meta->add('description', $this->meta['meta_description']);

        $this->template->stylesheet->add('assets/css/magnific-popup.min.css');
        $this->template->javascript->add('assets/js/jquery.magnific-popup.min.js');
		$this->template->content->view('index', $this->data);
		$this->template->publish();
	}
    /**
     * Home page features products and activity books
     * @throws Exception
     */
    public function index2() {


        $this->getCategoryArray(4, 'sort_order');
        // Features Product
        $this->formatProductModelInstanceToArray(FeaturesProduct_model::factory()->findAll(),4);
        // Activity Books
        //$this->formatProductModelInstanceToArray(FeaturesProduct_model::factory()->findAll(),4, 'activityBooks');
        //dd($this->data['activityBooks']);
        $this->data['maps'] = Map_model::factory()->findAll(['status' => 1]);
        //dd($this->data['maps']);
        $this->template->stylesheet->add('assets/css/magnific-popup.min.css');
        $this->template->javascript->add('assets/js/jquery.magnific-popup.min.js');
        $this->template->content->view('static', $this->data);
        $this->template->publish();
    }

    /**
     * List of all product category
     */
    public function category() {
        $this->getCategoryArray(null,'sort_order');
        $this->template->content->view('category/index', $this->data);
        $this->template->publish();
    }
    /**
     * @param $categorySlug
     */
    public function products($categorySlug) {
       // if(!$this->isSubscribed()) redirect('viewplans');

        if($categorySlug) $this->categorySlug = $categorySlug;
        if($this->categorySlug) $this->category = Category_model::factory()->findOne(['slug' => $this->categorySlug,'status' => 1]);

       // dd($this->category);
        if(!$this->category) {
            redirect('status/404/');
        }
        $this->data['category'] = array();
        if($this->category) {
            $this->categoryToProducts   = $this->category->products;
            $this->data['category'] = array(
                'name'        => $this->category->name,
                'description' => $this->category->description->description
            );
        }

        $this->formatProductModelInstanceToArray($this->categoryToProducts);

        // Set the meta
        $this->template->title->set($this->category->description->meta_title);
        $this->template->meta->add('title', $this->category->description->meta_title);
        $this->template->meta->add('keywords', $this->category->description->meta_keyword);
        $this->template->meta->add('description', $this->category->description->meta_description);

        $this->template->stylesheet->add('assets/css/magnific-popup.min.css');
        $this->template->javascript->add('assets/js/jquery.magnific-popup.min.js');
        $this->template->content->view('product/index', $this->data);
        $this->template->publish();
    }
    /*
    public function product($slug) {
        $this->product = Product_model::factory()->findOne(['slug' => $slug,'status' => 1]);
        if(!$this->product) {
            redirect('status/404/');
        }
        $this->formatProductModelInstanceToArray($this->product);
        // Set the meta
        $this->template->title->set($this->category->description->meta_title);
        $this->template->meta->add('title', $this->category->description->meta_title);
        $this->template->meta->add('keywords', $this->category->description->meta_keyword);
        $this->template->meta->add('description', $this->category->description->meta_description);

        $this->template->stylesheet->add('assets/css/magnific-popup.min.css');
        $this->template->javascript->add('assets/js/jquery.magnific-popup.min.js');
        $this->template->content->view('product/view', $this->data);
        $this->template->publish();
    }
    */
    /**
     * splash screen
     * @return mixed
     */
	public function setSplashScreen() {
        if($this->isAjaxRequest() && $this->isPost()) {
            $this->setSession('splashscreen',1);
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array('status' => true)));
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode(array('status' => false)));
    }
    /**
     * View Plans
     */
    public function viewPlans() {
        if($this->isSubscribed()) redirect('subscribed');

        $this->data['plans'] = Membershipplan_model::factory()->findAll(['state' => 'ACTIVE']);
        $this->template->content->view('plans/index', $this->data);
        $this->template->publish();
    }
    /**
     * View Plans
     */
    public function subscribed() {

        //if(!$this->isSubscribed()) redirect('viewplans');
        $this->subscriber = Subscriber_model::factory()->findOne(['user_id' => userId()]);
        $this->data['plan'] = array();
        $this->data['subscriber'] = array();
        if($this->subscriber) {
            $today = time();
            $daysLeft = floor((strtotime($this->subscriber->end_at)-$today)/(60*60*24));
            $this->data['plan'] = array(
                'name' => $this->subscriber->plan,
                'price' => currencyFormat($this->subscriber->price, getSession('currency')['code']),
                'end_at' => $this->subscriber->end_at,
                'daysLeft' => $daysLeft,
            );
            $this->data['subscriber'] = array(
                'name' => $this->subscriber->user->firstname. " " .$this->subscriber->user->lastname,
                'email' => $this->subscriber->user->email,
            );
        }

        $this->template->content->view('plans/subscribed', $this->data);
        $this->template->publish();
    }

    /**
     * View Plan
     * @param $slug
     */
    public function account($slug) {

        if($slug) $this->slug = $slug;

        $this->plan = Membershipplan_model::factory()->findOne(['slug' => $this->slug]);

        if(!$this->plan) {
            redirect('viewplans');
        }
        if($this->plan) {
            $this->data['plan'] = $this->plan;
        }
        if ($this->user->isLogged()) {
            redirect('plan/billing/'.$this->plan->slug);
        }
        if($this->isPost()) {
            $this->planId     = ($this->input->post('planId')) ? $this->input->post('planId') : '';

            User_model::factory()->addUser($this->input->post());
            // Clear any previous login attempts for unregistered accounts.
            User_model::factory()->deleteLoginAttempts($this->input->post('email'));
            // Login
            User_model::factory()->login($this->input->post('email'), $this->input->post('password'));
            redirect('plan/'.$this->plan->slug.'/billing');
        }
        //$this->dd($this->data);
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/plans/Account.js');
        $this->template->content->view('plans/account', $this->data);
        $this->template->publish();
    }
    /**
     * View Plan
     * @param $slug
     */
    public function createAccount() {

        $this->slug     = ($this->input->post('slug')) ? $this->input->post('slug') : '';

        $this->plan = Membershipplan_model::factory()->findOne(['slug' => $this->slug]);

        if(!$this->plan) {
            $this->json['redirect'] 		= url('viewplans');;
        }
        if($this->plan) {
            $this->data['plan'] = $this->plan;
        }

        $this->lang->load('app/emails/register_lang');
        $this->lang->load('app/register_lang');

        if (User_model::factory()->getTotalUsersByEmail($this->input->post('email'))) {
            $this->json['error']['warning'] = $this->lang->line('error_exists');
        }
        if($this->isPost() ) {
            if (!$this->json) {
                User_model::factory()->addUser($this->input->post());
                // Clear any previous login attempts for unregistered accounts.
                User_model::factory()->deleteLoginAttempts($this->input->post('email'));
                // Login
                $this->user->login($this->input->post('email'), $this->input->post('password'));
                /*
                $subject 						= sprintf($this->lang->line('text_subject'), "SCUBA JACK");

                $this->data['text_welcome'] 	= sprintf($this->lang->line('text_welcome'), "SCUBA JACK");

                $this->data['text_email'] 		= sprintf($this->lang->line('text_email'), $this->input->post('email'));
                $this->data['text_password'] 	= sprintf($this->lang->line('text_password'), $this->input->post('password'));

                $this->data['text_app_name'] 	= "SCUBA JACK";
                $this->data['text_service'] 	= $this->lang->line('text_service');
                $this->data['text_thanks'] 		= $this->lang->line('text_thanks');

                $mail 							= new Mail($this->config->item('config_mail_engine'));
                $mail->parameter 				= $this->config->item('config_mail_parameter');
                $mail->smtp_hostname 			= $this->config->item('config_mail_smtp_hostname');
                $mail->smtp_username 			= $this->config->item('config_mail_smtp_username');
                $mail->smtp_password 			= html_entity_decode($this->config->item('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                $mail->smtp_port 				= $this->config->item('config_mail_smtp_port');
                $mail->smtp_timeout 			= $this->config->item('config_mail_smtp_timeout');

                $mail->setTo($this->input->post('email'));
                $mail->setFrom($this->config->item('config_email'));
                $mail->setSender($this->config->item('config_sender_name'));
                $mail->setSubject($subject);
                $mail->setText($this->template->content->view('emails/registration', $this->data));
                $mail->send();
                */
                $this->json['success'] = $this->lang->line('text_success');
                $this->json['redirect'] = url('plan/billing/' . $this->plan->slug);

            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }
    }

    /**
     * Billing
     * @param $slug
     */
    public function billing($slug) {

        if($slug) $this->slug = $slug;

        $this->plan = Membershipplan_model::factory()->findOne(['slug' => $this->slug]);

        if($this->plan) {
            $this->data['plan'] = $this->plan;
        }
        $this->template->javascript->add('assets/js/plans/PayPal.js');
        $this->template->content->view('plans/billing', $this->data);
        $this->template->publish();
    }

    /**
     * @return object
     */
    public function setSubscriptionPlan() {
        $this->slug     = ($this->input->post('slug')) ? $this->input->post('slug') : '';
        $this->plan     = Membershipplan_model::factory()->findOne(['slug' => $this->slug]);
        if($this->plan) return $this->plan;
    }

    /**
     * @return mixed
     */
    public function processToPayPal() {
        if($this->isPost() && $this->isAjaxRequest()) {
            try {
                $planId     = ($this->input->post('planId')) ? $this->input->post('planId') : '';
                if($planId) {
                    $this->plan = Membershipplan_model::factory()->findOne(['paypal_plan_id' => $planId]);
                }
                if($this->plan) {
                    // Set Plan Id
                    $this->paypal
                        ->setPlanId($this->plan->paypal_plan_id)
                        ->setPlanName($this->plan->name)
                        ->setPlanDescription($this->plan->name);
                    // Adding shipping details
                    $this->paypal->shippingAddress
                        ->setLine1('111 First Street')
                        ->setCity('Saratoga')
                        ->setPostalCode('CA')
                        ->setState('95070')
                        ->setCountryCode('US');

                    $this->paypal->agreement();
                    $this->setSession('membership_plan_id', $this->plan->id);
                    $this->json['success'] = true;
                    $this->json['redirect'] = $this->paypal->getApprovalLink();
                    
                    return $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(200)
                        ->set_output(json_encode($this->json));
                }
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                $this->json['code'] = $ex->getCode();
                $this->json['data'] = $ex->getData();
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode($this->json));
            } catch (Exception $ex) {
                die($ex);
            }
        }
    }

    /**
     *
     */
    public function subscribeReturnUrl() {
        if (!empty($this->input->get('payment'))) {
            $decodePayment = urlDecode($this->input->get('payment'));
            if($decodePayment) {
                $token = $this->input->get('token');
                try {
                    // Execute agreement
                    if($this->getSession('membership_plan_id')) {
                        $this->plan = Membershipplan_model::factory()->findOne($this->getSession('membership_plan_id'));
                    }
                    //$this->dd($this->plan);
                    if($this->plan) {
                        $this->expiration       = $this->plan->duration;
                        $this->signUpTimestamp  = ($this->getSession('user')) ? strtotime($this->getSession('user')['created_at']) : '';
                        $this->expirationDate   = $this->signUpTimestamp + ($this->expiration*24*60*60);

                    }
                    $this->paypal->agreement->execute($token, $this->paypal->getApiContext());
                    Subscriber_model::factory()->insert([
                        'user_id'        => userId(),
                        'membership_plan_id'        => $this->getSession('membership_plan_id'),
                        'type'      => $this->paypal->agreement->getPlan()->getPaymentDefinitions()[0]->getFrequency(),
                        'plan'           => $this->paypal->agreement->getDescription(),
                        'price'          => $this->paypal->agreement->getPlan()->getPaymentDefinitions()[0]->getAmount()->getValue(),
                        'beg_date'     => $this->paypal->agreement->getStartDate(),
                        'end_at'       => date('Y-m-d H:i:s', $this->expirationDate),
                    ]);
                    Agreement_model::factory()->insert([
                        'membership_plans_subscribers_id' => Subscriber_model::factory()->getLastInsertID(),
                        'agreement_id'        => $this->paypal->getAgreement()->getId(),
                        'description'       => $this->paypal->getAgreement()->getDescription(),
                        'state'           => $this->paypal->getAgreement()->getState(),
                        'start_date'          => $this->paypal->getAgreement()->getStartDate(),
                        'payment_method'     => $this->paypal->agreement->getPayer()->getPaymentMethod(),
                        'status'       => $this->paypal->agreement->getPayer()->getStatus(),
                    ]);
                    $this->unsetSession('membership_plan_id');
                    $this->setSession('subscribe', true);
                    redirect('success');

                } catch (PayPal\Exception\PayPalConnectionException $ex) {
                    echo $ex->getCode();
                    echo $ex->getData();
                    die($ex);
                } catch (Exception $ex) {
                    die($ex);
                }
            } else {
                $this->setSession('subscribe', false);
                redirect('failure');
            }
            exit;
        }
    }
    public function failure() {
        $this->template->content->view('plans/failure');
        $this->template->publish();
    }
    public function success() {
        $this->template->content->view('plans/success');
        $this->template->publish();
    }
    /**
     * Membership plan subscribe
     */
    public function explore() {
        $this->isoCode = ($this->uri->segment(1)) ? $this->uri->segment(1) : "";
        if($this->isoCode) {
            $this->country = Country_model::factory()->getCountryByIsoCode($this->isoCode);
        }
        $this->data['country'] = true;
        $this->data['message'] = '';
        if(!$this->country) {
            $this->data['country'] = false;
            $this->data['message'] = 'Country not exists!';
        }
        $this->data['isContent'] = false;
        if($this->country) {
            $this->countryDescription = CountryDescription_model::factory()->findOne(['country_id' => $this->country->id]);
        }

        if($this->countryDescription) {
            $this->data['isContent'] = true;
            $this->data['countryDescription'] = $this->countryDescription;
            $this->getAllBlogOrWithLimit($this->countryDescription->blogs,3);
        } else {
            $this->data['countryDescription'] = array();
        }
        //$this->dd($this->data);
        $this->template->content->view('explore/index', $this->data);
        $this->template->publish();
    }
    /*
     *
     */
    public function blog($iso, $slug) {
        if($iso) {
            $this->country = Country_model::factory()->getCountryByIsoCode($iso);
        }
        if(!$this->country) {
            redirect('/');
        }

        if($slug) {
            $this->blog = CountryDescriptionBlog_model::factory()->findOne(['slug' => $slug]);
        }
        if(!$this->blog) {
            $this->redirect($iso.'/explore');
        }
        $this->data['blog'] = array();

        if($this->blog) {
            $this->data['blog'] = array(
                'title'             => $this->blog->title,
                'smallDescription'  => $this->blog->small_description,
                'description'       => $this->blog->description,
                'image'             => $this->blog->image,
            );
            $this->blogImages = $this->blog->images($this->blog->id);
        }

        $this->data['blogImages'] = array();
        $this->data['blogVideos'] = array();

        if($this->blogImages) {
            $this->data['blogImages'] = $this->blogImages;
            $this->data['blogVideos'] = $this->blogImages;
        }

        //$this->dd($this->data);

        $this->template->content->view('explore/blog', $this->data);
        $this->template->publish();
    }

    /**
     * @param $blogs
     * @param int $limit
     * @param bool $all
     */
    public function getAllBlogOrWithLimit($blogs, $limit = 6, $all = false) {
        if($blogs) {
            if($all) {
                foreach ($blogs as $blog) {
                    $this->data['blogs'][] = array(
                        'title'         => $blog->title,
                        'slug'          => base_url($this->uri->segment(1).'/explore/'.$blog->slug),
                        'description'   => $blog->description,
                        'smallDescription'   => $blog->small_description,
                        'image'         => resize($blog->image,497,297),
                    );
                }
            } else {
                    foreach (array_slice($blogs,0, $limit) as $blog) {
                        $this->data['blogs'][] = array(
                            'title'         => $blog->title,
                            'slug'          => base_url($this->uri->segment(1).'/explore/'.$blog->slug),
                            'smallDescription'   => $blog->small_description,
                            'description'   => $blog->description,
                            'image'         => resize($blog->image,497,297),
                        );
                    }

            }

        } else {
            $this->data['blogs'] = array();
        }
    }

    /**
     * @return mixed
     */
    public function checkLogin() {
        if($this->isAjaxRequest() && $this->isPost()) {
            $this->subscriberId   = ($this->input->post('subscriberId')) ? $this->input->post('subscriberId') : '';
            if($this->subscriberId) {
                $this->subscriber     = Subscriber_model::factory()->findOne(['user_id' => $this->subscriberId]);
            }
            if($this->subscriber) {
                $this->json['success']  = true;
            } else {
                $this->json['success']  = false;
                $this->json['redirect']  = site_url('viewplans');
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }

    }
    /**
     * Membership plan subscribe
     */
    public function about() {
        $this->data['information'] = array();
        $this->information = Information_model::factory()->findOne(1);
        if($this->information) {
            $this->data['information'] = $this->information;
        }
        // Set the meta
        $this->template->title->set($this->information->meta_title);
        $this->template->meta->add('title', $this->information->meta_title);
        $this->template->meta->add('keywords', $this->information->meta_keyword);
        $this->template->meta->add('description', $this->information->meta_description);

        $this->template->content->view('information/about', $this->data);
        $this->template->publish();
    }

    /**
     * Contact Page
     * @throws Exception
     */
    public function contact() {
        $this->lang->load('app/register_lang');
        if($this->isAjaxRequest() && $this->isPost()) {
            $this->request = $this->xss_clean($this->input->post());
            if ((strlen(trim($this->request['firstname'])) < 1) || (strlen(trim($this->request['firstname'])) > 32)) {
                $this->json['error']['firstname'] = $this->lang->line('error_firstname');
            }

            if ((strlen(trim($this->request['lastname'])) < 1) || (strlen(trim($this->request['lastname'])) > 32)) {
                $this->json['error']['lastname'] = $this->lang->line('error_lastname');
            }

            if ((strlen($this->request['email']) > 96) || !filter_var($this->request['email'], FILTER_VALIDATE_EMAIL)) {
                $this->json['error']['email'] = $this->lang->line('error_email');
            }
            if ((strlen($this->request['website']) > 96) || !filter_var($this->request['website'], FILTER_VALIDATE_URL)) {
                $this->json['error']['website'] = $this->lang->line('error_website');
            }

            if ((strlen(trim($this->request['message'])) < 1) || (strlen(trim($this->request['message'])) > 1000)) {
                $this->json['error']['message'] = $this->lang->line('error_firstname');
            }

            if (!$this->json) {
                // Sent mail to user
                try {
                    $subject 						= sprintf('contact page submission');

                    $mail 							= new Mail($this->config->item('config_mail_engine'));
                    $mail->parameter 				= $this->config->item('config_mail_parameter');
                    $mail->smtp_hostname 			= $this->config->item('config_mail_smtp_hostname');
                    $mail->smtp_username 			= $this->config->item('config_mail_smtp_username');
                    $mail->smtp_password 			= html_entity_decode($this->config->item('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                    $mail->smtp_port 				= $this->config->item('config_mail_smtp_port');
                    $mail->smtp_timeout 			= $this->config->item('config_mail_smtp_timeout');

                    $mail->setTo($this->config->item('config_email'));
                    $mail->setFrom($this->config->item('config_email'));
                    $mail->setReplyTo($this->request['email']);
                    $mail->setSender($this->config->item('config_sender_name'));
                    $mail->setSubject($subject);
                    $mail->setHtml($this->template->content->view('emails/contact/contact', $this->request));
                    $mail->send();
//
//                    $mail->setTo($this->request['email']);
//                    $mail->setFrom($this->config->item('config_email'));
//                    $mail->setReplyTo('noreply@siswork.com', $this->config->item('config_sender_name'));
//                    $mail->setSender($this->config->item('config_sender_name'));
//                    $mail->setSubject($subject);
//                    $mail->setHtml($this->template->content->view('emails/contact/reply', $this->data));
//                    $mail->send();
                  
                    $this->json['success']          = 'Thanks for submitting contact us form';
                    $this->json['redirect'] 		= url('/');
                } catch (Exception $e) {
                    dd($e->getMessage());
                }
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }
        // Set the meta
        $this->template->title->set('Contact');
        $this->template->meta->add('title', 'Contact');
        $this->template->meta->add('keywords', 'Contact us for Educational DVD&#039;s for Kids, worksheets for kids, worksheets for Kindergarten, Kindergarten and Preschool activities, Worksheets for Kids.');
        $this->template->meta->add('description', 'Contact us for Educational DVD&#039;s for Kids, worksheets for kids, worksheets for Kindergarten, Kindergarten and Preschool activities, Worksheets for Kids.');


        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/contact/Contact.js');
        $this->template->content->view('information/contact');
        $this->template->publish();
    }

    /**
     * @return mixed
     */
    public function stampToPassport() {
        if($this->isPost()) {
           // dd($this->settings);
            $this->countryIso   = ($this->input->post('countryIso')) ? strtolower($this->input->post('countryIso')) : "";
            $this->userId        = ($this->input->post('userId')) ? $this->input->post('userId') : "";

            if($this->countryIso) {
                $this->country = Country_model::factory()->getCountryByIsoCode($this->countryIso);
            }

            if($this->country) {
                $this->passport = UserPassport_model::factory()->findOne([
                    'user_id'       => $this->userId,
                    'country_id' => $this->country->id
                ]);
                $pointData = [
                    'country_id' => $this->country->id,
                    'user_id'       => $this->userId,
                    'points'        => $this->settings['point'],
                ];
                if($this->passport) {
                    UserPassport_model::factory()->update([
                        'updated_at'    => date('Y-m-d H:i:s', time())
                    ],[
                        'user_id'       => $this->userId,
                        'country_id'    => $this->country->id
                    ]);
                    UserPoint_model::factory()->delete(['country_id' => $this->country->id, 'user_id' => $this->userId], true);
                    $this->postGems($pointData);
                } else {
                    UserPassport_model::factory()->insert([
                        'user_id'       => $this->userId,
                        'country_id'    => $this->country->id,
                    ]);
                    $this->postGems($pointData);
                }
                $this->json['success']  = true;
                $this->json['redirect']  = base_url($this->countryIso.'/explore');
            } else {
                $this->json['success']  = false;
                $this->json['redirect']  = base_url($this->countryIso.'/explore');
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }
    }

    /**
     * @param array $data
     */
    public function postGems($data = array()) {
        //$this->dd($data);
        UserPoint_model::factory()->insert([
            'country_id'    => $data['country_id'],
            'user_id'       => $data['user_id'],
            'points'        => $data['points'],
        ]);
    }
    public function fetchQuizData($id) {
        $questions = Question_model::factory()->findAll(['quiz_id' => $id],5,'RAND()');
        foreach ($questions as $question) {
            if(isset($question)) {
                $this->json[] = array(
                    'id'                => $question->id,
                    'q'                 => $question->question,
                    'img'               => (isset($question->image)) ? resize($question->image,200,200) : resize('no_image.png',200,200),
                    'options'           => $question->answers(),
                    'correctIndex'      => (Answer_model::factory()->find()->where('is_correct',1)->where('question_id', $question->id)->select('correct_index')->get()->row_array()) ? (int)Answer_model::factory()->find()->where('is_correct',1)->where('question_id', $question->id)->select('correct_index')->get()->row_array()['correct_index'] : null,
                    'answerId'          => (Answer_model::factory()->find()->where('is_correct',1)->where('question_id', $question->id)->select('id')->get()->row_array()) ? (int)Answer_model::factory()->find()->where('is_correct',1)->where('question_id', $question->id)->select('id')->get()->row_array()['id'] : null,
                    'correctResponse'   => 'Good job, that was obvious.',
                    'incorrectResponse' =>  'Well, if you don\'t include it, your quiz won\'t work',
                );
            }
        }
       if($this->json) {
           return $this->output
               ->set_content_type('application/json')
               ->set_status_header(200)
               ->set_output(json_encode($this->json));
       }

    }
    /**
     * @param $quizSlug
     */
    public function quiz($quizSlug) {
        $quiz = Quiz_model::factory()->findOne(['slug' => $quizSlug]);
        if(!$quiz) {
            redirect('404');
        }
        if(!isSubscribe()) {
            redirect('404');
        }
        $this->data['quiz'] = array();
        $this->data['quiz'] = $quiz;
        $this->template->content->view('quiz/index', $this->data);
        $this->template->publish();
    }
    /**
     * @return mixed
     */
    public function userGivenAnswer() {
        if($this->isPost() && $this->isAjaxRequest()) {
            $question   = ($this->input->post('question')) ? strtolower($this->input->post('question')) : "";
            $answer     = ($this->input->post('answer')) ? $this->input->post('answer') : "";

            UserQuestionAnswer_model::factory()->insert([
                'user_id'       => userId(),
                'question_id'   => $question,
                'answer_id'     => $answer,
            ]);
            $this->json['success']  = true;
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }

    }

    /**
     * @return mixed
     */
    public function finishCallback() {
        if($this->isPost() && $this->isAjaxRequest()) {
            $quiz          = ($this->input->post('quiz')) ? strtolower($this->input->post('quiz')) : "";
            $score         = ($this->input->post('score')) ? $this->input->post('score') : "";
            $numQuestions  = ($this->input->post('numQuestions')) ? $this->input->post('numQuestions') : "";

            UserQuizScore_model::factory()->insert([
                'user_id'           => userId(),
                'quiz'              => $quiz,
                'score'             => $score,
                'num_questions'     => $numQuestions,
            ]);
            $this->json['success']  = true;
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));
        }

    }


    public function worksheets() {
        $worksheets = Worksheet_model::factory()->findAll([],null,'sort_order');
        $this->data['worksheets'] = array();
        if($worksheets) {
            foreach ($worksheets as $worksheet) {
                $this->data['worksheets'][] = array(
                    'title'     => $worksheet->title,
                    'sheets'    => $worksheet->worksheets($worksheet->id)
                );
            }
        }
        //$this->dd($this->data);
        $this->template->content->view('worksheets/index', $this->data);
        $this->template->publish();
    }

    public function quizData() {
        //Quiz_model::factory()->
    }

    public function search() {

        if($this->input->get('q')) {
            $q = $this->input->get('q');
        } else {
            $q = '';
        }

        $json = Product_model::factory()->search(['q' => $q]);
        if($json) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($json));
        }
    }


    public function store() {
        echo 1;
        render('store/index');
    }
}