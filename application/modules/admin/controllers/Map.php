<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
use Application\Contracts\AnswerContract;

class Map extends AdminController implements AnswerContract {


    /**
     * @var string
     */
    private $status;
    private $map;

    public function __construct() {
        parent::__construct();
        $this->lang->load('admin/map');
        $this->template->set_template('layout/admin');
    }


    public function index() {
        $this->template->stylesheet->add('assets/theme/light/js/datatables/dataTables.bootstrap4.css');
        $this->template->javascript->add('assets/theme/light/js/datatables/jquery.dataTables.min.js');
        $this->template->javascript->add('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js');
        $this->template->javascript->add('assets/js/admin/map/Map.js');

        $this->template->content->view('map/index');
        $this->template->publish();
    }

    public function setData() {
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (isset($this->error['path_d'])) {
            $this->data['error_path_d'] = $this->error['path_d'];
        } else {
            $this->data['error_path_d'] = '';
        }
        // Answer ID
        if (!empty($this->map)) {
            $this->data['primaryKey'] = $this->map->id;
        } else {
            $this->data['primaryKey'] = '';
        }
        // Country Id
        if (!empty($this->input->post('country_id'))) {
            $this->data['country_id'] = $this->input->post('country_id');
        } elseif (!empty($this->map)) {
            $this->data['country_id'] = $this->map->country_id;
        } else {
            $this->data['country_id'] = '';
        }
        if (!empty($this->input->post('path_d'))) {
            $this->data['path_d'] = $this->input->post('path_d');
        } elseif (!empty($this->map)) {
            $this->data['path_d'] = $this->map->path_d;
        } else {
            $this->data['path_d'] = '';
        }
        // Status
        if ($this->input->post('status') != '') {
            $this->data['status'] = $this->input->post('status');
        } elseif($this->map) {
            $this->data['status'] = $this->map->status;
        } else {
            $this->data['status'] = 0;
        }
        //dd($this->data);
        $this->data['back']         = admin_url('map');
        $this->data['countries']      = Country_model::factory()->findAll();
    }

    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/map/Map.js');

        $this->setData();
        $this->template->content->view('map/create', $this->data);
        $this->template->publish();
    }

    public function store() {
        try {
            $this->setData();

            if ($this->isPost() && $this->validateForm()) {
                $map = Map_model::factory()->findOne(['country_id' => $this->data['country_id']]);
                if($map) {
                    Map_model::factory()->delete(['country_id' => $this->data['country_id']], true);
                }
                Map_model::factory()->insert([
                    'country_id'    => $this->data['country_id'],
                    'path_d'        => $this->data['path_d'],
                    'status'        => $this->data['status'],
                ]);

                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('map/create/'));
            }
            $this->create();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function edit($id) {
        try {
            $this->id = $id;
            $this->map = Map_model::factory()->findOne($this->id);

            if(!$this->map) {
                $this->redirect(admin_url('map'));
            }

            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/map/Map.js');

            $this->template->set_template('layout/admin');
            $this->setData();

            $this->template->content->view('map/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update($id) {
        try {
            $this->setData();
            $this->id = $id;
            $this->map = Map_model::factory()->findOne($id);
            if(!$this->map) {
                $this->setMessage('warning', $this->lang->line('text_notfound'));
                $this->redirect(admin_url('map'));
            }
            if ($this->isPost() && $this->validateForm()) {
                Map_model::factory()->update([
                    'country_id'    => $this->data['country_id'],
                    'path_d'        => $this->data['path_d'],
                    'status'        => $this->data['status'],
                ], $this->id);
                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('map/edit/'.$this->id));
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
                        Map_model::factory()->delete($id);
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

        $this->results = Map_model::factory()->findAll();
        if($this->results) {
            foreach($this->results as $result) {
                $this->rows[] = array(
                    'id'			=> $result->id,
                    'country'		=> (isset($result->country->name)) ? $result->country->name : '',
                    'isoCode'		=> (isset($result->country->iso_code_2)) ? $result->country->iso_code_2 : '',
                    'status'		=> ($result->status) ? 'Active' : 'Inactive',
                    'created_at'    => Carbon::createFromTimeStamp(strtotime($result->created_at))->diffForHumans(),
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
                $this->data[$i][] = '<td>'.$row['country'].'</td>';
                $this->data[$i][] = '<td>'.$row['isoCode'].'</td>';
                $this->data[$i][] = '<td>'.$row['created_at'].'</td>';
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
                Map_model::factory()->update([
                    'status' => $this->status,
                ], $this->id);
                $this->json['status'] = $this->lang->line('success_status');
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
        if ((strlen($this->input->post('path_d')) < 1)) {
            $this->error['path_d'] = $this->lang->line('error_path_d');
        }
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->lang->line('error_warning');
        }
        //dd($this->error);
        return !$this->error;
    }
}