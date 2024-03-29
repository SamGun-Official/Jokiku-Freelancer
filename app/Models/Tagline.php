<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagline extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = "tagline";

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $fillable = [
        'service_id',
        'tagline',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
