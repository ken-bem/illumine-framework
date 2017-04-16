<?php namespace  WppSkeleton\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Watson\Rememberable\Rememberable;

class WpUserMeta extends Eloquent {
    use Rememberable;

    protected $table = 'users';
    public function meta(){
        return $this->hasOne(WpUser::class, 'user_id','ID');
    }
}