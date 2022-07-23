<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Uploads extends Model
{
    protected $guarded = [];
    protected $appends = ['download'];

    public function getDownloadAttribute(){
        if(isset($this->attributes['url'])){
            if($this->attributes['url'] != null){
                if($this->attributes['url'] == 'noimage123.png'){
                    return '/include/noimage123.png';
                }
                return '/storage/uploads/' . $this->attributes['url'];
            }
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
