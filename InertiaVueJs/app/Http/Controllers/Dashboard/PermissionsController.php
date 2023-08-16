<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Concerns\Perpage;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionsController extends Controller
{
    use Perpage;

    public function __construct(private PermissionRepository $permissionRepository)
    {
    }

    public function index(Request $request)
    {
        $this->authorize('super_admin');

        $perpage = $this->getPerpage('permissions');

        $filters = $request->only('search');

        $permissions = $this->permissionRepository
            ->query()
            ->sortableUsing($request->query('sort'))
            ->search($filters)
            ->paginate($perpage)
            ->withQueryString();

        return Inertia::render('Admin/Permissions/Index', [
            'permissions' => PermissionResource::collection($permissions),
            'perpage' => $perpage,
            'filters' => $filters,
        ]);
    }

    public function store(PermissionRequest $request)
    {
        $this->authorize('super_admin');

        $this->permissionRepository->create([...$request->validated(), 'guard_name' => 'web']);

        return to_route('dashboard.permissions.index')->with('success', 'Enregistrement effectué avec succès.');
    }

    public function update(PermissionRequest $request, int $id)
    {
        $this->authorize('super_admin');

        $permission = $this->permissionRepository->findOrFail($id);

        $permission->update([...$request->validated(), 'guard_name' => 'web']);

        return to_route('dashboard.permissions.index')->with('success', 'Modification effectuée avec succès.');
    }
}
