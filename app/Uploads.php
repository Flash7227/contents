<?php

namespace App;
use App\User;
use App\Counter;
use App\Logmaker;
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
    public function counter()
    {
        return $this->hasMany(Counter::class, 'upload_id');
    }
    public function log()
    {
        return $this->hasMany(Logmaker::class, 'upload_id');
    }
}
