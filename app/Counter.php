<?php

namespace App;
use App\Uploads;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = [
        'view', 'upload_id' , 'id'
    ];

    public function upload()
    {
        return $this->belongsTo(Uploads::class, 'upload_id');
    }

    
}
