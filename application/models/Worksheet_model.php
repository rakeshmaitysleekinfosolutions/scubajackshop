<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Worksheet_model extends BaseModel {
    
    protected $table = "worksheets";

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

    public static function factory($attr = array()) {
        return new Worksheet_model($attr);
    }
    public function worksheetDescription() {
        return $this->hasMany(WorksheetDescription_model::class, 'worksheet_id', 'id');
    }
    public function totalWorksheets() {
        return $this->hasMany(WorksheetDescription_model::class, 'worksheet_id', 'id');
    }
    public function worksheets($worksheet_id) {
        return WorksheetDescription_model::factory()->find()->where('worksheet_id', $worksheet_id)->order_by('sort_order','ASC')->get()->result_array();
    }
}