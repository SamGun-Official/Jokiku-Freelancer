<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    // use HasFactory;
    use SoftDeletes;


    public $table = "review";


    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    protected $fillable = [
        'service_id',
        'users_id',
        'comment',
        'rating',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id','id');
    }

}
