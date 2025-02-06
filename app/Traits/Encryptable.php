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

}