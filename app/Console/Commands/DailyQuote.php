<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
class DailyQuote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:daily';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively send an exclusive quote to everyone daily via email.';    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*$quotes = [
            'Mahatma Gandhi' => 'Live as if you were to die tomorrow. Learn as if you were to live forever.',
            'Friedrich Nietzsche' => 'That which does not kill us makes us stronger.',
            'Theodore Roosevelt' => 'Do what you can, with what you have, where you are.',
            'Oscar Wilde' => 'Be yourself; everyone else is already taken.',
            'William Shakespeare' => 'This above all: to thine own self be true.',
            'Napoleon Hill' => 'If you cannot do great things, do small things in a great way.',
            'Milton Berle' => 'If opportunity doesn’t knock, build a door.'
        ];*/
         
        // Setting up a random word
       // $key = array_rand($quotes);
        $data = "Hello Again ! 
        Here is the link to continue the payment of your installment
        http://localhost:8000/reminder";
         
      //  $users = User::all();
        $tenMinutesAgo = Carbon::now()->subMinutes(2);

        $users = User::where('date_first_purchase', '>', $tenMinutesAgo)->get();
        //$users = User::whereNull('date_first_purchase')->get();
        foreach ($users as $user) {
            Mail::raw($data, function ($mail) use ($user) {
                $mail->to($user->email)
                    ->subject('Reminder Link');
              
            });
        }
         
        $this->info('Successfully sent daily quote to everyone.');
    }
}