<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'max_credit'];

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }
}

