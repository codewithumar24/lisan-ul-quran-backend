<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Modules\Admin\Entities\TajweedRule
 *
 * @property int $id
 * @property string $uuid
 * @property string $rule_category
 * @property string $rule_name_english
 * @property string $rule_name_arabic
 * @property string $rule_name_urdu
 * @property string $description_english
 * @property string $description_urdu
 * @property string|null $color_code
 * @property array $applicable_letters
 * @property string $application_method_english
 * @property string $application_method_urdu
 * @property array|null $examples
 * @property string|null $audio_explanation
 * @property int $difficulty_level
 * @property int $display_order
 * @property bool $is_basic
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class TajweedRule extends Model
{
    use SoftDeletes;

    protected $table = 'tajweed_rules';
    protected $guarded = [];

    protected $casts = [
        'applicable_letters' => 'array',
        'examples' => 'array',
        'difficulty_level' => 'integer',
        'display_order' => 'integer',
        'is_basic' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the lessons that use this rule
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_tajweed_rule');
    }

    /**
     * Scope to order by display order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    /**
     * Scope to filter by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('rule_category', $category);
    }

    /**
     * Scope to get basic rules only
     */
    public function scopeBasic($query)
    {
        return $query->where('is_basic', true);
    }

    /**
     * Scope to filter by difficulty level
     */
    public function scopeByDifficulty($query, int $level)
    {
        return $query->where('difficulty_level', $level);
    }
}
