<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderStatus;

class PurchaseOrderValidationService
{
    public static function handle(PurchaseOrder $purchaseOrder, $input = []): string
    {
        $fromStatusId = $purchaseOrder->getOriginal('purchase_order_status_id');

        switch ($input['notice']) {
            case PurchaseOrderStatus::VALIDEE:
                $purchaseOrder->nextStep();
                break;
            case PurchaseOrderStatus::REJETEE:
                $purchaseOrder->rejectStep();
                break;
        }

        $purchaseOrder->validationHistories()->create([
            ...$input,
            'user_id' => authUser()->id,
            'from_status_id' => $fromStatusId,
            'to_status_id' => $purchaseOrder->purchase_order_status_id,
        ]);

        return [
            PurchaseOrderStatus::VALIDEE => 'Recharge validée avec succès',
            PurchaseOrderStatus::REJETEE => 'Recharge rejetée avec succès',
        ][$input['notice']] ?? 'Traitement effectué avec succès.';
    }
}
