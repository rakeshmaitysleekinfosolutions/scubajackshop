<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
use Application\Contracts\CrudContract;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

class Membershipplan extends AdminController implements CrudContract {

    /**
     * @var object
     */
    private $quiz;
    /**
     * @var string
     */
    private $status;
    /**
     * @var object
     */
    private $question;
    /**
     * @var object
     */
    private $answer;
    /**
     * @var object
     */
    private $plan;
    /**
     * @var Paypal
     */
    private $paypal;


    public function __construct() {
        parent::__construct();
        $this->lang->load('admin/membership_plan');
        $this->template->set_template('layout/admin');
        $this->paypal = new Paypal();
       // $this->paypal->setApiContext($this->config->item('CLIENT_ID'), $this->config->item('CLIENT_SECRET'));
    }

    private $quizzes;
    /**
     * @var string
     */
    public function index() {
        $this->template->stylesheet->add('assets/theme/light/js/datatables/dataTables.bootstrap4.css');
        $this->template->javascript->add('assets/theme/light/js/datatables/jquery.dataTables.min.js');
        $this->template->javascript->add('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js');
        $this->template->javascript->add('assets/js/admin/membershipplan/MembershipPlan.js');

        $this->template->content->view('membershipplan/index');
        $this->template->publish();
    }

    public function setData() {
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (isset($this->error['name'])) {
            $this->data['error_name'] = $this->error['name'];
        } else {
            $this->data['error_name'] = '';
        }

        // primaryKey
        if (isset($this->plan)) {
            $this->data['primaryKey'] = $this->plan->id;
        } else {
            $this->data['primaryKey'] = '';
        }
        // Plan Name
        if (!empty($this->input->post('name'))) {
            $this->data['name'] = $this->input->post('name');
        } elseif (!empty($this->plan)) {
            $this->data['name'] = $this->plan->name;
        } else {
            $this->data['name'] = '';
        }
        // Slug
        if (!empty($this->input->post('name'))) {
            $this->data['slug'] = url_title($this->input->post('name'),'dash', true);
        } elseif (!empty($this->plan)) {
            $this->data['slug'] = ($this->plan->slug) ? $this->plan->slug : url_title($this->input->post('name'),'dash', true);
        } else {
            $this->data['slug'] = url_title($this->input->post('name'),'dash', true);
        }
        // Description
        if (!empty($this->input->post('description'))) {
            $this->data['description'] = $this->input->post('description');
        } elseif (!empty($this->plan)) {
            $this->data['description'] = $this->plan->description;
        } else {
            $this->data['description'] = '';
        }
        // Type of the payment definition. Allowed values: `TRIAL`, `REGULAR`.
        if (!empty($this->input->post('type'))) {
            $this->data['type'] = $this->input->post('type');
        } elseif (!empty($this->plan)) {
            $this->data['type'] = $this->plan->price;
        } else {
            $this->data['type'] = '';
        }
        // 	Frequency of the payment definition offered. Allowed values: `WEEK`, `DAY`, `YEAR`, `MONTH`.
        if (!empty($this->input->post('frequency'))) {
            $this->data['frequency'] = $this->input->post('frequency');
        } elseif (!empty($this->plan)) {
            $this->data['frequency'] = $this->plan->frequency;
        } else {
            $this->data['frequency'] = '';
        }
        // 	How frequently the customer should be charged.
        if (!empty($this->input->post('frequency_interval'))) {
            $this->data['frequency_interval'] = $this->input->post('frequency_interval');
        } elseif (!empty($this->plan)) {
            $this->data['frequency_interval'] = $this->plan->frequency_interval;
        } else {
            $this->data['frequency_interval'] = '';
        }
        // 	Number of cycles in this payment definition.
        if (!empty($this->input->post('cycles'))) {
            $this->data['cycles'] = $this->input->post('cycles');
        } elseif (!empty($this->plan)) {
            $this->data['cycles'] = $this->plan->cycles;
        } else {
            $this->data['frequency_interval'] = '';
        }
        // Type of the payment definition. Allowed values: `TRIAL`, `REGULAR`.
        if (!empty($this->input->post('cycles'))) {
            $this->data['cycles'] = $this->input->post('cycles');
        } elseif (!empty($this->plan)) {
            $this->data['cycles'] = $this->plan->cycles;
        } else {
            $this->data['cycles'] = '';
        }
        // Amount that will be charged at the end of each cycle for this payment definition.
        if (!empty($this->input->post('price'))) {
            $this->data['price'] = $this->input->post('price');
        } elseif (!empty($this->plan)) {
            $this->data['price'] = $this->plan->price;
        } else {
            $this->data['price'] = '';
        }
        // 	Duration
        if (!empty($this->input->post('duration'))) {
            $this->data['duration'] = $this->input->post('duration');
        } elseif (!empty($this->plan)) {
            $this->data['duration'] = $this->plan->duration;
        } else {
            $this->data['duration'] = '';
        }
        // State
        if (!empty($this->input->post('state'))) {
            $this->data['state'] = $this->input->post('state');
        } elseif (!empty($this->plan)) {
            $this->data['state'] = $this->plan->state;
        } else {
            $this->data['state'] = '';
        }
        //dd($this->data);
        $this->data['back']         = admin_url('membershipplan');
    }

    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/membershipplan/MembershipPlan.js');

        $this->setData();
        $this->template->content->view('membershipplan/create', $this->data);
        $this->template->publish();
    }

    public function store() {

            $this->setData();
           // $this->dd($this->data['price']);
            if ($this->isPost() && $this->validateForm()) {
                $this->paypal->plan->setName($this->data['name'])
                    ->setDescription($this->data['description']);


                $this->paypal->paymentDefinition->setName('Regular Payments')
                    ->setType($this->data['type'])
                    ->setFrequency($this->data['frequency'])
                    ->setFrequencyInterval($this->data['frequency_interval'])
                    ->setCycles($this->data['cycles'])
                    ->setAmount(array(
                        'value' => $this->data['price'],
                        'currency' => 'USD'
                    ));

                $this->paypal->chargeModel->setType('SHIPPING')->setAmount(array(
                        'value' => 0,
                        'currency' => 'USD'
                    ));
                $this->paypal->setPaymentModel('{"state":"'.$this->data['state'].'"}')
                        ->createOrUpdatePlan();

                Membershipplan_model::factory()->insert([
                    'name' => $this->data['name'],
                    'type' => $this->data['type'],
                    'frequency' => $this->data['frequency'],
                    'frequency_interval' => $this->data['frequency_interval'],
                    'duration' => $this->data['duration'],
                    'cycles' => $this->data['cycles'],
                    'slug' => $this->data['slug'],
                    'description' => $this->data['description'],
                    'price' => $this->data['price'],
                    'state' => $this->data['state'],
                    'paypal_plan_id' => $this->paypal->getPlanId()
                ]);


                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('membershipplan/create/'));
            }
    }

    public function edit($id) {
        try {
            $this->id = $id;
            $this->plan = Membershipplan_model::factory()->findOne($this->id);

            if(!$this->plan) {
                $this->redirect(admin_url('membershipplan'));
            }

            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/membershipplan/MembershipPlan.js');

            $this->template->set_template('layout/admin');
            $this->setData();

            $this->template->content->view('membershipplan/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update($id) {
        try {
            $this->setData();
            $this->id = $id;
            $this->plan = Membershipplan_model::factory()->findOne($id);
            if(!$this->plan) {
                $this->setMessage('warning', $this->lang->line('text_notfound'));
                $this->redirect(admin_url('membershipplan'));
            }
            if ($this->isPost() && $this->validateForm()) {
                $this->paypal->plan->setName($this->data['name'])
                    ->setDescription($this->data['description']);


                $this->paypal->paymentDefinition->setName('Regular Payments')
                    ->setType($this->data['type'])
                    ->setFrequency($this->data['frequency'])
                    ->setFrequencyInterval($this->data['frequency_interval'])
                    ->setCycles($this->data['cycles'])
                    ->setAmount(array(
                        'value' => $this->data['price'],
                        'currency' => $this->getSession('currency')['code']
                    ));

                $this->paypal->chargeModel->setType('SHIPPING')->setAmount(array(
                    'value' => 0,
                    'currency' => $this->getSession('currency')['code']
                ));
                $this->paypal->setPaymentModel('{"state":"'.$this->data['state'].'"}')
                    ->createOrUpdatePlan();
                //$this->dd($this->paypal);
                Membershipplan_model::factory()->update([
                    'name' => $this->data['name'],
                    'type' => $this->data['type'],
                    'frequency' => $this->data['frequency'],
                    'frequency_interval' => $this->data['frequency_interval'],
                    'duration' => $this->data['duration'],
                    'cycles' => $this->data['cycles'],
                    'slug' => $this->data['slug'],
                    'description' => $this->data['description'],
                    'price' => $this->data['price'],
                    'state' => $this->data['state'],
                    'paypal_plan_id' => $this->paypal->getPlanId()
                ], $this->id);

                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('membershipplan/edit/'.$this->id));
            }
            $this->edit($id);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function delete() {
        try {
            if($this->isAjaxRequest()) {
                $this->request = $this->input->post();

                if(!empty($this->request['selected']) && isset($this->request['selected'])) {
                    if(array_key_exists('selected', $this->request) && is_array($this->request['selected'])) {
                        $this->selected = $this->request['selected'];
                    }
                }
                if($this->selected) {
                    foreach ($this->selected as $id) {
                        $this->plan = Membershipplan_model::factory()->findOne($id);
                        $this->paypal->plan->setId($this->plan->paypal_plan_id);
                        $this->paypal->deletePlan();
                        Membershipplan_model::factory()->update(['state' => 'INACTIVE'], $id);
                        Membershipplan_model::factory()->delete($id);

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
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function onLoadDatatableEventHandler() {

        $this->results = Membershipplan_model::factory()->findAll();
        if($this->results) {
            foreach($this->results as $result) {
                $this->rows[] = array(
                    'id'			=> $result->id,
                    'paypalPlanId'			=> $result->paypal_plan_id,
                    'name'		    => $result->name,
                    'frequency'		=> $result->frequency,
                    'frequencyInterval'		=> $result->frequency_interval,
                    'duration'		    => $result->duration,
                    'cycles'		=> $result->cycles,
                    'price'		    => $result->price,
                    'created_at'    => Carbon::createFromTimeStamp(strtotime($result->created_at))->diffForHumans(),
                    'updated_at'    => ($result->updated_at) ? Carbon::createFromTimeStamp(strtotime($result->updated_at))->diffForHumans() : ''
                );
            }
            $i = 0;
            foreach($this->rows as $row) {

                $this->data[$i][] = '<td class="text-center">
											<label class="css-control css-control-primary css-checkbox">
												<input data-id="'.$row['id'].'" type="checkbox" class="css-control-input selectCheckbox" id="row_'.$row['id'].'" name="row_'.$row['id'].'">
												<span class="css-control-indicator"></span>
											</label>
										</td>';
                $this->data[$i][] = '<td>'.$row['name'].'</td>';
                $this->data[$i][] = '<td>'.$row['paypalPlanId'].'</td>';
                $this->data[$i][] = '<td>'.$row['frequency'].'</td>';
                $this->data[$i][] = '<td>'.$row['frequencyInterval'].'</td>';
                $this->data[$i][] = '<td>'.$row['duration'].'</td>';
                $this->data[$i][] = '<td>'.$row['cycles'].'</td>';
                $this->data[$i][] = '<td>'.$row['price'].'</td>';
                $this->data[$i][] = '<td>'.$row['created_at'].'</td>';
                $this->data[$i][] = '<td>'.$row['updated_at'].'</td>';
                $this->data[$i][] = '<td class="text-right">
	                            <div class="dropdown">
	                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
	                                <ul class="dropdown-menu pull-right">
	                                    <li><a class="edit" href="javascript:void(0);" data-id="'.$row['id'].'" data-toggle="modal" data-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
	                                    
	                                </ul>
	                            </div>
	                        </td>
                        ';
                $i++;
            }


        }
//        <li><a class="delete" href="javascript:void(0);" data-id="'.$row['id'].'" data-toggle="modal" data-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
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
        try {
            if($this->isAjaxRequest()) {
                $this->id       = ($this->input->post('id')) ? $this->input->post('id') : '';
                $this->status   = ($this->input->post('status')) ? $this->input->post('status') : '';
                Quiz_model::factory()->update([
                    'status' => $this->status,
                ], $this->id);
                $this->json['status'] = 'Status has been successfully updated';
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode($this->json));
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function validateForm()
    {
        // TODO: Implement validateForm() method.
        if ((strlen($this->input->post('name')) < 1) || (strlen(trim($this->input->post('name'))) > 128)) {
            $this->error['name'] = "Required";
        }
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->lang->line('error_warning');
        }
        //$this->dd($this->error);
        return !$this->error;
    }
}