<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class CountryDescription_model extends BaseModel {
    
    protected $table = "country_descriptions";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new CountryDescription_model($attr);
    }
    public function country() {
        return $this->hasOne(Country_model::class, 'id', 'country_id');
    }
    public function blogs() {
        return $this->hasMany(CountryDescriptionBlog_model::class, 'country_descriptions_id', 'id');
    }
    public function countBlogs() {
        return $this->hasMany(CountryDescriptionBlog_model::class, 'country_descriptions_id', 'id')->count_all();
    }
}