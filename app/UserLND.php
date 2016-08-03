<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLND extends Model
{
    protected $table = 'userlnd';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
    	'nip',
    	'nama',
    	'email',		 
    ];
    protected $SoftDelete = true;
    protected $dates = ['deleted_at'];
}
