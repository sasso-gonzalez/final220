<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AdminRolesController;
use App\Http\Controllers\AuthenticatedSessionController; //not sure if needed this for switch cases for login -serena

class Role extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'role';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'role', 
        'access_level'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role', 'role');
    }
}
