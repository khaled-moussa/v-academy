<?php

namespace App\Domain\User\Dtos;

class UpdateUserDto
{
    public function __construct(
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly ?string $phone,
        public readonly ?string $password,
    ) {}

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
            'phone'      => $this->phone,
            'password'   => $this->password,
        ], fn($value) => ! is_null($value));
    }
}
