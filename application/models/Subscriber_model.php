<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Subscriber_model extends BaseModel {


    protected $table = "membership_plans_subscribers";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Subscriber_model($attr);
    }

    public function user() {
        return $this->hasOne(User_model::class, 'id', 'user_id');
    }
    public function plan() {
        return $this->hasOne(Membershipplan_model::class, 'id', 'membership_plan_id');
    }

}
