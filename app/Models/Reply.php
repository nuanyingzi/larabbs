<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Topic;
use App\Models\User;

class Reply extends Model
{
    use HasFactory;
    
    protected $fillable = ['content'];


    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
