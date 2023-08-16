<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Repositories\FidelityPointRepository;
use Illuminate\Http\Request;

class FidelityPointsUsageController extends Controller
{
    use ApiResponse;

    public function __construct(private FidelityPointRepository $fidelityPointRepository)
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $selectedFidelityPoint = $request->input('fidelity_point_id');

        // Vérifier si l'utilisateur a suffisamment de points de fidélité disponibles

        $fidelityPoints = $this->fidelityPointRepository->findOrFail($selectedFidelityPoint);

        if ($user->fidelity_points >= $fidelityPoints->points_required) {
            // Déduire le nombre de points de fidélité de la balance de l'utilisateur
            $user->fidelity_points -= $fidelityPoints->points_required;
            $user->save();

            if ($user->hasRole(Role::PORTEUR_CARTE)) {
                $wallet = $user->card;
            } else {
                $wallet = $user->wallet;
            }

            // Ajouter le montant équivalent en F au solde du portefeuille
            $wallet->increment('balance', $fidelityPoints->fidelity_value);
            $user->save();

            // Créer une nouvelle transaction
            // $transaction = new Transaction();
            // $transaction->user_id = $user->id;
            // $transaction->amount = $fidelityPoints->fidelity_value;
            // $transaction->type = 'fidelity';
            // $transaction->save();

            return $this->sendResponse('Points de fidélité échangés avec succès !');
        }

        return $this->sendError("Vous n'avez pas suffisamment de points de fidélité disponibles !");
    }
}
