<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
    	'rolenama' 		 
    ];
    protected $SoftDelete = true;
    protected $dates = ['deleted_at'];


	public function user()
	{
		return $this->hasMay('App\User');
	}
}
