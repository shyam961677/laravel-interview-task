<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use \App\Traits\Encryptable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Encryptable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'image', 'mobile', 'date', 'role'
    ];

    protected static $encryptable = [
        'name',
        'email',
        'image',
        'mobile',
        'date'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function __find($id){

        return User::selectRaw('*')->selectRaw( User::decryptableColumnsMapping() )->find($id);
    }

    public static function sessionAllUsers(){

        return session('userSessionArray', []);
    }

    public static function sessionFindUser($id){

        $userSessionArray = session('userSessionArray', []);
        return $userSessionArray[$id] ?? abort(404);
    }

    public static function decryptableColumnsMapping($columns = []){

        if(empty($columns)){
            $columns = self::$encryptable;
        }

        $selectColumnArr = [];

        if(isset($columns) && !empty($columns)){

            foreach ($columns as $key => $column) {

                $selectColumnArr[] = "AES_DECRYPT(".$column.", '".env('ENCRYPTION_KEY')."') as ".$column;
                
            }
        }

        return implode(",",  $selectColumnArr );
        
    }
}
