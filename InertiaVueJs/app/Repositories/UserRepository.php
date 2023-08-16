<?php

namespace App\Repositories;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Models\User;

class UserRepository extends BaseRepository
{
    use ApiResponse;

    public function model(): string
    {
        return User::class;
    }

    public function getFieldsSearchable(): array
    {
        return [];
    }

    public function findByPhoneNumber(?string $phoneNumber)
    {
        return $this->query()->where('phone_number', $phoneNumber)->first();
    }

    public function createClient(array $data)
    {

    }
}
