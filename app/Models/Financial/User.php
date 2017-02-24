<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $connection = 'mysql_financial';
	
	protected $table = 'users';
	
}
