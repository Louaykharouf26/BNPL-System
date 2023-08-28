<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Mail\PurchaseEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\MonthlyEmail;
use PDF;
class SendPurchaseEmails extends Command
{
    protected $signature = 'send:purchase-emails';
    
    protected $description = 'Send purchase emails to users after 2 minutes of last purchase';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        // Get users who made a purchase more than 2 minutes ago
        $users = User::where('date_first_purchase', '<=', Carbon::now()->subMinutes(2))->get();

  
        
       foreach ($users as $user) {
            // Send email to each user
            Mail::to($users->email)->send(new MonthlyEmail());
            
            // Update the last purchase date to prevent duplicate emails
         //   $user->update(['last_purchase_date' => Carbon::now()]);
      }
        
        $this->info('Purchase emails sent successfully.');
    }
}
