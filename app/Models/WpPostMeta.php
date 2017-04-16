<?php namespace  WppSkeleton\Models;

use Illuminate\Database\Eloquent\Model;

class WpPostMeta extends Model {
    protected $table = 'postmeta';

    public static function boot()
    {
        parent::boot();

        static::creating(function($post)
        {
            //$post->created_by = Auth::user()->id;
            //$post->updated_by = Auth::user()->id;
        });

        static::updating(function($post)
        {
            // $post->updated_by = Auth::user()->id;
        });
    }
    public function post(){
        $this->hasOne(WpPage::class,'ID', 'post_id');
    }
}
