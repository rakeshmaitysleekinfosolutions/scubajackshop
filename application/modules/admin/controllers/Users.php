<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
class Users extends AdminController implements \Application\Contracts\UserContract {

    private $address;
    private $user;
    private $userId;
    private $country;
    private $status;
    /**
     * @var mixed
     */

    //private $selected;

    public function __constructor() {
		parent::__construct();
        //$this->load->model('User_model');
	}	

	public function setUser($user) {
		$this->user = $user;
		return $this;
	}

	public function setUserId($userId) {
		$this->userId = $userId;
		return $this;
	}

    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

	public function onLoadDatatableEventHandler() {
		$this->load->model('User_model', 'User_model');
		$this->results = $this->User_model->findAll();
		if($this->results) {
			foreach($this->results as $result) {
				$this->rows[] = array(
					'id'			=> $result->id,
					'firstname'		=> $result->firstname,
					'lastname' 		=> $result->lastname,
					'email' 		=> $result->email,
                    'status' 		=> ($result->status && $result->status == 1) ? 1 : 0,
                    'created_at'    => Carbon::createFromTimeStamp(strtotime($result->created_at))->diffForHumans(),
                    'updated_at'    => ($result->updated_at) ? Carbon::createFromTimeStamp(strtotime($result->updated_at))->diffForHumans() : ''
				);
			}
			$i = 0;
			foreach($this->rows as $row) {
                    $selected = ($row['status']) ? 'selected' : '';
					$this->data[$i][] = '<td class="text-center">
											<label class="css-control css-control-primary css-checkbox">
												<input data-id="'.$row['id'].'" type="checkbox" class="css-control-input selectCheckbox" id="row_'.$row['id'].'" name="row_'.$row['id'].'">
												<span class="css-control-indicator"></span>
											</label>
										</td>';
					$this->data[$i][] = '<td>'.$row['firstname'].'</td>';
					$this->data[$i][] = '<td>'.$row['lastname'].'</td>';
					$this->data[$i][] = '<td>'.$row['email'].'</td>';
//					$this->data[$i][] = '<td>
//											<div class="material-switch pull-right">
//											<input data-id="'.$row['id'].'" class="checkboxStatus" id="chat_module" type="checkbox" value="'.$row['status']['value'].'" '.$checked.'/>
//											<label for="chat_module" class="label-success"></label>
//										</div>
//                                        </td>';
                $this->data[$i][] = '<td>
                                            <select data-id="'.$row['id'].'" name="status" class="select floating checkboxStatus" id="input-payment-status" >
                                                <option value="0" '.$selected.'>Inactive</option>
                                                <option value="1" '.$selected.'>Active</option>
                                            </select>
                                        </td>';
                    $this->data[$i][] = '<td>'.$row['created_at'].'</td>';
                $this->data[$i][] = '<td>'.$row['updated_at'].'</td>';
					$this->data[$i][] = '<td class="text-right">
	                            <div class="dropdown">
	                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
	                                <ul class="dropdown-menu pull-right">
	                                    <li><a class="edit" href="javascript:void(0);" data-id="'.$row['id'].'" data-toggle="modal" data-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
	                                    <li><a class="delete" href="#" data-toggle="modal" data-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
	                                </ul>
	                            </div>
	                        </td>
                        ';
                    
                  //  $this->data[$i][] = '<td>'.$row['updated_at'].'</td>';
	                    $i++;
				}


		}

		if($this->data) {
			return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array('data' => $this->data)));
		} else {
			return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array('data' => [])));
		}
	}

	public function onChangeStatusEventHandler() {
		if($this->isAjaxRequest()) {
			$this->request = $this->input->post();
			if(isset($this->request['status']) && isset($this->request['id'])) {

                $this->userId   = (isset($this->request['id'])) ? $this->request['id'] : '';
                $this->status       = (isset($this->request['status'])) ? $this->request['status'] : '';

                $this->load->model('User_model');
                $this->User_model->updateStatus($this->userId, $this->status);

                $this->json['status'] = 'Status has been successfully updated';
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode($this->json));
            }
		}
	}

	public function index() {
	
		//$this->beforeRender();

		$this->template->set_template('layout/admin');
		$this->template->stylesheet->add('assets/theme/light/js/datatables/dataTables.bootstrap4.css');
        $this->template->javascript->add('assets/theme/light/js/datatables/jquery.dataTables.min.js');
		$this->template->javascript->add('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js');

        $this->template->javascript->add('assets/js/admin/users/Users.js');
		$this->template->content->view('users/index');
		$this->template->publish();
	}

	public function create() {
		$this->template->set_template('layout/admin');
		$this->template->content->view('users/create');
		$this->template->publish();
		
	}

    public function form() {

        // Any kind of Warning
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        /**
         * @desc Errors
         */
        if (isset($this->error['email'])) {
            $this->data['error_email'] = $this->error['email'];
        } else {
            $this->data['error_email'] = '';
        }

        if (isset($this->error['password'])) {
            $this->data['error_password'] = $this->error['password'];
        } else {
            $this->data['error_password'] = '';
        }

        if (isset($this->error['confirm'])) {
            $this->data['error_confirm'] = $this->error['confirm'];
        } else {
            $this->data['error_confirm'] = '';
        }

        if (isset($this->error['firstname'])) {
            $this->data['error_firstname'] = $this->error['firstname'];
        } else {
            $this->data['error_firstname'] = '';
        }

        if (isset($this->error['lastname'])) {
            $this->data['error_lastname'] = $this->error['lastname'];
        } else {
            $this->data['error_lastname'] = '';
        }

        if (isset($this->error['email'])) {
            $this->data['error_email'] = $this->error['email'];
        } else {
            $this->data['error_email'] = '';
        }

        if (isset($this->error['status'])) {
            $this->data['error_status'] = $this->error['status'];
        } else {
            $this->data['error_status'] = '';
        }

        /**
         * Get Data
         */
        // User ID
        if (!empty($this->input->post('id'))) {
            $this->data['id'] = $this->input->post('id');
        } elseif (!empty($this->user)) {
            $this->data['id'] = $this->user->id;
        } else {
            $this->data['id'] = '';
        }
        // First Name
        if (!empty($this->input->post('firstname'))) {
            $this->data['firstname'] = $this->input->post('firstname');
        } elseif (!empty($this->user)) {
            $this->data['firstname'] = $this->user->firstname;
        } else {
            $this->data['firstname'] = '';
        }

        // Last Name
        if (!empty($this->input->post('lastname'))) {
            $this->data['lastname'] = $this->input->post('lastname');
        } elseif (!empty($this->user)) {
            $this->data['lastname'] = $this->user->lastname;
        } else {
            $this->data['lastname'] = '';
        }
        // Email
        if (!empty($this->input->post('email'))) {
            $this->data['email'] = $this->input->post('email');
        } elseif (!empty($this->user)) {
            $this->data['email'] = $this->user->email;
        } else {
            $this->data['email'] = '';
        }
        // Password
        if (!empty($this->input->post('password'))) {
            $this->data['password'] = $this->input->post('password');
        } else {
            $this->data['password'] = '';
        }
        // Confirm Password
        if (!empty($this->input->post('confirm'))) {
            $this->data['confirm'] = $this->input->post('confirm');
        } else {
            $this->data['confirm'] = '';
        }
        // Status
        if (!empty($this->input->post('status'))) {
            $this->data['status'] = $this->input->post('status');
        } elseif (!empty($this->user)) {
            $this->data['status'] = $this->user->status;
        } else {
            $this->data['status'] = 0;
        }
        // Address ID
        if (!empty($this->input->post('address_id'))) {
            $this->data['address_id'] = $this->input->post('address_id');
        } elseif (!empty($this->address)) {
            $this->data['address_id'] = $this->address->id;
        } else {
            $this->data['address_id'] = '';
        }
        // Address 1
        if (!empty($this->input->post('address_1'))) {
            $this->data['address_1'] = $this->input->post('address_1');
        } elseif (!empty($this->address)) {
            $this->data['address_1'] = $this->address->address_1;
        } else {
            $this->data['address_1'] = '';
        }
        // Address 2 Optional
        if (!empty($this->input->post('address_2'))) {
            $this->data['address_2'] = $this->input->post('address_2');
        } elseif (!empty($this->address)) {
            $this->data['address_2'] = $this->address->address_2;
        } else {
            $this->data['address_2'] = '';
        }
        // Phone Optional
        if (!empty($this->input->post('phone'))) {
            $this->data['phone'] = $this->input->post('phone');
        } elseif (!empty($this->user)) {
            $this->data['phone'] = $this->user->phone;
        } else {
            $this->data['phone'] = '';
        }
        // PostCode
        if (!empty($this->input->post('postcode'))) {
            $this->data['postcode'] = $this->input->post('postcode');
        } elseif (!empty($this->address)) {
            $this->data['postcode'] = $this->address->postcode;
        } else {
            $this->data['postcode'] = '';
        }
        // City
        if (!empty($this->input->post('city'))) {
            $this->data['city'] = $this->input->post('city');
        } elseif (!empty($this->address)) {
            $this->data['city'] = $this->address->city;
        } else {
            $this->data['city'] = '';
        }
        // City
        if(!empty($this->address)) {
            $this->data['country_id'] = $this->address->country_id;
        } else {
            $this->data['country_id'] = '';
        }
        // City
        if(!empty($this->address)) {
            $this->data['state_id'] = $this->address->state_id;
        } else {
            $this->data['state_id'] = '';
        }
        $this->data['countries'] = $this->countries();
        $this->data['back'] = admin_url('category');

        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/users/Users.js');
        $this->template->set_template('layout/admin');
        $this->template->content->view('users/edit', $this->data);
        $this->template->publish();
    }
	public function store() {
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
			
			if ($this->User_model->getTotalUsersByEmail($this->request['email'])) {
				$this->json['error']['warning'] = $this->lang->line('error_exists');
			}
			
			
			if ((strlen($this->request['password']) < 4) || (strlen($this->request['password']) > 20)) {
				$this->json['error']['password'] = $this->lang->line('error_password');
			}
			
			if ($this->request['confirm'] != $this->request['password']) {
				$this->json['error']['confirm'] = $this->lang->line('error_confirm');
			}
			
            if (!$this->json) {
				// Add new user
				$useId = $this->User_model->addUser($this->request);
				if($useId) {
					// Get User
					$userInfo = $this->User_model->getUser($useId);
				}
				$this->json['success']          = $this->lang->line('text_success');
				$this->json['redirect'] 		= url('/');
            } 
            return $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(200)
                        ->set_output(json_encode($this->json));
        }
	}

	public function edit($id) {
        $this->load->model('User_model');
        $this->lang->load('admin/users_lang');

        if(!$this->isPost()) {
            $this->setUser(User_model::factory()->user($id));
        }
        if($this->user) {
            $this->setUserId($this->user->id);
            $this->setAddress($this->user->address());
        }
		if(!$this->userId) {
			$this->redirect(admin_url('users'));
		}

		//$this->dd($this->user->id);
        $userInfo = User_model::factory()->getUserByEmail($this->input->post('email'));

        if (!empty($id)) {
            if ($userInfo) {
                $this->error['warning'] = $this->lang->line('error_exists');
            }
        } else {
            if ($userInfo && ($id != $userInfo['id'])) {
                $this->error['warning'] = $this->lang->line('error_exists');
            }
        }
        if ($this->input->post('password') || (!isset($id))) {
            if ((strlen(html_entity_decode($this->input->post('password'), ENT_QUOTES, 'UTF-8')) < 4) || (strlen(html_entity_decode($this->input->post['password'], ENT_QUOTES, 'UTF-8')) > 40)) {
                $this->error['password'] = $this->lang->line('error_password');
            }
            if ($this->input->post('password') != $this->input->post('confirm')) {
                $this->error['confirm'] = $this->lang->line('error_confirm');
            }
        }
        $this->form();
	}

	public function update() {
        $this->lang->load('admin/users_lang');
		if ($this->isPost() && $this->validateForm()) {

            $this->load->model('User_model');
//dd($this->input->post());
            User_model::factory()->editUser($this->input->post('id'), $this->input->post());

            $this->setMessage('message', $this->lang->line('text_success'));

            $this->redirect(admin_url('users/edit/'.$this->input->post('id')));

		}
		//$this->dd($this->error);
        $this->form();

	}
	public function show($id) {
		//$this->template->admin('show');
	}
    public function validateForm() {

		if ((strlen($this->input->post('firstname')) < 1) || (strlen(trim($this->input->post('firstname'))) > 32)) {
			$this->error['firstname'] = $this->lang->line('error_firstname');
		}

		if ((strlen($this->input->post('lastname')) < 1) || (strlen(trim($this->input->post('lastname'))) > 32)) {
			$this->error['lastname'] = $this->lang->line('error_lastname');
		}

		if ((strlen($this->input->post('email')) > 96) || !filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->lang->line('error_email');
		}
		/*
		if ((strlen($this->input->post('telephone') < 3) || (strlen($this->input->post('telephone'))) > 32)) {
            $this->error['telephone'] = $this->lang->line('error_telephone');
        }
		*/
        if ($this->input->post('status') == '') {
            $this->error['status'] = $this->lang->line('error_status');
        }

        /*
		if (!empty($this->input->post('address'))) {
            foreach ($this->input->post('address') as $key => $value) {

                if ((strlen($value['firstname']) < 1) || (strlen($value['firstname']) > 32)) {
                    $this->error['address'][$key]['firstname'] = $this->lang->line('error_firstname');
                }

                if ((strlen($value['lastname']) < 1) || (strlen($value['lastname']) > 32)) {
                    $this->error['address'][$key]['lastname'] = $this->lang->line('error_lastname');
                }

                if ((strlen($value['address_1']) < 3) || (strlen($value['address_1']) > 128)) {
                    $this->error['address'][$key]['address_1'] = $this->lang->line('error_address_1');
                }

                if ((strlen($value['city']) < 2) || (strlen($value['city']) > 128)) {
                    $this->error['address'][$key]['city'] = $this->lang->line('error_city');
                }

                $this->load->model('Country_model');

                $country = $this->Country_model->getCountry($value['country_id']);

                if ($country && $country['postcode_required'] && (strlen($value['postcode']) < 2 || strlen($value['postcode']) > 10)) {
                    $this->error['address'][$key]['postcode'] = $this->lang->line('error_postcode');
                }

                if ($value['country_id'] == '') {
                    $this->error['address'][$key]['country'] = $this->lang->line('error_country');
                }

                if (!isset($value['state_id']) || $value['state_id'] == '') {
                    $this->error['address'][$key]['state'] = $this->lang->line('error_state');
                }
            }
        }
        */
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->lang->line('error_warning');
		}
       // $this->dd($this->error);
		return !$this->error;
	}
    public function countries() {
        $this->load->model('Country_model');
        return $this->Country_model->findAll();
    }
	public function states() {
        if($this->isAjaxRequest()) {
            $json = array();
            $this->load->model('Country_model');
            $this->country =  $this->Country_model->findOne($this->input->post('country_id'));

            if ($this->country) {
                $json = array(
                    'country_id'        => $this->country->id,
                    'states'            => $this->country->states(),
                );
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($json));
        }
    }
    public function delete() {
        if($this->isAjaxRequest()) {
            $this->request = $this->input->post();

            if(!empty($this->request['selected']) && isset($this->request['selected'])) {
                if(array_key_exists('selected', $this->request) && is_array($this->request['selected'])) {
                    $this->selected = $this->request['selected'];
                }
            }
            if($this->selected) {
                $this->load->model('User_model');
                foreach ($this->selected as $userId) {
                    $this->User_model->deleteUsers($userId);

                    Subscriber_model::factory()->delete(['user_id' => $userId], true);
                    UserPassport_model::factory()->delete(['user_id' => $userId], true);
                    UserPoint_model::factory()->delete(['user_id' => $userId], true);
                    UserQuestionAnswer_model::factory()->delete(['user_id' => $userId], true);
                    UserAddress_model::factory()->delete(['user_id' => $userId], true);
                    UserQuizScore_model::factory()->delete(['user_id' => $userId], true);
                }
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array('data' => $this->onLoadDatatableEventHandler(), 'status' => true,'message' => 'Record has been successfully deleted')));
            }
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array('data' => $this->onLoadDatatableEventHandler(), 'status' => false, 'message' => 'Sorry! we could not delete this record')));

        }

    }
}