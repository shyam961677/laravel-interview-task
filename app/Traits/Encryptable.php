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

            // echo "SELECT AES_ENCRYPT('$value', '".env('ENCRYPTION_KEY')."') as column_value";die;
                
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

}