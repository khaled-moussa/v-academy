<?php

namespace App\Domain\User\Dtos;

use App\Support\Enums\UserPanelEnum;

class CreateUserDto
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly UserPanelEnum $panel,
        public readonly bool $active,
        public readonly ?string $phone,
        public readonly ?string $password,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Factory — From Array
    |--------------------------------------------------------------------------
    */

    public static function fromArray(array $data): self
    {
        return new self(
            firstName: (string) $data['first_name'],
            lastName: (string) $data['last_name'],
            email: (string) $data['email'],
            panel: $data['panel'] instanceof UserPanelEnum ? $data['panel'] : UserPanelEnum::from($data['panel']),
            active: (bool) ($data['active'] ?? true),
            phone: $data['phone'] ?? null,
            password: $data['password'] ?? null,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public static function withPanel(array $data, UserPanelEnum $panel): self
    {
        return self::fromArray([
            ...$data,
            'panel' => $panel->value,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Export — To Array
    |--------------------------------------------------------------------------
    */

    public function toArray(): array
    {
        return array_filter([
            'first_name' => $this->firstName,
            'last_name'  => $this->lastName,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'panel'      => $this->panel->value,
            'active'     => $this->active,
            'password'   => $this->password,
        ], fn($value) => ! is_null($value));
    }
}
