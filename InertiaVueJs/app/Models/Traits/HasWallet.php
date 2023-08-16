<?php

namespace App\Models\Traits;

use App\Exceptions\InsufficientFundException;
use App\Exceptions\InvalidAmountException;
use App\Exceptions\WalletIsBlockedException;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

trait HasWallet
{
    public function createWallet()
    {
        return $this->wallet()->create([
            'balance' => 0,
            'account_number' => Str::random(20),
        ]);
    }

    public function updateWalletBalance(float|int $amount)
    {
        $this->throwExceptionIfAmountIsInvalid($amount);

        $this->wallet->update(['balance' => $amount]);
    }

    public function disableWallet()
    {
        return $this->wallet->update(['is_blocked' => true]);
    }

    public function enableWallet()
    {
        return $this->wallet->update(['is_blocked' => false]);
    }

    public function walletEmpty()
    {
        return $this->balance == 0;
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function transfer(User $user, $amount)
    {
        $this->withdraw($amount);
        $user->deposit($amount);
    }

    public function deposit(int|float $amount): float|int
    {
        $this->throwExceptionIfWalletIsBlocked();

        $this->throwExceptionIfAmountIsInvalid($amount);

        $this->wallet->increment('balance', $amount);

        return $this->wallet->balance;
    }

    public function withdraw(int|float $amount): float|int
    {
        // $this->throwExceptionIfWalletIsBlocked();

        $this->throwExceptionIfAmountIsInvalid($amount);

        $this->throwExceptionIfFundIsInsufficient($amount);

        $this->wallet->decrement('balance', $amount);

        return $this->wallet->balance;
    }

    public function canWithdraw(int|float $amount): bool
    {
        $this->throwExceptionIfWalletIsBlocked();

        $this->throwExceptionIfAmountIsInvalid($amount);

        $balance = $this->wallet->balance ?? 0;

        return $balance >= $amount;
    }

    public function balance(): Attribute
    {
        return Attribute::get(fn () => $this->wallet->balance ?? 0);
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
        if ($this->wallet->is_blocked) {
            throw new WalletIsBlockedException($this->phone_number." 's wallet is blocked");
        }
    }
}
