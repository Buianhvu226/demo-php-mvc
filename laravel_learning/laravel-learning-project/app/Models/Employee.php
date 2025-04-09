<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'company_id',
        'photo',
    ];

    /**
     * The user associated with the employee.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * The company associated with the employee.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
