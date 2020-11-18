<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
class Account extends AppController {

    /**
     * @var object
     */

    private $error;
    /**
     * @var object
     */
    private $auser;
    /**
     * @var object
     */
    private $subscriber;

    public function __construct()
	{
        parent::__construct();
        $this->lang->load('admin/users_lang');
        $this->template->set_template('layout/app');

    }
    public function index() {
        //dd($_SESSION);
        if (!$this->user->isLogged()) {
            $this->redirect($this->url('login'));
        }
        if(!$this->isSubscribed()) redirect('viewplans');

        if(isLogged()) {
            $this->auser = User_model::factory()->findOne(userId());
        }
        if($this->auser) {
            $this->data['user']             = $this->auser;
            $this->data['registrationDate'] =Carbon::createFromTimeStamp(strtotime($this->auser->created_at));
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

        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/account/Account.js');
        $this->template->content->view('account/index', $this->data);
        $this->template->publish();
	}
    public function update() {

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


            if (!empty($this->request['password'])) {
                if ((strlen($this->request['password']) < 4) || (strlen($this->request['password']) > 20)) {
                    $this->json['error']['password'] = $this->lang->line('error_password');
                }
            }
            if (!empty($this->request['confirm'])) {
                if ($this->request['confirm'] != $this->request['password']) {
                    $this->json['error']['confirm'] = $this->lang->line('error_confirm');
                }
            }
            //dd($this->json);
            if(!$this->json) {
                User_model::factory()->updateAccount(userId(), $this->request);
                $this->setSession('user', User_model::factory()->getUser(userId()));
                $this->json['success'] = $this->lang->line('text_success');
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode($this->json));

            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->json));

        }
    }
	public function logout() {
        if ($this->user->isLogged()) {
			$this->user->logout();
			$this->redirect($this->url(''));
		}
        $this->redirect($this->url('login'));
    }
}