<?php

namespace App;
use App\Uploads;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    public function upload()
    {
        return $this->belongsTo(Uploads::class, 'upload_id');
    }
}
