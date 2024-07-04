<?php

namespace App\Models;

use App\CentralLogics\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\DB;

class Campaign extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => 'integer',
        'admin_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $appends = ['image_full_url'];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }

    public function getTitleAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'title') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }

    public function getDescriptionAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'description') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function getStartTimeAttribute($value)
    {
        return $value?date('H:i',strtotime($value)):$value;
    }

    public function getEndTimeAttribute($value)
    {
        return $value?date('H:i',strtotime($value)):$value;
    }
    public function stores()
    {
        return $this->belongsToMany(Store::class)->withPivot('campaign_status');
    }

    public function getImageFullUrlAttribute(){
        $value = $this->image;
        if (count($this->storage) > 0) {
            foreach ($this->storage as $storage) {
                if ($storage['key'] == 'image') {

                    if($storage['value'] == 's3'){

                        return Helpers::s3_storage_link('campaign',$value);
                    }else{
                        return Helpers::local_storage_link('campaign',$value);
                    }
                }
            }
        }

        return Helpers::local_storage_link('campaign',$value);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeModule($query, $module_id)
    {
        return $query->where('module_id', $module_id);
    }

    public function scopeRunning($query)
    {
        return $query->where(function($q){
                $q->whereDate('end_date', '>=', date('Y-m-d'))->orWhereNull('end_date');
            })->where(function($q){
                $q->whereDate('start_date', '<=', date('Y-m-d'))->orWhereNull('start_date');
            })->where(function($q){
                $q->whereTime('start_time', '<=', date('H:i:s'))->orWhereNull('start_time');
            })->where(function($q){
                $q->whereTime('end_time', '>=', date('H:i:s'))->orWhereNull('end_time');
            });
    }

    protected static function booted()
    {
        static::addGlobalScope('storage', function ($builder) {
            $builder->with('storage');
        });
        static::addGlobalScope('translate', function (Builder $builder) {
            $builder->with(['translations' => function ($query) {
                return $query->where('locale', app()->getLocale());
            }]);
        });
    }

    public function storage()
    {
        return $this->morphMany(Storage::class, 'data');
    }

    protected static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            if($model->isDirty('image')){
                $value = Helpers::getDisk();

                DB::table('storages')->updateOrInsert([
                    'data_type' => get_class($model),
                    'data_id' => $model->id,
                    'key' => 'image',
                ], [
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
