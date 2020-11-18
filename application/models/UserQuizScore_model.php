<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class UserQuizScore_model extends BaseModel {


    protected $table = "users_quiz_scores";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new UserQuizScore_model($attr);
    }
    public function user() {
        return $this->hasOne(User_model::class, 'id', 'user_id');
    }

}
