<?php

namespace App\Helpers;

class CommonHelper 
{
   
    /**
     * Id_encode
     *
     * This function to encode ID by a custom number
     * @param string
     *  
     */

    public static function encodeID($id) {
        $encode_id = '';
        if ($id) {
            $encode_id = rand(1111, 9999) . (($id + 19)) . rand(1111, 9999);
        } else {
            $encode_id = '';
        }
        return $encode_id;
    }

    /* End of function */

    /**
     * Id_decode
     *
     * This function to decode ID by a custom number
     * @param string
     *  
     */

    public static function decodeID($encoded_id) {
        $id = '';
        if ($encoded_id) {
            $id = substr($encoded_id, 4, strlen($encoded_id) - 8);
            $id = $id - 19;
        } else {
            $id = '';
        }
        return $id;
    }
}