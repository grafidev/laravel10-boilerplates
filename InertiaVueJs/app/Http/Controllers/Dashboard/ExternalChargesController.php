<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Concerns\Perpage;
use App\Http\Controllers\Controller;
use App\Http\Resources\RechargeResource;
use App\Repositories\RechargeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExternalChargesController extends Controller
{
    use Perpage;

    public function __construct(private RechargeRepository $rechargeRepository, private UserRepository $userRepository)
    {
    }

    public function index(Request $request)
    {
        $perpage = $this->getPerpage('perpage');

        $filters = $request->only('search');

        $recharges = $this->rechargeRepository
            ->query()
            ->sortableUsing($request->query('sort'))
            ->search($filters)
            ->latest()
            ->external()
            ->paginate($perpage)
            ->withQueryString();

        return Inertia::render('Admin/ExternalCharges/Index', [
            'recharges' => RechargeResource::collection($recharges),
            'filters' => $filters,
            'perpage' => $perpage,
        ]);
    }
}
