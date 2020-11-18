<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Question_model extends BaseModel {


    protected $table = "questions";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Question_model($attr);
    }

    public function quiz() {
        return $this->hasOne(Quiz_model::class, 'id', 'quiz_id');
    }
    public function questionImage() {
        return $this->hasOne(QuestionImage_model::class, 'question_id', 'id');
    }
    public function answers() {
        $answers = $this->hasMany(Answer_model::class, 'question_id', 'id')->select('answer')->get()->result_array();
        $optionAnswers = array();
        if($answers) {
            foreach ($answers as $answer) {
                $optionAnswers[] = $answer['answer'];
            }
        }
        return $optionAnswers;
    }
    public function answer() {
        return $this->hasOne(Answer_model::class, 'question_id', 'id');
    }
    public function getCorrectIndex()
    {
    }
}
