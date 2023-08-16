<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Concerns\Perpage;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolesController extends Controller
{
    use Perpage;

    public function __construct(
        private RoleRepository $roleRepository,
        private PermissionRepository $permissionRepository
    ) {
    }

    public function index(Request $request)
    {
        $this->authorize('list_role');

        $perpage = $this->getPerpage('roles');

        $filters = $request->only('search');

        $roles = $this->roleRepository
            ->query()
            ->with('permissions')
            ->sortableUsing($request->query('sort'))
            ->search($filters)
            ->paginate($perpage)
            ->withQueryString();

        $permissions = $this->permissionRepository->query()->get(['id', 'description']);

        return Inertia::render('Admin/Roles/Index', [
            'roles' => RoleResource::collection($roles),
            'permissions' => $permissions,
            'perpage' => $perpage,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        $this->authorize('create_role');

        $permissions = $this->permissionRepository->query()->select('id', 'description')->get();

        return Inertia::render('Admin/Roles/Create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $this->authorize('create_role');

        $role = $this->roleRepository->create($request->validated());

        if (! empty($request->permissions)) {
            $role->syncPermissions($request->permissions);
        }

        return to_route('dashboard.roles.index');
    }

    public function edit(int $id)
    {
        $this->authorize('edit_role');

        $role = $this->roleRepository->find($id);

        $permissions = $this->permissionRepository->query()->select('id', 'description')->get();

        $role->load('permissions');

        return Inertia::render('Admin/Roles/Edit', compact('permissions', 'role'));
    }

    public function update(RoleRequest $request, int $id)
    {
        $this->authorize('edit_role');

        $role = $this->roleRepository->find($id);

        $role->update($request->validated());

        if ($request->permissions) {
            $role->permissions()->sync($request->permissions);
        }

        return to_route('dashboard.roles.index');
    }
}
