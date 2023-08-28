<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;
class SendMonthlyEmails extends Command
{
    protected $signature = 'email:send-now';
    protected $description = 'Send emails to users for testing purposes';

    public function handle()
    {
        $users = User::all(); // Fetch all users

        foreach ($users as $user) {
            $lastPurchaseDate = $user->last_purchase_date;

            if ($lastPurchaseDate) {
                $twoMinutesLater = Carbon::parse($lastPurchaseDate)->addMinutes(2);

                if (now()->greaterThanOrEqualTo($twoMinutesLater)) {
                    // Send email to the user
                    Mail::to($user->email)->send(new PurchaseEmail($user));
                }
            }
        }
    }
}
