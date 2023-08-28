<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Paytabscom\Laravel_paytabs\Facades\paypage;
use Illuminate\Support\Facades\Auth;
class PaymentController extends Controller
{
    public function makePayment(Request $request)
    {   $user = Auth::user();
        $cvv = $request->input('cvv');
        $card_number = $request->input('cn');
        $expiry_date = $request->input('ed');
        $user->card_number = $card_number;
        $user->cvv = $cvv;
        $user->expiry_date = $expiry_date;
        $user->save();
        $totalAmount = $request->input('totalAmount');
        $pay= paypage::sendPaymentCode('all')
               ->sendTransaction('sale')
                ->sendCart(10,$totalAmount,'test')
               ->sendCustomerDetails('louay kharouf', 'louaykharouf@gmail.com', '0101111111', 'test', 'Riyadh', 'Saudi', 'SAR', '1234','100.279.20.10')
               ->sendShippingDetails('louay kharouf', 'louaykharouf@gmail.com', '0101111111', 'test', 'Riyadh', 'Saudi', 'SAR', '1234','100.279.20.10')
               ->sendURLs('http://localhost:8000/payment/success', 'http://localhost:8000/payment/success')
               ->sendLanguage('en')
               ->create_pay_page();
       
        return view('payment', ['pay' => $pay]);
    }
    public function reminderPayment(Request $request)
    {   $user = Auth::user();
        $cvv = $request->input('cvv');
        $card_number = $request->input('cn');
        $expiry_date = $request->input('ed');
        $user->card_number = $card_number;
        $user->cvv = $cvv;
        $user->expiry_date = $expiry_date;
        $user->save();
        $totalAmount = $request->input('totalAmount');
        $pay= paypage::sendPaymentCode('all')
               ->sendTransaction('sale')
                ->sendCart(10,$totalAmount,'test')
               ->sendCustomerDetails('louay kharouf', 'louaykharouf@gmail.com', '0101111111', 'test', 'Riyadh', 'Saudi', 'SAR', '1234','100.279.20.10')
               ->sendShippingDetails('louay kharouf', 'louaykharouf@gmail.com', '0101111111', 'test', 'Riyadh', 'Saudi', 'SAR', '1234','100.279.20.10')
               ->sendURLs('http://localhost:8000/reminder/success', 'http://localhost:8000/reminder/success')
               ->sendLanguage('en')
               ->create_pay_page();
       
        return view('payment', ['pay' => $pay]);
    }
}
