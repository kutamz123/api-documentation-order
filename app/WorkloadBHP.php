<?php

namespace App;

use App\Casts\DefaultValueCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkloadBHP extends Model
{
    use HasFactory;

    protected $primaryKey = "pk";

    protected $fillable = [
        'uid',
        'acc',
        'film_small',
        'film_medium',
        'film_large',
        'film_reject_small',
        'film_reject_medium',
        'film_reject_large',
        're_photo',
        'kv',
        'mas'
    ];

    protected $table = "xray_workload_bhp";


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'film_small' => DefaultValueCast::class,
        'film_medium' => DefaultValueCast::class,
        'film_large' => DefaultValueCast::class,
        'film_reject_small' => DefaultValueCast::class,
        'film_reject_medium' => DefaultValueCast::class,
        'film_reject_large' => DefaultValueCast::class,
        're_photo' => DefaultValueCast::class,
        'kv' => DefaultValueCast::class,
        'mas' => DefaultValueCast::class
    ];

    public function workload()
    {
        return $this->hasOne(Workload::class, 'uid', 'uid');
    }
}
