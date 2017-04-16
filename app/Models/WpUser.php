<?php namespace  WppSkeleton\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Watson\Rememberable\Rememberable;

class WpUser extends Eloquent {
    use Rememberable;

    protected $table = 'users';
    public $timestamps = false;
    protected $primaryKey = 'ID';
    protected $fillable = ['display_name'];
    protected $guarded = ['ID'];
//    protected $dateFormat = 'U';
//    const CREATED_AT = 'creation_date';
//    const UPDATED_AT = 'last_update';

    public function meta(){
        return $this->hasMany(WpUserMeta::class, 'ID','user_id');
    }
    public static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            self::flushCache();
            return $model;
        });
    }
}