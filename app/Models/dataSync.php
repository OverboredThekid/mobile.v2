<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dataSync extends Model
{
    
    protected $fillable = ['key', 'fetched_at', 'etag'];

    
}
