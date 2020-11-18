<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Answer_model extends BaseModel {


    protected $table = "answers";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Answer_model($attr);
    }

    public function question() {
        return $this->hasOne(Question_model::class, 'id', 'question_id');
    }
}
