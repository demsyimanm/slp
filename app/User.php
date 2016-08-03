<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract 
{
    use Authenticatable, CanResetPassword;


    protected $table = 'user';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
    	'nip', 
    	'username', 
    	'password',
    	'role_id',
    	'nama',
        'email',
    	'remember_token'
    ];
    protected $SoftDelete = true;
    protected $dates = ['deleted_at'];

    public function history()
	{
		return $this->hasMany('App\History');
	}

	public function project()
	{
		return $this->hasMany('App\Project');
	}

	public function role()
	{
		return $this->belongsTo('App\Role');
	}


}
