<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Agreement_model extends BaseModel {


    protected $table = "agreements";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Agreement_model($attr);
    }



}
