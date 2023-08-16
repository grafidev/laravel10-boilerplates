<?php

namespace App\Models\Traits;

use App\Exceptions\InsufficientFundException;
use App\Exceptions\InvalidAmountException;
use App\Exceptions\WalletIsBlockedException;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasCard
{
    public function updateCardBalance(float|int $amount)
    {
        $this->throwExceptionIfAmountIsInvalid($amount);

        $this->card->update(['balance' => $amount]);
    }

    public function disableCard()
    {
        return $this->card->update(['is_blocked' => true]);
    }

    public function enableCard()
    {
        return $this->card->update(['is_blocked' => false]);
    }

    public function cardEmpty()
    {
        return $this->balance == 0;
    }

    public function cardDeposit(int|float $amount): float|int
    {
        // $this->throwExceptionIfWalletIsBlocked();

        $this->throwExceptionIfAmountIsInvalid($amount);

        $this->card->increment('balance', $amount);

        return $this->card->balance;
    }

    public function cardWithdraw(int|float $amount): float|int
    {
        // $this->throwExceptionIfWalletIsBlocked();

        $this->throwExceptionIfAmountIsInvalid($amount);

        $this->throwExceptionIfFundIsInsufficient($amount);

        $this->card->decrement('balance', $amount);

        return $this->card->balance;
    }

    public function canWithdraw(int|float $amount): bool
    {
        // $this->throwExceptionIfWalletIsBlocked();

        $this->throwExceptionIfAmountIsInvalid($amount);

        $balance = $this->card->balance ?? 0;

        return $balance >= $amount;
    }

    public function balance(): Attribute
    {
        return Attribute::get(fn () => $this->card->balance ?? 0);
    }

    public function throwExceptionIfAmountIsInvalid(int|float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidAmountException();
        }
    }

    public function throwExceptionIfFundIsInsufficient(int|float $amount): void
    {
        if (! $this->canWithdraw($amount)) {
            throw new InsufficientFundException();
        }
    }

    public function throwExceptionIfWalletIsBlocked(): void
    {
        if ($this->card->is_blocked) {
            throw new WalletIsBlockedException($this->phone_number." 's card is blocked");
        }
    }
}
