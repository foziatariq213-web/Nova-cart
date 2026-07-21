<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Customer;

class UserObserver
{
    /**
     * Handle the User "created" event.
     * Naya user register hote hi customers table mein bhi record ban jayega.
     */
    public function created(User $user): void
    {
        Customer::create([
            'name'          => $user->name,
            'email'         => $user->email,
            'phone'         => 'N/A',
            'address'       => 'N/A',
            'total_orders'  => 0,
            'total_spent'   => 0,
            'status'        => 'Active',
        ]);
    }

    /**
     * Handle the User "updated" event.
     * Agar user apna name/email update kare to customers table mein bhi sync ho jaye.
     */
    public function updated(User $user): void
    {
        Customer::where('email', $user->getOriginal('email'))
            ->update([
                'name'  => $user->name,
                'email' => $user->email,
            ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}