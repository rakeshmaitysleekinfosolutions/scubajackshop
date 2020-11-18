<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Continent_model extends BaseModel {
    
    protected $table = "continents";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Continent_model($attr);
    }
    public function country() {
        return $this->hasOne(Country_model::class, 'id', 'country_id');
    }
}