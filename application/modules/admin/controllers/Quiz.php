<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
use Application\Contracts\QuizContract;

class Quiz extends AdminController implements QuizContract {

    /**
     * @var object
     */
    private $quiz;
    /**
     * @var string
     */
    private $status;


    public function __construct()
    {
        $this->lang->load('admin/quiz');
    }

    private $quizzes;
    /**
     * @var string
     */
    public function index() {
        $this->template->set_template('layout/admin');

        $this->template->stylesheet->add('assets/theme/light/js/datatables/dataTables.bootstrap4.css');
        $this->template->javascript->add('assets/theme/light/js/datatables/jquery.dataTables.min.js');
        $this->template->javascript->add('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js');
        $this->template->javascript->add('assets/js/admin/quiz/Quiz.js');

        $this->template->content->view('quiz/index');
        $this->template->publish();
    }

    public function setData() {
        try {
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

            if (isset($this->error['slug'])) {
                $this->data['error_slug'] = $this->error['slug'];
            } else {
                $this->data['error_slug'] = '';
            }

            if (isset($this->error['status'])) {
                $this->data['error_status'] = $this->error['status'];
            } else {
                $this->data['error_status'] = '';
            }
            // Quiz ID
            if (!empty($this->input->post('id'))) {
                $this->data['id'] = $this->input->post('id');
            } elseif (!empty($this->quiz)) {
                $this->data['id'] = $this->quiz->id;
            } else {
                $this->data['id'] = '';
            }
            // Name
            if (!empty($this->input->post('name'))) {
                $this->data['name'] = $this->input->post('name');
            } elseif (!empty($this->quiz)) {
                $this->data['name'] = $this->quiz->name;
            } else {
                $this->data['name'] = '';
            }
            // Slug
            if (!empty($this->input->post('slug'))) {
                $this->data['slug'] = url_title($this->input->post('name'),'dash', true);
            } elseif (!empty($this->quiz)) {
                $this->data['slug'] = ($this->quiz->slug) ? $this->quiz->slug  : url_title($this->input->post('name'),'dash', true);
            } else {
                $this->data['slug'] = url_title($this->input->post('name'),'dash', true);
            }
            // Status
            // Status
            if (!empty($this->input->post('status'))) {
                $this->data['status'] = $this->input->post('status');
            } elseif (!empty($this->quiz)) {
                $this->data['status'] = $this->quiz->status;
            } else {
                $this->data['status'] = 0;
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
            $this->data['back']         = admin_url('quiz');
            //dd($this->data);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/quiz/Quiz.js');
        $this->template->set_template('layout/admin');
        $this->setData();
        $this->template->content->view('quiz/create', $this->data);
        $this->template->publish();
    }

    public function store() {
        try {
            if ($this->isPost() && $this->validateForm()) {
                $this->setData();

                Quiz_model::factory()->insert([
                    'name'      => $this->data['name'],
                    'slug'      => $this->data['slug'],
                    'status'    => $this->data['status'],
                ]);
                $this->setMessage('message', "Success: You have modified features product! ");
                $this->redirect(admin_url('quiz/create/'));
            }
            $this->create();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function edit($id) {
        try {
            $this->id = $id;
            $this->quiz = Quiz_model::factory()->findOne($this->id);

            if(!$this->quiz) {
                $this->redirect(admin_url('quiz'));
            }
            $this->setData();
            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/product/FeaturesProduct.js');

            $this->template->set_template('layout/admin');
            $this->template->content->view('quiz/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update($id) {
        try {
            $this->id = $id;
            $this->quiz = Quiz_model::factory()->findOne($id);
            if(!$this->quiz) {
                $this->setMessage('warning', $this->lang->line('text_notfound'));
                $this->redirect(admin_url('quiz'));
            }
            if ($this->isPost() && $this->validateForm()) {
                $this->setData();
                //dd($this->data);
                Quiz_model::factory()->update([
                    'name'      => $this->data['name'],
                    'slug'      => $this->data['slug'],
                    'status'    => $this->data['status'],
                ], $this->id);

                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('quiz/edit/'.$this->id));
            }
            $this->setData();
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
                        Quiz_model::factory()->drop($id);
                        Question_model::factory()->delete(['quiz_id' => $id], true);
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

        $this->results = Quiz_model::factory()->findAll();
        if($this->results) {
            foreach($this->results as $result) {
                $this->rows[] = array(
                    'id'			=> $result->id,
                    'name'		    => $result->name,
                    'slug'		    => $result->slug,
                    'status' 		=> ($result->status && $result->status == 1) ? 1 : 0,
                    'created_at'    => Carbon::createFromTimeStamp(strtotime($result->created_at))->diffForHumans(),
                    'updated_at'    => ($result->updated_at) ? Carbon::createFromTimeStamp(strtotime($result->updated_at))->diffForHumans() : ''
                );
            }
            $i = 0;
            foreach($this->rows as $row) {
                $this->selected = ($row['status'] == 1) ? 'selected' : '';
                $this->data[$i][] = '<td class="text-center">
											<label class="css-control css-control-primary css-checkbox">
												<input data-id="'.$row['id'].'" type="checkbox" class="css-control-input selectCheckbox" id="row_'.$row['id'].'" name="row_'.$row['id'].'">
												<span class="css-control-indicator"></span>
											</label>
										</td>';
                $this->data[$i][] = '<td>'.$row['name'].'</td>';
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
        if ((strlen($this->input->post('name')) < 1) || (strlen(trim($this->input->post('name'))) > 255)) {
            $this->error['name'] = $this->lang->line('error_name');
        }
        if ($this->input->post('status') == '') {
            $this->error['status'] = $this->lang->line('error_status');
        }
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->lang->line('error_warning');
        }
        return !$this->error;
    }
}