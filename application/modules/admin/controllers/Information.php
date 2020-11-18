<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
use Application\Contracts\CrudContract;

class Information extends AdminController implements CrudContract {

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
     * @var object
     */
    private $information;


    public function __construct() {
        parent::__construct();
        $this->lang->load('admin/information');
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
        $this->template->javascript->add('assets/js/admin/information/Information.js');

        $this->template->content->view('information/index');
        $this->template->publish();
    }

    public function setData() {
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (isset($this->error['title'])) {
            $this->data['error_title'] = $this->error['title'];
        } else {
            $this->data['error_title'] = '';
        }
        if (isset($this->error['heading'])) {
            $this->data['error_heading'] = $this->error['heading'];
        } else {
            $this->data['error_heading'] = '';
        }
        if (isset($this->error['meta_title'])) {
            $this->data['error_meta_title'] = $this->error['meta_title'];
        } else {
            $this->data['error_meta_title'] = '';
        }
        if (isset($this->information)) {
            $this->data['primaryKey'] = $this->information->id;
        } else {
            $this->data['primaryKey'] = '';
        }
        // Title
        if (!empty($this->input->post('title'))) {
            $this->data['title'] = $this->input->post('title');
        } elseif (!empty($this->information)) {
            $this->data['title'] = $this->information->title;
        } else {
            $this->data['title'] = '';
        }

        // Title
        if (!empty($this->input->post('heading'))) {
            $this->data['heading'] = $this->input->post('heading');
        } elseif (!empty($this->information)) {
            $this->data['heading'] = $this->information->heading;
        } else {
            $this->data['heading'] = '';
        }
        // Description
        if (!empty($this->input->post('body'))) {
            $this->data['body'] = $this->input->post('body');
        } elseif (!empty($this->information)) {
            $this->data['body'] = $this->information->body;
        } else {
            $this->data['body'] = '';
        }
        // Status

        if ($this->input->post('status') != '') {
            $this->data['status'] = $this->input->post('status');
        } elseif(!empty($this->information)) {
            $this->data['status'] = $this->information->status;
        } else {
            $this->data['status'] = 0;
        }
        // Slug
        if (!empty($this->input->post('slug'))) {
            $this->data['slug'] = url_title($this->input->post('title'),'dash', true);
        } elseif (!empty($this->information)) {
            $this->data['slug'] = ($this->information->slug) ? $this->information->slug : url_title($this->input->post('title'),'dash', true);;
        } else {
            $this->data['slug'] = url_title($this->input->post('title'),'dash', true);
        }
        // Description
        if (!empty($this->input->post('meta_title'))) {
            $this->data['meta_title'] = $this->input->post('meta_title');
        } elseif (!empty($this->information)) {
            $this->data['meta_title'] = $this->information->meta_title;
        } else {
            $this->data['meta_title'] = '';
        }
        // Description
        if (!empty($this->input->post('meta_keyword'))) {
            $this->data['meta_keyword'] = $this->input->post('meta_keyword');
        } elseif (!empty($this->information)) {
            $this->data['meta_keyword'] = $this->information->meta_keyword;
        } else {
            $this->data['meta_keyword'] = '';
        }
        // Description
        if (!empty($this->input->post('meta_description'))) {
            $this->data['meta_description'] = $this->input->post('meta_description');
        } elseif (!empty($this->information)) {
            $this->data['meta_description'] = $this->information->meta_description;
        } else {
            $this->data['meta_description'] = '';
        }
        //dd($this->data);
        $this->data['back']         = admin_url('information');
    }

    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/information/Information.js');

        $this->setData();
        $this->template->content->view('information/create', $this->data);
        $this->template->publish();
    }

    public function store() {
        try {
            $this->setData();
            if ($this->isPost() && $this->validateForm()) {
                Information_model::factory()->insert([
                    'title'             => $this->data['title'],
                    'heading'           => $this->data['heading'],
                    'body'              => $this->data['body'],
                    'slug'              => $this->data['slug'],
                    'status'            => $this->data['status'],
                    'meta_title'        => $this->data['meta_title'],
                    'meta_keyword'      => $this->data['meta_keyword'],
                    'meta_description'  => $this->data['meta_description'],
                ]);
                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('information/create/'));
            }
            $this->create();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function edit($id) {
        try {
            $this->id = $id;
            $this->information = Information_model::factory()->findOne($this->id);

            if(!$this->information) {
                $this->redirect(admin_url('information'));
            }

            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/information/Information.js');

            $this->template->set_template('layout/admin');
            $this->setData();
            //$this->dd($this->infromation->title);
            $this->template->content->view('information/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update($id) {
        try {
            $this->setData();
            $this->id = $id;
            $this->plan = Information_model::factory()->findOne($id);
            if(!$this->plan) {
                $this->setMessage('warning', $this->lang->line('text_notfound'));
                $this->redirect(admin_url('information'));
            }
            if ($this->isPost() && $this->validateForm()) {
                Information_model::factory()->update([
                    'title'             => $this->data['title'],
                    'heading'           => $this->data['heading'],
                    'body'              => $this->data['body'],
                    'slug'              => $this->data['slug'],
                    'status'            => $this->data['status'],
                    'meta_title'        => $this->data['meta_title'],
                    'meta_keyword'      => $this->data['meta_keyword'],
                    'meta_description'  => $this->data['meta_description'],
                ], $this->id);
                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('information/edit/'.$this->id));
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
                        Information_model::factory()->delete($id);
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

        $this->results = Information_model::factory()->findAll();
        if($this->results) {
            foreach($this->results as $result) {
                $this->rows[] = array(
                    'id'			=> $result->id,
                    'title'		    => $result->title,
                    'slug'		    => $result->slug,
                    'status'		=> $result->status,
                    'created_at'    => Carbon::createFromTimeStamp(strtotime($result->created_at))->diffForHumans(),
                    'updated_at'    => ($result->updated_at) ? Carbon::createFromTimeStamp(strtotime($result->updated_at))->diffForHumans() : ''
                );
            }
            $i = 0;
            foreach($this->rows as $row) {
                $selected = ($row['status'] == 1) ? 'selected' : '';
                $this->data[$i][] = '<td class="text-center">
											<label class="css-control css-control-primary css-checkbox">
												<input data-id="'.$row['id'].'" type="checkbox" class="css-control-input selectCheckbox" id="row_'.$row['id'].'" name="row_'.$row['id'].'">
												<span class="css-control-indicator"></span>
											</label>
										</td>';
                $this->data[$i][] = '<td>'.$row['title'].'</td>';
                $this->data[$i][] = '<td>'.$row['slug'].'</td>';
                $this->data[$i][] = '<td>
                                            <select data-id="'.$row['id'].'" name="status" class="select floating onChangeStatus" id="input-payment-status" >
                                                <option value="0" '.$this->selected.'>Inactive</option>
                                                <option value="1" '.$this->selected.'>Active</option>
                                            </select>
                                        </td>';
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



    public function validateForm()
    {
        // TODO: Implement validateForm() method.
        if ((strlen($this->input->post('title')) < 1) || (strlen(trim($this->input->post('title'))) > 255)) {
            $this->error['title'] = $this->lang->line('error_title');
        }
        if ((strlen($this->input->post('heading')) < 1) || (strlen(trim($this->input->post('heading'))) > 255)) {
            $this->error['heading'] = $this->lang->line('error_heading');
        }
        if ((strlen($this->input->post('meta_title')) < 1) || (strlen(trim($this->input->post('meta_title'))) > 255)) {
            $this->error['meta_title'] = $this->lang->line('error_meta_title');
        }
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->lang->line('error_warning');
        }
        //$this->dd($this->error);
        return !$this->error;
    }
    public function onChangeStatusEventHandler() {
        try {
            if($this->isAjaxRequest()) {
                $this->id       = ($this->input->post('id')) ? $this->input->post('id') : '';
                $this->status   = ($this->input->post('status')) ? $this->input->post('status') : '';
                Information_model::factory()->update([
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
}