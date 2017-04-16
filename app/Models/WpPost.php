<?php namespace WppSkeleton\Models;
use Illuminate\Database\Eloquent\Model;

class WpPost extends Model {
    protected $table = 'posts';

    public function meta(){
        return $this->hasMany(WpPostMeta::class, 'post_id','ID');
    }
}