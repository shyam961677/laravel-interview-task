<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use DB;

trait Encryptable {

    /**
     * If the attribute is in the encryptable array
     * then encrypt it.
     *
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value) {

        if ( !empty($value) && in_array($key, self::$encryptable) ) {

            $record = DB::select("SELECT AES_ENCRYPT('$value', '".env('ENCRYPTION_KEY')."') as column_value");
            
            if (isset($record[0]->column_value)) {

                $value = $record[0]->column_value;
            }
        }

        return parent::setAttribute($key, $value);
    }

    function hexentities($str) {
        
		$return = '';
		for($i = 0; $i < strlen($str); $i++) {
			$return .= '&#x'.bin2hex(substr($str, $i, 1)).';';
		}
		return $return;
	}
  
    /**
     * When need to make sure that we iterate through
     * all the keys.
     *
     * @return array
     */
    /*public function attributesToArray1() {

        $attributes = parent::attributesToArray();

        // dd(self::$encryptable);
        
        foreach (self::$encryptable as $key) {
           
            // dd($attributes[$key]);

            if (array_key_exists($key, $attributes)) {
            
                $record = DB::select("SELECT AES_DECRYPT('$attributes[$key]', '".\Helper::getEncryptionKey()."') as column_value");
                
                // dd($record);

                if (isset($record[0]->column_value)) {

                    $attributes[$key] = $record[0]->column_value;
                }
            }
        }
        
        return $attributes;
    }*/

}