<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BaseModel extends yidas\Model {
    public function baseFunc() {
        return 'baseFunc';
    }
//    public function toArray() {
//        $vars = get_object_vars ( $this );
//        $array = array ();
//        foreach ( $vars as $key => $value ) {
//            $array [ltrim ( $key, '_' )] = $value;
//        }
//        return $array;
//    }
    
}

	