<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Modules\Admin\Entities\MakhrajCategory
 *
 * @property int $id
 * @property string $uuid
 * @property string $name_english
 * @property string $name_arabic
 * @property string $name_urdu
 * @property string $description_english
 * @property string $description_urdu
 * @property string|null $icon
 * @property int $display_order
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class MakhrajCategory extends Model
{
    use SoftDeletes;

    protected $table = 'makharij_categories';
    protected $guarded = [];

    protected $casts = [
        'display_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the Arabic letters in this category
     */
    public function arabicLetters()
    {
        return $this->hasMany(ArabicLetter::class, 'makhraj_category', 'name_english');
    }

    /**
     * Scope to order by display order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }
}
