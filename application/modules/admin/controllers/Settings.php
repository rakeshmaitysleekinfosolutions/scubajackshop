<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;


class Settings extends AdminController {

    /**
     * @var string
     */
    private $action;
    /**
     * @var array|null
     */
    private $settings;
    /**
     * @var object|null
     */
    private $mail;
    /**
     * @var object|null
     */
    private $currencyModel;
    /**
     * @var object|null
     */
    private $meta;

    public function __construct() {
        parent::__construct();
        $this->template->set_template('layout/admin');
        //dd($_SESSION);
    }
    public function setData() {
        if (isset($this->settings)) {
            $this->data['id'] = $this->settings->id;
        } else {
            $this->data['id'] = '';
        }
        if (isset($this->settings)) {
            $this->data['action'] = 'edit';
        } else {
            $this->data['action'] = 'add';
        }
        if (!empty($this->input->post('company_name'))) {
            $this->data['company_name'] = $this->input->post('company_name');
        } elseif (!empty($this->settings)) {
            $this->data['company_name'] = $this->settings->company_name;
        }else {
            $this->data['company_name'] = '';
        }
        if (!empty($this->input->post('contact_person'))) {
            $this->data['contact_person'] = $this->input->post('contact_person');
        } elseif (!empty($this->settings)) {
            $this->data['contact_person'] = $this->settings->contact_person;
        } else {
            $this->data['contact_person'] = '';
        }
        if (!empty($this->input->post('address_1'))) {
            $this->data['address_1'] = $this->input->post('address_1');
        } elseif (!empty($this->settings)) {
            $this->data['address_1'] = $this->settings->address_1;
        } else {
            $this->data['address_1'] = '';
        }
        if (!empty($this->input->post('address_2'))) {
            $this->data['address_2'] = $this->input->post('address_2');
        } elseif (!empty($this->settings)) {
            $this->data['address_2'] = $this->settings->address_2;
        } else {
            $this->data['address_2'] = '';
        }
        if (!empty($this->input->post('country_id'))) {
            $this->data['country_id'] = $this->input->post('country_id');
        } elseif (!empty($this->settings)) {
            $this->data['country_id'] = $this->settings->country_id;
        } else {
            $this->data['country_id'] = '';
        }
        if (!empty($this->input->post('state_id'))) {
            $this->data['state_id'] = $this->input->post('state_id');
        } elseif (!empty($this->settings)) {
            $this->data['state_id'] = $this->settings->state_id;
        } else {
            $this->data['state_id'] = '';
        }
        if (!empty($this->input->post('city'))) {
            $this->data['city'] = $this->input->post('city');
        } elseif (!empty($this->settings)) {
            $this->data['city'] = $this->settings->city;
        } else {
            $this->data['city'] = '';
        }
        if (!empty($this->input->post('postal_code'))) {
            $this->data['postal_code'] = $this->input->post('postal_code');
        } elseif (!empty($this->settings)) {
            $this->data['postal_code'] = $this->settings->postal_code;
        } else {
            $this->data['postal_code'] = '';
        }
        if (!empty($this->input->post('email'))) {
            $this->data['email'] = $this->input->post('email');
        } elseif (!empty($this->settings)) {
            $this->data['email'] = $this->settings->email;
        } else {
            $this->data['email'] = '';
        }
        if (!empty($this->input->post('email_2'))) {
            $this->data['email_2'] = $this->input->post('email_2');
        } elseif (!empty($this->settings)) {
            $this->data['email_2'] = $this->settings->email_2;
        } else {
            $this->data['email_2'] = '';
        }
        if (!empty($this->input->post('phone_1'))) {
            $this->data['phone_1'] = $this->input->post('phone_1');
        } elseif (!empty($this->settings)) {
            $this->data['phone_1'] = $this->settings->phone_1;
        } else {
            $this->data['phone_1'] = '';
        }
        if (!empty($this->input->post('phone_2'))) {
            $this->data['phone_2'] = $this->input->post('phone_2');
        } elseif (!empty($this->settings)) {
            $this->data['phone_2'] = $this->settings->phone_2;
        } else {
            $this->data['phone_2'] = '';
        }

        if (!empty($this->input->post('point'))) {
            $this->data['point'] = $this->input->post('point');
        } elseif (!empty($this->settings)) {
            $this->data['point'] = $this->settings->point;
        } else {
            $this->data['point'] = '';
        }
        if (!empty($this->input->post('logo'))) {
            $this->data['logo'] = $this->input->post('logo');
        } elseif (!empty($this->settings)) {
            $this->data['logo'] = $this->settings->logo;
        } else {
            $this->data['logo'] = '';
        }
//        if (!empty($this->input->post('search_keywords'))) {
//            $this->data['search_keywords'] = $this->input->post('search_keywords');
//        } elseif (!empty($this->settings)) {
//            $this->data['search_keywords'] = $this->settings->search_keywords;
//        } else {
//            $this->data['search_keywords'] = '';
//        }

       /// dd($this->data);
        if (!empty($this->input->post('logo')) && is_file(DIR_IMAGE . $this->input->post('logo'))) {
            $this->data['thumb'] = $this->resize($this->input->post('logo'), 100, 100);
        } elseif (!empty($this->settings) && is_file(DIR_IMAGE . $this->settings->logo)) {
            $this->data['thumb'] = $this->resize($this->settings->logo, 100, 100);
        } else {
            $this->data['thumb'] = $this->resize('no_image.png', 100, 100);
        }

        if (!empty($this->input->post('protocol'))) {
            $this->data['protocol'] = $this->input->post('protocol');
        } elseif (!empty($this->mail)) {
            $this->data['protocol'] = $this->mail->protocol;
        } else {
            $this->data['protocol'] = '';
        }
        if (!empty($this->input->post('parameter'))) {
            $this->data['parameter'] = $this->input->post('parameter');
        } elseif (!empty($this->mail)) {
            $this->data['parameter'] = $this->mail->parameter;
        } else {
            $this->data['parameter'] = '';
        }
        if (!empty($this->input->post('smtp_hostname'))) {
            $this->data['smtp_hostname'] = $this->input->post('smtp_hostname');
        } elseif (!empty($this->mail)) {
            $this->data['smtp_hostname'] = $this->mail->smtp_hostname;
        } else {
            $this->data['smtp_hostname'] = '';
        }
        if (!empty($this->input->post('smtp_username'))) {
            $this->data['smtp_username'] = $this->input->post('smtp_username');
        } elseif (!empty($this->mail)) {
            $this->data['smtp_username'] = $this->mail->smtp_username;
        } else {
            $this->data['smtp_username'] = '';
        }
        if (!empty($this->input->post('smtp_password'))) {
            $this->data['smtp_password'] = $this->input->post('smtp_password');
        } elseif (!empty($this->mail)) {
            $this->data['smtp_password'] = $this->mail->smtp_password;
        } else {
            $this->data['smtp_password'] = '';
        }
        if (!empty($this->input->post('smtp_port'))) {
            $this->data['smtp_port'] = $this->input->post('smtp_port');
        } elseif (!empty($this->mail)) {
            $this->data['smtp_port'] = $this->mail->smtp_port;
        } else {
            $this->data['smtp_port'] = '';
        }
        if (!empty($this->input->post('smtp_timeout'))) {
            $this->data['smtp_timeout'] = $this->input->post('smtp_timeout');
        } elseif (!empty($this->mail)) {
            $this->data['smtp_timeout'] = $this->mail->smtp_timeout;
        } else {
            $this->data['smtp_timeout'] = '';
        }
        // Sender Email Address
        if (!empty($this->input->post('sender_email'))) {
            $this->data['sender_email'] = $this->input->post('sender_email');
        } elseif (!empty($this->mail)) {
            $this->data['sender_email'] = $this->mail->sender_email;
        } else {
            $this->data['sender_email'] = '';
        }
        // Sender Name
        if (!empty($this->input->post('sender_name'))) {
            $this->data['sender_name'] = $this->input->post('sender_name');
        } elseif (!empty($this->mail)) {
            $this->data['sender_name'] = $this->mail->sender_name;
        } else {
            $this->data['sender_name'] = '';
        }

        // currency
        if (!empty($this->input->post('currency'))) {
            $this->data['currency'] = $this->input->post('currency');
        } elseif (!empty($this->currencyModel)) {
            $this->data['currency'] = $this->currencyModel->currency;
        } else {
            $this->data['currency'] = '';
        }

        // Youtube URL
        if (!empty($this->input->post('youtubeUrl'))) {
            $this->data['youtubeUrl'] = $this->input->post('youtubeUrl');
        } elseif (!empty($this->settings)) {
            $this->data['youtubeUrl'] = $this->settings->video;
        } else {
            $this->data['youtubeUrl'] = '';
        }

        if (!empty($this->input->post('youtubeThumb'))) {
            $this->data['youtubeThumb'] = $this->input->post('youtubeThumb');
        } elseif (!empty($this->settings)) {
            $this->data['youtubeThumb'] = $this->settings->thumb;
        } else {
            $this->data['youtubeThumb'] = '';
        }
        // Meta Data
        if (!empty($this->input->post('meta_title'))) {
            $this->data['meta_title'] = $this->input->post('meta_title');
        } elseif (!empty($this->meta)) {
            $this->data['meta_title'] = $this->meta->meta_title;
        } else {
            $this->data['meta_title'] = '';
        }
        if (!empty($this->input->post('meta_keywords'))) {
            $this->data['meta_keywords'] = $this->input->post('meta_keywords');
        } elseif (!empty($this->meta)) {
            $this->data['meta_keywords'] = $this->meta->meta_keywords;
        } else {
            $this->data['meta_keywords'] = '';
        }
        if (!empty($this->input->post('meta_description'))) {
            $this->data['meta_description'] = $this->input->post('meta_description');
        } elseif (!empty($this->meta)) {
            $this->data['meta_description'] = $this->meta->meta_description;
        } else {
            $this->data['meta_description'] = '';
        }
        $this->data['placeholder']  = $this->resize('no_image.png', 100, 100);
        $this->data['countries']    = Country_model::factory()->findAll();
        $this->data['currencies']   = Currency_model::factory()->find()->get()->result_array();

    }
    public function index() {
        if($this->isPost()) {
            $this->action = ($this->input->post('action')) ? $this->input->post('action') : "";
            $this->id     = ($this->input->post('id')) ? $this->input->post('id') : "";

            switch ($this->action) {
                case 'add':
                    $this->setData();

                    Settings_model::factory()->insert([
                        'company_name'      => $this->data['company_name'],
                        'contact_person'    => $this->data['contact_person'],
                        'address_1'         => $this->data['address_1'],
                        'address_2'         => $this->data['address_2'],
                        'country_id '       => $this->data['country_id'],
                        'state_id '         => $this->data['state_id'],
                        'city'              => $this->data['city'],
                        'postal_code'       => $this->data['postal_code'],
                        'email'             => $this->data['email'],
                        'email_2'           => $this->data['email_2'],
                        'phone_1'           => $this->data['phone_1'],
                        'phone_2'           => $this->data['phone_2'],
                        'point'             => $this->data['point'],
                        'logo'              => $this->data['logo'],
                        'video'             => $this->data['youtubeUrl'],
                        'thumb'             => $this->data['youtubeThumb'],
                        //'search_keywords'   => $this->data['search_keywords'],
                    ]);
                    SettingsMailConfiguration_model::factory()->insert([
                        'settings_id'   => Settings_model::factory()->getLastInsertID(),
                        'protocol'      => $this->data['protocol'],
                        'parameter'     => $this->data['parameter'],
                        'smtp_hostname' => $this->data['smtp_hostname'],
                        'smtp_username' => $this->data['smtp_username'],
                        'smtp_password' => $this->data['smtp_password'],
                        'smtp_port'     => $this->data['smtp_port'],
                        'smtp_timeout'  => $this->data['smtp_timeout'],
                        'sender_email'  => $this->data['sender_email'],
                        'sender_name'   => $this->data['sender_name'],
                    ]);
                    SettingsMetaData_model::factory()->insert([
                        'settings_id'       => Settings_model::factory()->getLastInsertID(),
                        'meta_title'        => $this->data['meta_title'],
                        'meta_keywords'     => $this->data['meta_keywords'],
                        'meta_description'  => $this->data['meta_description'],
                    ]);
                    //dd($this->data);
                    Currency_model::factory()->refresh(true, $this->data['currency']);
                    SettingsCurrencyConfiguration_model::factory()->insert([
                        'settings_id'   => Settings_model::factory()->getLastInsertID(),
                        'currency'      => $this->data['currency'],
                    ]);

                    $output  = '<?php' . "\n";
                    $output .= '$config[\'config_mail_engine\']             = "'.$this->data["protocol"].'";'."\n";
                    $output .= '$config[\'config_mail_parameter\']          = "'.$this->data["parameter"].'";'."\n";
                    $output .= '$config[\'config_mail_smtp_hostname\']      = "'.$this->data["smtp_hostname"].'";'."\n";
                    $output .= '$config[\'config_mail_smtp_username\']      = "'.$this->data["smtp_username"].'";'."\n";
                    $output .= '$config[\'config_mail_smtp_password\']      = "'.$this->data["smtp_password"].'";'."\n";
                    $output .= '$config[\'config_mail_smtp_port\']          = "'.$this->data["smtp_port"].'";'."\n";
                    $output .= '$config[\'config_mail_smtp_timeout\']       = "'.$this->data["smtp_timeout"].'";'."\n";
                    $output .= '$config[\'config_email\']                   = "'.$this->data["sender_email"].'";'."\n";
                    $output .= '$config[\'config_sender_name\']             = "'.$this->data["sender_name"].'";'."\n";

                    $file = fopen(APPPATH . 'config/mail.php', 'w');
                    fwrite($file, $output);
                    fclose($file);

                    $this->setSession('settings', Settings_model::factory()->find()->get()->row_array());
                    $this->setSession('meta', SettingsMetaData_model::factory()->find()->get()->row_array());
                    //$this->setSession('settings.mail.config', SettingsMailConfiguration_model::factory()->find()->where('settings_id', $this->id)->get()->row_array());
                    $this->setSession('currency', $this->currency->getCurrency($this->data['currency']));
                    $this->setMessage('message', 'Settings has been successfully modified');
                case 'edit':
                    $this->setData();
                    //$this->dd($this->data['search_keywords']);
                    Settings_model::factory()->update([
                        'company_name'      => $this->data['company_name'],
                        'contact_person'    => $this->data['contact_person'],
                        'address_1'         => $this->data['address_1'],
                        'address_2'         => $this->data['address_2'],
                        'country_id '       => $this->data['country_id'],
                        'state_id '         => $this->data['state_id'],
                        'city'              => $this->data['city'],
                        'postal_code'       => $this->data['postal_code'],
                        'email'             => $this->data['email'],
                        'email_2'           => $this->data['email_2'],
                        'phone_1'           => $this->data['phone_1'],
                        'phone_2'           => $this->data['phone_2'],
                        'point'             => $this->data['point'],
                        'logo'              => $this->data['logo'],
                        'video'             => $this->data['youtubeUrl'],
                        'thumb'             => $this->data['youtubeThumb'],
                       // 'search_keywords'   => $this->data['search_keywords'],
                    ], $this->id);
                    SettingsMailConfiguration_model::factory()->delete(['settings_id' => $this->id], true);
                    SettingsMailConfiguration_model::factory()->insert([
                        'settings_id'   => $this->id,
                        'protocol'      => $this->data['protocol'],
                        'parameter'     => $this->data['parameter'],
                        'smtp_hostname' => $this->data['smtp_hostname'],
                        'smtp_username' => $this->data['smtp_username'],
                        'smtp_password' => $this->data['smtp_password'],
                        'smtp_port'     => $this->data['smtp_port'],
                        'smtp_timeout'  => $this->data['smtp_timeout'],
                        'sender_email'  => $this->data['sender_email'],
                        'sender_name'   => $this->data['sender_name'],
                    ]);
                    SettingsMetaData_model::factory()->delete(['settings_id' => $this->id], true);
                    SettingsMetaData_model::factory()->insert([
                        'settings_id'       => $this->id,
                        'meta_title'        => $this->data['meta_title'],
                        'meta_keywords'     => $this->data['meta_keywords'],
                        'meta_description'  => $this->data['meta_description'],
                    ]);
                    //SettingsCurrencyConfiguration_model::factory()->delete(['settings_id' => $this->id], true);
                    //dd($this->data);
                    Currency_model::factory()->refresh(true, $this->data['currency']);
                    SettingsCurrencyConfiguration_model::factory()->update([
                        'settings_id'   => $this->id,
                        'currency'      => $this->data['currency'],
                    ],['settings_id' => $this->id]);

                    $output  = '<?php' . "\n";
                    $output .= '$config[\'config_mail_engine\']             = "'.$this->data["protocol"].'";'."\n";
                    $output .= '$config[\'config_mail_parameter\']          = "'.$this->data["parameter"].'";'."\n";
                    $output .= '$config[\'config_mail_smtp_hostname\']      = "'.$this->data["smtp_hostname"].'";'."\n";
                    $output .= '$config[\'config_mail_smtp_username\']      = "'.$this->data["smtp_username"].'";'."\n";
                    $output .= '$config[\'config_mail_smtp_password\']      = "'.$this->data["smtp_password"].'";'."\n";
                    $output .= '$config[\'config_mail_smtp_port\']          = "'.$this->data["smtp_port"].'";'."\n";
                    $output .= '$config[\'config_mail_smtp_timeout\']       = "'.$this->data["smtp_timeout"].'";'."\n";
                    $output .= '$config[\'config_email\']                   = "'.$this->data["sender_email"].'";'."\n";
                    $output .= '$config[\'config_sender_name\']             = "'.$this->data["sender_name"].'";'."\n";

                    $file = fopen(APPPATH . 'config/mail.php', 'w');
                    fwrite($file, $output);
                    fclose($file);

                    $this->setSession('settings', Settings_model::factory()->find()->get()->row_array());
                    $this->setSession('meta', SettingsMetaData_model::factory()->find()->get()->row_array());

                    $this->setSession('currency', $this->currency->getCurrency($this->data['currency']));
                    //$this->setSession('settings.mail.config', SettingsMailConfiguration_model::factory()->find()->where('settings_id', $this->id)->get()->row_array());

                    $this->setMessage('message', 'Settings has been successfully modified');
            }
        }
        $this->settings = Settings_model::factory()->find()->get()->row_object();
        if($this->settings) {
            $this->mail = SettingsMailConfiguration_model::factory()->find()->get()->row_object();
            $this->meta = SettingsMetaData_model::factory()->find()->get()->row_object();
            $this->currencyModel = SettingsCurrencyConfiguration_model::factory()->find()->get()->row_object();

        }
        $this->setData();
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');




        $this->template->javascript->add('assets/js/admin/settings/Settings.js');
        $this->template->content->view('settings/index', $this->data);
        $this->template->publish();
    }
    public function point() {
        $this->template->content->view('settings/point');
        $this->template->publish();
    }
    public function store() {}
    public function update() {}
}