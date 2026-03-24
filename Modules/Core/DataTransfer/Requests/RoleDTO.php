<?php

namespace Modules\Core\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class RoleDTO implements DTO
{
    public function __construct(
        private readonly string $name,
        private readonly ?string $description,
        private readonly array $permissions = []
    ) {}

    public static function create(
        string $name,
        ?string $description = null,
        array $permissions = []
    ): self {
        return new self($name, $description, $permissions);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
