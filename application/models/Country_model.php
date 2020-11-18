<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Country_model extends BaseModel {
    
    protected $table = "country";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Mainstream creating field name
    const CREATED_AT = 'created_at';

    // Mainstream updating field name
    const UPDATED_AT = 'updated_at';

    // Use unixtime for saving datetime
    protected $dateFormat = 'datetime';

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    // 0: actived, 1: deleted
    protected $recordDeletedFalseValue = '1';

    protected $recordDeletedTrueValue = '0';

    
    public static function factory($attr = array()) {
        return new Country_model($attr);
    }

    public function states() {
        return $this->hasMany('State_model', 'country_id', 'id')->get()->result_object();
    }

    public function getCountryByIsoCode($isoCode) {
        return $this->find()->where('iso_code_2', $isoCode)->get()->row_object();
    }

    public function continent() {
        return $this->hasOne(Continent_model::class, 'id', 'continent_id');
    }
    
   
    
}