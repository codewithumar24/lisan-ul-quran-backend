<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Modules\Admin\Entities\ArabicLetter
 *
 * @property int $id
 * @property string $uuid
 * @property string $letter_arabic
 * @property string $letter_name_arabic
 * @property string $letter_name_urdu
 * @property string $letter_name_english
 * @property string $makhraj_category
 * @property string $makhraj_description_urdu
 * @property string $makhraj_description_english
 * @property string $pronunciation_tips_urdu
 * @property string $pronunciation_tips_english
 * @property string|null $audio_file_letter
 * @property string|null $audio_file_makhraj
 * @property string $shape_isolated
 * @property string|null $shape_initial
 * @property string|null $shape_middle
 * @property string|null $shape_final
 * @property int $display_order
 * @property array|null $similar_urdu_sounds
 * @property array|null $common_mistakes_urdu
 * @property array|null $common_mistakes_english
 * @property bool $has_ghunnah
 * @property bool $is_qalqalah
 * @property bool $is_madd_letter
 * @property string|null $makhraj_diagram
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class ArabicLetter extends Model
{
    use SoftDeletes;

    protected $table = 'arabic_letters';
    protected $guarded = [];

    protected $casts = [
        'has_ghunnah' => 'boolean',
        'is_qalqalah' => 'boolean',
        'is_madd_letter' => 'boolean',
        'similar_urdu_sounds' => 'array',
        'common_mistakes_urdu' => 'array',
        'common_mistakes_english' => 'array',
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
     * Get the makhraj category relationship
     */
    public function makhrajCategory()
    {
        return $this->belongsTo(MakhrajCategory::class, 'makhraj_category', 'name_english');
    }

    /**
     * Scope to order by display order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    /**
     * Scope to filter by makhraj category
     */
    public function scopeByMakhrajCategory($query, string $category)
    {
        return $query->where('makhraj_category', $category);
    }

    /**
     * Scope to get letters with ghunnah
     */
    public function scopeWithGhunnah($query)
    {
        return $query->where('has_ghunnah', true);
    }

    /**
     * Scope to get qalqalah letters
     */
    public function scopeQalqalah($query)
    {
        return $query->where('is_qalqalah', true);
    }

    /**
     * Scope to get madd letters
     */
    public function scopeMaddLetters($query)
    {
        return $query->where('is_madd_letter', true);
    }
}