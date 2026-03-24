<?php

namespace Modules\Core\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Entities\Permission;

/** @mixin Permission */
class PermissionTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'slug' => $this->slug,
            'group' => $this->group,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
