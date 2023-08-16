<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PhysicalCardsAttachmentRequestFormRequest;
use App\Models\Role;
use App\Repositories\PhysicalCardRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class PhysicalCardsAttachmentRequestController extends Controller
{
    use ApiResponse;

    public function __construct(private PhysicalCardRepository $physicalCardRepository, private UserRepository $userRepository)
    {
        $this->middleware('auth:api');
    }

    public function __invoke(PhysicalCardsAttachmentRequestFormRequest $request)
    {
        $physicalCard = $this->physicalCardRepository
            ->query()
            ->where('serial_number', $request->validated('serial_number'))
            ->available()
            ->first();

        $user = $this->userRepository
            ->query()
            ->whereRelation('roles', 'roles.name', Role::CLIENT)
            ->findOrFail($request->validated('user_id'));

        if ($physicalCard === null) {
            return $this->sendError("La carte que vous demandez n'existe pas", 404);
        }

        if ($user === null) {
            return $this->sendError("Le compte client n'existe pas.", 404);
        }

        try {
            DB::transaction(function () use ($physicalCard, $user, $request) {
                $physicalCard->update([
                    'requesting_user_id' => $request->user()->id,
                    'user_id' => $user->id,
                    'needs_attachment' => true,
                    'needs_attachment_at' => now(),
                ]);
            });

            return $this->sendData(message: 'Demande de carte effectuée avec succès.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
