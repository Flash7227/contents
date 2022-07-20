<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uploads extends Model
{
    protected $guarded = [];
    protected $appends = ['download'];

    public function getDownloadAttribute(){
        if(isset($this->attributes['url'])){
            if($this->attributes['url'] != null){
                return '/storage/uploads/' . $this->attributes['url'];
            }
        }
    }
}
