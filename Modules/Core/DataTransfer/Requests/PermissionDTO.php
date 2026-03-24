<?php

namespace Modules\Core\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class PermissionDTO implements DTO
{
    public function __construct(
        private readonly string $name,
        private readonly ?string $group,
        private readonly ?string $description
    ) {}

    public static function create(
        string $name,
        ?string $group = null,
        ?string $description = null
    ): self {
        return new self($name, $group, $description);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
