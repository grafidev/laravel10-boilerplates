<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $roles = $this->roles;

        $role_names = $roles->map(fn ($role) => $role->name);
        $role_descriptions = $roles->map(fn ($role) => $role->description);
        $role = $roles->first();
        $companies = $this->parent_user_id !== null ? $this->parent_user->companies : $this->companies;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'profile_type' => $this->profile_type,
            'active' => $this->active,
            'profile_photo_path' => $this->profile_photo_path,
            'profile_photo_url' => $this->profile_photo_url,
            'ip_address' => $this->ip_address,
            'role' => $role,
            'role_id' => $role?->id,
            'roles' => $roles,
            'roles_list' => $role_descriptions->join(' - '),
            'list_of_roles' => $role_descriptions->toArray(),
            'role_names' => $role_names,
            'isSuperAdmin' => $role_names->contains(Role::SUPER_ADMIN),
            'isAdmin' => $role_names->contains(Role::ADMIN),
            'isUser' => $role_names->contains(Role::USER),
            'created_at' => $this->created_at,
        ];
    }
}
