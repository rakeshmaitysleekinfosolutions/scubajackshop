<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Carbon\Carbon;
use Application\Contracts\AnswerContract;

class Answer extends AdminController implements AnswerContract {

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


    public function __construct() {
        parent::__construct();
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
        $this->template->javascript->add('assets/js/admin/answer/Answer.js');

        $this->template->content->view('answer/index');
        $this->template->publish();
    }

    public function setData() {
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (isset($this->error['answer'])) {
            $this->data['error_answer'] = $this->error['answer'];
        } else {
            $this->data['error_answer'] = '';
        }
        // Answer ID
        if (!empty($this->answer)) {
            $this->data['primaryKey'] = $this->answer->id;
        } else {
            $this->data['primaryKey'] = '';
        }
        // Question Id
        if (!empty($this->input->post('question'))) {
            $this->data['questionId'] = $this->input->post('question');
        } elseif (!empty($this->answer)) {
            $this->data['questionId'] = $this->answer->question_id;
        } else {
            $this->data['questionId'] = '';
        }
        // Answer


        if (!empty($this->input->post('answer'))) {
            $this->data['answer'] = $this->input->post('answer');
        } elseif (!empty($this->answer)) {
            $this->data['answer'] = $this->answer->answer;
        } else {
            $this->data['answer'] = '';
        }
        // Is Correct
        if ($this->input->post('isCorrect') != '') {
            $this->data['isCorrect'] = $this->input->post('isCorrect');
        } elseif($this->answer) {
            $this->data['isCorrect'] = $this->answer->is_correct;
        } else {
            $this->data['isCorrect'] = 0;
        }
        // Answers
        if (!empty($this->input->post('answers'))) {
            $answers = $this->input->post('answers');
        } elseif (!empty($this->answers)) {
            $answers = $this->answers;
        } else {
            $answers = array();
        }
        $this->data['answers'] = array();
        if(!empty($answers)) {
            $this->data['answers'] = $answers;
        }
        //dd($this->data);
        $this->data['back']         = admin_url('answer');
        $this->data['questions']    = Question_model::factory()->findAll(['status' => 1]);
    }

    public function create() {
        $this->template->javascript->add('assets/js/jquery.validate.js');
        $this->template->javascript->add('assets/js/additional-methods.js');
        $this->template->javascript->add('assets/js/admin/answer/Answer.js');

        $this->setData();
        $this->template->content->view('answer/create', $this->data);
        $this->template->publish();
    }

    public function store() {
        try {
            $this->setData();
            if ($this->isPost() && $this->validateForm()) {
                Answer_model::factory()->delete(['question_id' => $this->data['questionId']], true);
                Answer_model::factory()->insert([
                    'answer'        => $this->data['answer'],
                    'question_id'   => $this->data['questionId'],
                    'is_correct'    => $this->data['isCorrect'],
                    'correct_index' => 0
                ]);
                if(isset($this->data['answers'])) {
                    $index = 1;
                    foreach ($this->data['answers'] as $answer) {
                        Answer_model::factory()->insert([
                            'answer'        => $answer['answer'],
                            'question_id'   => $this->data['questionId'],
                            'correct_index' => $index
                        ]);
                        $index++;
                    }
                }
                $this->setMessage('message', "Success: You have modified answer! ");
                $this->redirect(admin_url('answer/create/'));
            }
            $this->create();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }

    public function edit($id) {
        try {
            $this->id = $id;
            $this->answer = Answer_model::factory()->findOne($this->id);

            if(!$this->answer) {
                $this->redirect(admin_url('answer'));
            }

            $this->template->javascript->add('assets/js/jquery.validate.js');
            $this->template->javascript->add('assets/js/additional-methods.js');
            $this->template->javascript->add('assets/js/admin/answer/Answer.js');

            $this->template->set_template('layout/admin');
            $this->setData();

            $this->template->content->view('answer/edit', $this->data);
            $this->template->publish();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function update($id) {
        try {
            $this->setData();
            $this->id = $id;
            $this->answer = Answer_model::factory()->findOne($id);
            if(!$this->answer) {
                $this->setMessage('warning', $this->lang->line('text_notfound'));
                $this->redirect(admin_url('answer'));
            }
            if ($this->isPost() && $this->validateForm()) {
                Answer_model::factory()->update([
                    'answer'        => $this->data['answer'],
                    'question_id'   => $this->data['questionId'],
                    'is_correct'    => $this->data['isCorrect'],
                ], $this->id);
                $this->setMessage('message', $this->lang->line('text_success'));
                $this->redirect(admin_url('answer/edit/'.$this->id));
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
                        Answer_model::factory()->delete($id);
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

        $this->results = Answer_model::factory()->findAll();
        if($this->results) {
            foreach($this->results as $result) {
                $this->rows[] = array(
                    'id'			=> $result->id,
                    'question'		=> ($result->question) ? $result->question->question : '',
                    'answer'		=> $result->answer,
                    'isCorrect'		=> ($result->is_correct) ? 'YES' : 'NO',
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
                $this->data[$i][] = '<td>'.$row['question'].'</td>';
                $this->data[$i][] = '<td>'.$row['answer'].'</td>';
                $this->data[$i][] = '<td>'.$row['isCorrect'].'</td>';
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
//$this->dd($this->data);

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
        if ((strlen($this->input->post('answer')) < 1) || (strlen(trim($this->input->post('answer'))) > 255)) {
            $this->error['answer'] = "Required";
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->lang->line('error_warning');
        }
        //$this->dd($this->error);
        return !$this->error;
    }
}