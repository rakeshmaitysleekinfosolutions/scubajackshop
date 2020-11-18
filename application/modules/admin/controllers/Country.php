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

class Country extends AdminController implements CrudContract {


    /**
     * @var string
     */
    private $status;
    /**
     * @var object
     */
    private $country;


    public function __construct() {
        parent::__construct();
        $this->template->set_template('layout/admin');
    }

    private $quizzes;
    /**
     * @var string
     */
    public function index() {
        $this->template->stylesheet->add('assets/theme/light/js/datatables/dataTables.bootstrap4.css');
        $this->template->javascript->add('assets/theme/light/js/datatables/jquery.dataTables.min.js');
        $this->template->javascript->add('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js');
        $this->template->javascript->add('assets/js/admin/country/Country.js');

        $this->template->content->view('country/index');
        $this->template->publish();
    }

    public function setData() {

        if (isset($this->country)) {
            $this->data['id'] = $this->country->id;
        } else {
            $this->data['id'] = '';
        }
        if (!empty($this->input->post('continent_id'))) {
            $this->data['continent_id'] = $this->input->post('continent_id');
        } elseif (!empty($this->country)) {
            $this->data['continent_id'] = $this->country->continent_id;
        } else {
            $this->data['continent_id'] = '';
        }
        if (!empty($this->input->post('name'))) {
            $this->data['name'] = $this->input->post('name');
        } elseif (!empty($this->country)) {
            $this->data['name'] = $this->country->name;
        } else {
            $this->data['name'] = '';
        }
        if (!empty($this->input->post('iso_code_2'))) {
            $this->data['iso_code_2'] = $this->input->post('iso_code_2');
        } elseif (!empty($this->country)) {
            $this->data['iso_code_2'] = $this->country->iso_code_2;
        } else {
            $this->data['iso_code_2'] = '';
        }
        $this->data['continents']   = Continent_model::factory()->findAll();
        $this->data['back']         = admin_url('country');
    }

    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/country/Country.js');

        $this->setData();
        $this->template->content->view('country/create', $this->data);
        $this->template->publish();
    }

    public function store() {
        try {
            if ($this->isPost()) {
                $this->setData();
                Country_model::factory()->insert([
                    'continent_id'  => $this->data['continent_id'],
                    'name'          => $this->data['name'],
                    'iso_code_2'    => $this->data['iso_code_2'],
                ]);
                $this->setMessage('message', 'Country has been successfully modified!');
                $this->redirect(admin_url('country/create/'));
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function edit($id) {
        try {
            $this->country = Country_model::factory()->findOne($id);
            if(!$this->country) {
                $this->setMessage('warning', 'Country not found');
                $this->redirect(admin_url('country'));
            }
            $this->setData();

            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/country/Country.js');
            $this->template->set_template('layout/admin');
            $this->template->content->view('country/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update($id) {
        try {
            $this->country = country_model::factory()->findOne($id);
            $this->setData();
            if ($this->isPost()) {
                Country_model::factory()->update([
                    'continent_id'  => $this->data['continent_id'],
                    'name'          => $this->data['name'],
                    'iso_code_2'    => $this->data['iso_code_2'],
                ], $id);

                $this->setMessage('message', 'Country has been successfully modified!');
                $this->redirect(admin_url('country/edit/'.$id));
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
                        Country_model::factory()->delete($id);
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
        $this->results = Country_model::factory()->findAll();
        if($this->results) {
            foreach($this->results as $result) {
                $this->rows[] = array(
                    'id'			=> $result->id,
                    'continent'	    => ($result->continent) ? $result->continent->name : '',
                    'country'		=> $result->name,
                    'iso_code_2'	=> $result->iso_code_2,
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
                $this->data[$i][] = '<td>'.$row['continent'].'</td>';
                $this->data[$i][] = '<td>'.$row['country'].'</td>';
                $this->data[$i][] = '<td>'.$row['iso_code_2'].'</td>';
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