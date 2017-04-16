<?php namespace  WppSkeleton\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Watson\Rememberable\Rememberable;

class WpPage extends Eloquent {
    use Rememberable;

    protected $table = 'posts';
//
//    public static function boot()
//    {
//        parent::boot();
//
//        static::creating(function($post)
//        {
//
//        });
//
//        static::updating(function($post)
//        {
//
//        });
//
//        static::saving(function($post)
//        {
//
//        });
//        static::addGlobalScope('age', function (Builder $builder) {
//            $builder->where('age', '>', 200);
//        });

   // }


    public function meta(){
        return $this->hasMany(WpPostMeta::class, 'post_id','ID');
    }
}
