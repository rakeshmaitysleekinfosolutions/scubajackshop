<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Quiz_model extends BaseModel {


    protected $table = "quizzes";

    protected $primaryKey = 'id';

    protected $timestamps = true;

    // Record status for checking is deleted or not
    const SOFT_DELETED = 'is_deleted';

    public static function factory($attr = array()) {
        return new Quiz_model($attr);
    }

    private function deleteQuizRelatedModels($foreignKey, $forceDelete = false) {
        if($forceDelete) {
            $this->db->query("DELETE FROM questions WHERE  quiz_id = '" . (int)$foreignKey . "'");
        }
        $this->db->query("UPDATE questions SET is_deleted = 1 WHERE quiz_id = '" . (int)$foreignKey . "'");
    }
    private function updateQuizRelatedModels($foreignKey, $data = array()) {
        $this->db->query("INSERT INTO questions SET quiz_id = '" . (int)$foreignKey . "'");
    }
    public function drop($localeKey, $forceDelete = false) {
        if($forceDelete) {
            $this->delete($localeKey, true);
            $this->deleteQuizRelatedModels($localeKey, true);
        }
        $this->delete($localeKey);
        $this->deleteQuizRelatedModels($localeKey, false);
    }

}
