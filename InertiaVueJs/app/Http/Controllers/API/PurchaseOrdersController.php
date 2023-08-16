<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseOrderUsageRequest;
use App\Models\Role;
use App\Models\TransactionType;
use App\Repositories\PurchaseOrderRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class PurchaseOrdersController extends Controller
{
    use ApiResponse;

    public function __construct(
        private PurchaseOrderRepository $purchaseOrderRepository,
        private TransactionRepository $transactionRepository,
        private UserRepository $userRepository,
    ) {
    }

    public function store(PurchaseOrderUsageRequest $request)
    {
        $purchaseOrder = $this->purchaseOrderRepository
            ->query()
            ->where('serial_number', $request->validated('serial_number'))
            ->where('number', $request->validated('number'))
            ->whereRelation('corporate_client', 'corporate_clients.country_id', $request->validated('country_id'))
            ->whereRelation('corporate_client', 'corporate_clients.company_id', $request->validated('company_id'))
            ->first();

        $sender = $this->userRepository
            ->query()
            ->role(Role::POMPISTE)
            ->find($request->validated('user_id'));

        if ($purchaseOrder === null) {
            return $this->sendError('Erreur zone', 422);
        }

        if (! $purchaseOrder->active || $purchaseOrder->activated_at === null) {
            return $this->sendError("Ce bon de carburant n'est pas encore activé", 422);
        }

        if ($purchaseOrder->date_of_use !== null) {
            return $this->sendError('Ce bon de carburant est déjà utilisé', 422);
        }

        if ($sender === null) {
            return $this->sendError('Initiator not found', 404);
        }

        if ($sender->station_id == null) {
            return $this->sendError('Récupération de la station impossible', 500);
        }

        try {
            DB::transaction(function () use ($purchaseOrder, $sender) {
                $this->transactionRepository->create([
                    'sender_id' => $sender->id,
                    'transaction_type_id' => TransactionType::getId(TransactionType::BON_CARBURANT),
                    'station_id' => $sender->station_id,
                    'corporate_client_id' => $purchaseOrder->corporate_client_id,
                    'product_id' => $purchaseOrder->product_id,
                    'amount' => (float) $purchaseOrder->amount,
                    'status' => 'success',
                ]);
            });

            $purchaseOrder->update(['date_of_use' => now(), 'active' => false]);

            return $this->sendResponse(message: 'Purchase order used successfully :)');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
