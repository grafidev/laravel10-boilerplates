<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\TransactionType;

class TransactionCancellationService
{
    public static function handle(Transaction $transaction, ?string $cancellationReason): array
    {
        if (! $transaction->isCancellable()) {
            return ['success' => false, 'message' => 'Cette transaction ne peut pas être annulée.', 'status' => 422];
        }

        if ($transaction->isCancelled()) {
            return ['success' => false, 'message' => 'La transaction est déjà annulée.', 'status' => 422];
        }

        $sender = $transaction->sender;
        $receiver = $transaction->receiver;

        $receiver->withdraw($transaction->amount);
        $sender->deposit($transaction->amount);

        $newTransaction = Transaction::create([
            ...$transaction->onlyCancellationAttributes(),
            'amount' => -$transaction->amount,
            'transaction_type_id' => TransactionType::getId(TransactionType::ANNULATION),
            'original_transaction_id' => $transaction->id,
            'cancellation_reason' => $cancellationReason,
        ]);

        if ($newTransaction) {
            $transaction->markAsCancelled();

            return ['success' => true, 'message' => 'Transaction annulée avec succès', 'status' => 200];
        }
    }
}
