<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Transformers\RoleTransformer;
use Modules\User\Entities\User;

/** @mixin User */
class UserTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'cnic' => $this->cnic,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'gender' => $this->gender,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'profile_photo' => $this->profile_photo,
            'language_preference' => $this->language_preference,
            'student_type' => $this->student_type,
            'is_active' => $this->is_active,
            'email_verified_at' => $this->email_verified_at?->toDateTimeString(),
            'role' => new RoleTransformer($this->whenLoaded('role')),
            'google_id' => $this->google_id,
            'google_avatar' => $this->google_avatar,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
