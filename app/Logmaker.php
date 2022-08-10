<?php

namespace App;

use App\User;
use App\Uploads;
use Illuminate\Database\Eloquent\Model;

class Logmaker extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function upload()
    {
        return $this->belongsTo(Uploads::class, 'upload_id');
    }
}
