<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
use Application\Contracts\QuestionContract;

class Question extends AdminController implements QuestionContract {

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


    public function __construct() {
        parent::__construct();
        $this->lang->load('admin/quiz');
        $this->lang->load('admin/question');
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
        $this->template->javascript->add('assets/js/admin/question/Question.js');

        $this->template->content->view('question/index');
        $this->template->publish();
    }

    public function setData() {

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['question'])) {
            $this->data['error_question'] = $this->error['question'];
        } else {
            $this->data['error_question'] = '';
        }
        // Question ID

        if (!empty($this->question)) {
            $this->data['id'] = $this->question->id;
        } else {
            $this->data['id'] = '';
        }
        // Quiz
        if (!empty($this->input->post('quiz'))) {
            $this->data['quizId'] = $this->input->post('quiz');
        } elseif (!empty($this->question)) {
            $this->data['quizId'] = $this->question->quiz_id;
        } else {
            $this->data['quizId'] = '';
        }

        // Name
        if (!empty($this->input->post('question'))) {
            $this->data['question'] = $this->input->post('question');
        } elseif (!empty($this->question)) {
            $this->data['question'] = $this->question->question;
        } else {
            $this->data['question'] = '';
        }


        // Status

        if ($this->input->post('status') != '') {
            $this->data['status'] = $this->input->post('status');
        } elseif($this->question) {
            $this->data['status'] = $this->question->status;
        } else {
            $this->data['status'] = 0;
        }

        // Image
        if (!empty($this->input->post('image'))) {
            $this->data['image'] = $this->input->post('image');
        } elseif (!empty($this->question)) {
            $this->data['image'] = $this->question->image;
        } else {
            $this->data['image'] = '';
        }
        if (!empty($this->input->post('image')) && is_file(DIR_IMAGE . $this->input->post('image'))) {
            $this->data['thumb'] = $this->resize($this->input->post('image'), 100, 100);
        } elseif (!empty($this->question) && is_file(DIR_IMAGE . $this->question->image)) {
            $this->data['thumb'] = $this->resize($this->question->image, 100, 100);
        } else {
            $this->data['thumb'] = $this->resize('no_image.png', 100, 100);
        }
        // Images
        if (!empty($this->input->post('images'))) {
            $images = $this->input->post('images');
        } elseif (!empty($this->questionImages)) {
            $images = $this->questionImages;
        } else {
            $images = array();
        }

        $this->data['images'] = array();

        foreach ($images as $image) {
            if (is_file(DIR_IMAGE . $image->image)) {
                $image = $image->image;
                $thumb = $image->image;
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $this->data['images'][] = array(
                'image'      => $image,
                'thumb'      => $this->resize($thumb, 100, 100)
            );
        }

        $this->data['placeholder'] = $this->resize('no_image.png', 100, 100);
        $this->data['back']         = admin_url('question');
        $this->data['quizzes']      = Quiz_model::factory()->findAll(['status' => 1]);
        //dd($this->data);
        //$this->dd($this->data);
    }

    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/question/Question.js');
        $this->template->set_template('layout/admin');
        $this->setData();
        $this->template->content->view('question/create', $this->data);
        $this->template->publish();
    }

    public function store() {
        try {
            if ($this->isPost() && $this->validateForm()) {
                $this->setData();

                Question_model::factory()->insert([
                    'question'    => $this->data['question'],
                    'quiz_id'     => $this->data['quizId'],
                    'status'      => $this->data['status'],
                ]);
                $this->setId(Question_model::factory()->getLastInsertID());

                if(isset($this->data['image'])) {
                    Question_model::factory()->update([
                        'image' => $this->data['image'],
                    ],$this->id);
                }
                /*
                if(isset($this->data['images'])) {
                    QuestionImage_model::factory()->insert([
                        'question_id' => $this->id,
                        'image' => $this->data['image']
                    ]);
                }
                */
                $this->setMessage('message', "Success: You have modified features question! ");
                $this->redirect(admin_url('question/create/'));
            }
            $this->create();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function edit($id) {
        try {
            $this->id = $id;
            $this->question = Question_model::factory()->findOne($this->id);

            if(!$this->question) {
                $this->redirect(admin_url('question'));
            }

            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/question/Question.js');

            $this->template->set_template('layout/admin');
            $this->setData();

            $this->template->content->view('question/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update($id) {
        try {
            $this->id = $id;
            $this->question = Question_model::factory()->findOne($id);
            $this->setData();
            if(!$this->question) {
                $this->setMessage('warning', $this->lang->line('text_notfound'));
                $this->redirect(admin_url('quiz'));
            }
            if ($this->isPost() && $this->validateForm()) {
//$this->dd([
//    'question'    => $this->data['question'],
//    'quiz_id'     => $this->data['quizId'],
//    'status'      => $this->data['status'],
//    'image'       => $this->data['image'],
//]);
                Question_model::factory()->update([
                    'question'    => $this->data['question'],
                    'quiz_id'     => $this->data['quizId'],
                    'status'      => $this->data['status'],
                    'image'       => $this->data['image'],
                ], $this->id);
                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('question/edit/'.$this->id));
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
                        Question_model::factory()->delete($id);
                        Answer_model::factory()->delete(['question_id ' => $id], true);
                        UserQuestionAnswer_model::factory()->delete(['question_id ' => $id], true);
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

        $this->results = Question_model::factory()->findAll();
        if($this->results) {
            foreach($this->results as $result) {
                //$this->quiz = Quiz_model::factory()->findOne($result->quiz_id);
                $this->rows[] = array(
                    'id'			=> $result->id,
                    'quiz'		    => $result->quiz->name,
                    'question'		=> $result->question,
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
                $this->data[$i][] = '<td>'.$row['quiz'].'</td>';
                $this->data[$i][] = '<td>'.$row['question'].'</td>';

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
        if ((strlen($this->input->post('question')) < 1) || (strlen(trim($this->input->post('question'))) > 255)) {
            $this->error['question'] = $this->lang->line('error_question');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->lang->line('error_warning');
        }
        //$this->dd($this->error);
        return !$this->error;
    }
}