<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\UserAccountCreated;
use App\Http\Controllers\Concerns\Perpage;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class UsersController extends Controller
{
    use Perpage;

    public function __construct(
        private UserRepository $userRepository,
        private RoleRepository $roleRepository,
    ) {
    }

    public function index(Request $request)
    {
        $perpage = $this->getPerpage('users');

        $filters = $request->only('search');

        $users = $this->userRepository
            ->query()
            ->sortableUsing($request->query('sort'))
            ->search($filters)
            ->latest()
            ->paginate($perpage)
            ->withQueryString();

        return Inertia::render('Admin/Users/Index', [
            'users' => UserResource::collection($users),
            'perpage' => $perpage,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Users/Create', [
            'roles' => $this->roleRepository->query()->get(),
        ]);
    }

    public function store(UserRequest $request)
    {
        $user = $this->userRepository->create($request->validated());

        $user->roles()->sync($request->validated('role_id'));

        event(new UserAccountCreated($user));

        return to_route('dashboard.users.index')->with('success', 'Enregistrement effectué avec succès.');
    }

    public function edit(int $id)
    {
        $user = $this->userRepository->query()->findOrFail($id);

        return Inertia::render('Admin/AdminUsers/Edit', [
            'user' => UserResource::make($user),
            'role' => $user->roles()->first(),
            'roles' => $this->roleRepository->query()->get(),
        ]);
    }

    public function update(UserRequest $request, int $id)
    {
        $user = $this->userRepository->query()->findOrFail($id);

        $data = Arr::except($request->validated(), ['role_id']);

        $user->update($data);

        $user->roles()->sync($request->validated('role_id'));

        return to_route('dashboard.users.index')->with('success', 'Modification effectuée avec succès.');
    }
}
