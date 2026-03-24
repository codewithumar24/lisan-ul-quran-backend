<?php

namespace Modules\User\Transformers\Auth;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\UserTransformer;

class LoginResponseTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user' => new UserTransformer($this['user']),
            'token' => $this['token'],
            'token_type' => 'Bearer',
        ];
    }
}
