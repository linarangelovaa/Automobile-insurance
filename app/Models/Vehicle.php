<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['brand', 'model', 'plate_number', 'date', 'deleted_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
