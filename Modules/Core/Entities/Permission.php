<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Permission extends Model
{
    use SoftDeletes;

    protected $table = 'permissions';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
            $model->slug = Str::slug($model->name);
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
