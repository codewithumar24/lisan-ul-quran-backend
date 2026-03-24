<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Modules\Admin\Entities\Class\Classs;
use Modules\Admin\Entities\StudentClasss;
use Modules\Core\Entities\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        'google_token',
        'google_refresh_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'date_of_birth' => 'date',
    ];

    protected $appends = [
        'full_name',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->role->permissions()->where('name', $permission)->exists();
    }

    public function hasAnyPermission(array $permissions): bool
    {
        return $this->role->permissions()->whereIn('name', $permissions)->exists();
    }

    public function hasRole(string $role): bool
    {
        return $this->role->name === $role;
    }

    // Relationships for the Quran app
    public function classes()
    {
        return $this->belongsToMany(Classs::class, 'student_classes', 'user_id', 'class_id')
            ->withTimestamps()
            ->withPivot('is_active', 'join_date');
    }

    public function studentClasses()
    {
        return $this->hasMany(StudentClasss::class, 'user_id');
    }

    public function lessonProgress()
    {
        return $this->hasMany(UserLessonProgress::class);
    }

    public function letterMastery()
    {
        return $this->hasMany(UserLetterMastery::class);
    }

    public function tajweedMastery()
    {
        return $this->hasMany(UserTajweedMastery::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(UserQuizAttempt::class);
    }

    public function practiceSessions()
    {
        return $this->hasMany(UserPracticeSession::class);
    }

    public function selfAssessments()
    {
        return $this->hasMany(UserSelfAssessment::class);
    }
}
