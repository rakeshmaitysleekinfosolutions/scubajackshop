<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class UserQuestionAnswer_model extends BaseModel {


    protected $table = "users_questions_answers";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new UserQuestionAnswer_model($attr);
    }

    public function user() {
        return $this->hasOne(User_model::class, 'id', 'user_id');
    }
    public function question() {
        return $this->hasOne(Question_model::class, 'id', 'question_id');
    }
    public function answer() {
        return $this->hasOne(Answer_model::class, 'id', 'answer_id');
    }
}
