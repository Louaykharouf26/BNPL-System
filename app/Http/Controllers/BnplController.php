<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use App\Mail\InvoiceEmail;
use Illuminate\Support\Facades\Mail;
use PDF;
use App\Models\User; // Make sure this points to the correct namespace for your User model

class BnplController extends Controller
{
    public function calculateMonthlyInstallments(Request $request)
    {
        $totalAmount = $request->input('totalAmount');
        $installmentsData = $request->input('installmentsData');
        $decodedData = json_decode(urldecode($installmentsData), true);
        $items = $decodedData['items'];
        if($totalAmount<200){
            return response()->json(['error' => 'the totalAmount cannot be devided']);
        }
        else {
        $installments = [
            'price' => $totalAmount,
            'items' =>$items,
            'monthly_installments' => [
                [
                    'month' => 'Month 1',
                    'amount' => $totalAmount / 3,
                ],
                [
                    'month' => 'Month 2',
                    'amount' => $totalAmount / 3,
                ],
                [
                    'month' => 'Month 3',
                    'amount' => $totalAmount / 3,
                ],
                
            ],
        ];
        $installmentsData = [
            'installments' => $installments,
            'totalAmount' => $totalAmount,
            'items' => $items,
        ];
      return response()->json($installmentsData);
    }
    }
    public function showBNPLResult(Request $request){
        $totalAmount = $request->input('totalAmount');
        $user = Auth::user();
        $email = $user->email;
        $installmentsData = $request->input('installmentsData');
        $decodedData = json_decode(urldecode($installmentsData), true);
        $items = $decodedData['items'];
        Session::put('totalAmount', $totalAmount);
        Session::put('items', $items);
        if($totalAmount<200){
            return response()->json(['error' => 'the totalAmount cannot be devided']);
        }
        else {
        $installments = [
            'price' => $totalAmount,
           'items' => $items,
            'email' => $email,
            'monthly_installments' => [
                [
                    'month' => 'Month 1',
                    'amount' => $totalAmount / 3,
                ],
                [
                    'month' => 'Month 2',
                    'amount' => $totalAmount / 3,
                ],
                [
                    'month' => 'Month 3',
                    'amount' => $totalAmount / 3,
                ],
            ],
        ];
       return view('bnpl-result', ['installments' => $installments, 'totalAmount' => $totalAmount,'items'=>$items]);
    }
    }
   
    public function showPaymentSuccess(Request $request)
    {
        $user = Auth::user();
       $totalAmount = Session::get('totalAmount');
       $items = Session::get('items');

           $email = $user->email;
    
        $installments = [
            'price' => $totalAmount,
            'email' => $email,
            'items' =>$items,
            'monthly_installments' => [
                [
                    'month' => 'Month 1',
                    'amount' => $totalAmount / 3 ,
                ],
                [
                    'month' => 'Month 2',
                    'amount' => $totalAmount / 3 ,
                ],
                [
                    'month' => 'Month 3',
                    'amount' => $totalAmount / 3 ,
                ],
            ],
        ];
    
        return view('payment_success', [
            'installments' => $installments

        ]);
    }
    public function showReminderSuccess(Request $request)
    {
        $user = Auth::user();
    $totalAmount = $user->remainingamount;
    $payment_number=$user->payment_number;
   // $items = Session::get('items');
    $email = $user->email;

    $installments = [
        'price' => $totalAmount,
        'email' => $email,
//'items' => $items,
        'monthly_installments' => [],
    ];

    if ($payment_number ==1) {
        $installments['monthly_installments'] = [
            [
                'month' => 'Month 1',
                'amount' => $totalAmount / 2,
            ],
            [
                'month' => 'Month 2',
                'amount' => $totalAmount / 2,
            ],
        ];
    } elseif ($payment_number == 2) {
        $installments['monthly_installments'] = [
            [
                'month' => 'Single Payment',
                'amount' => $totalAmount,
            ],
        ];
    }
    
        return view('reminder_success', [
            'installments' => $installments

        ]);
    }
    public function ReminderPage(Request $request)
{
    $user = Auth::user();
    $payment_number=$user->payment_number;
    $totalAmount = $user->remainingamount;
    $paid = $user->paidamount;
   // $items = Session::get('items');
    $email = $user->email;

    $installments = [
        'price' => $totalAmount,
        'email' => $email,
//'items' => $items,
        'monthly_installments' => [],
    ];

    if ($payment_number ==1 ) {
        $installments['monthly_installments'] = [
            [
                'month' => 'Month 1',
                'amount' => $totalAmount / 2,
            ],
            [
                'month' => 'Month 2',
                'amount' => $totalAmount / 2,
            ],
        ];
    } elseif ($payment_number == 2) { 
        
        $installments['monthly_installments'] = [
            [
                'month' => 'Single Payment',
                'amount' => $totalAmount,
            ],
        ];
    
    }

    return view('reminder', [
        'installments' => $installments
    ]);
}

    public function handleFormSubmission(Request $request)
{
   $user = Auth::user();
   $payment_number = $user->payment_number;
   $totalAmount = Session::get('totalAmount');
   $items = Session::get('items') ;
    $itemData = [];
   foreach ($items as $item) {
       $itemData[] = [
           'title' => $item['title'],
           'quantity' => $item['qty']
       ];
   }
   $user->items = $itemData;;
    $paidamount=$request->input('totalAmount');
    $user->paidamount = $totalAmount/3;
    $user->remainingamount = $totalAmount-$paidamount;
    $user->payment_number=$payment_number+1;
    $user->date_first_purchase=date('d-m-Y H:i:s');
    $user->save();
    $pdfData = [
        'paidAmount' => $user->paidamount,
        'totalAmount' => $totalAmount,
        'items' => $itemData,
    ];
    $storagePath = storage_path('app/public');
   // $randomNumber = rand(1000, 9999);
    $username=$user->name;
    $payment_number=$user->payment_number;
    $newFileName = 'invoice_' . $username . '_payment number_' .$payment_number.'.pdf';
    $pdf = PDF::loadView('pdf.invoice', $pdfData);
    while (File::exists($storagePath . '/' . $newFileName)) {
        $randomNumber = rand(1000, 9999);
        $newFileName = 'invoice_' . $username . '_payment number_' .$payment_number.'_'.$randomNumber.'.pdf';
    }
    $pdf->save($storagePath . '/' . $newFileName);
    $pdfPath = $storagePath . '/' . $newFileName;
    Mail::to($user->email)->send(new InvoiceEmail($pdfPath));
    return Redirect::to('afterpay');
}
public function handleFormSubmission1(Request $request)
{
   $user = Auth::user();
   $payment_number = $user->payment_number;
   $totalAmount = Session::get('totalAmount');
   $items = Session::get('items') ;
    $itemData = [];
   foreach ($items as $item) {
       $itemData[] = [
           'title' => $item['title'],
           'quantity' => $item['qty']
       ];
   }
 //  $user->items = $itemData;;*/
    $paidamount=$request->input('totalAmount');
    $lastpaid = $user->paidamount;
    $remainingamount = $user->remainingamount;
    
    // Check if remaining amount is less than twice the last paid amount
    if ($payment_number==2) {
        $user->remainingamount = 0;
        $user->paidamount = $totalAmount;
    } else {
        $user->remainingamount = $totalAmount - $lastpaid * 2;
        $user->paidamount = $lastpaid * 2;
        $user->payment_number=$payment_number+1;
    }
    
    $user->date_first_purchase = date('d-m-Y H:i:s');
    $user->save();
    
    $pdfData = [
        'paidAmount' => $paidamount,
        'totalAmount' => $totalAmount,
        'items' => $itemData,
    ];
    
    $storagePath = storage_path('app/public');
    $randomNumber = rand(1000, 9999);
    $username=$user->name;
    $payment_number=$user->payment_number;
    $newFileName = 'invoice_' . $username . '_payment number_' .$payment_number.'.pdf';
    
    $pdf = PDF::loadView('pdf.invoice', $pdfData);
    while (File::exists($storagePath . '/' . $newFileName)) {
        $randomNumber = rand(1000, 9999);
        $newFileName = 'invoice_' . $username . '_payment number_' .$payment_number.'_'.$randomNumber.'.pdf';
    }
    $pdf->save($storagePath . '/' . $newFileName);
    
    $pdfPath = $storagePath . '/' . $newFileName;
    Mail::to($user->email)->send(new InvoiceEmail($pdfPath));
    
    return Redirect::to('/afterpay');
    
}
public function logout()
{
    Auth::logout();
    return redirect('/login'); // Redirect to the login page after logout
}
public function calculateTotalPaidAmount()
    { 

        if (auth()->user()->role === 'Admin') {
            $usersWithRole = User::where('role', 'User')->get();
            $usersWithRemainingAmount = User::where('remainingamount', '>', 0)->get();

        $totalPaidAmount = $usersWithRole->sum('paidamount');

        return view('AdminDashboard', compact('totalPaidAmount','usersWithRemainingAmount'));
        } else {
            abort(403, 'Unauthorized');
        }
        
    }
    public function update(Request $request, $id) {
        $user = User::find($id);
    
        if ($user) {
            $newRemainingAmount = $request->input('newRemainingAmount');
            $newusername = $request->input('newusername');
            $user->name = $newusername;
            $user->remainingamount=$newRemainingAmount;
            $user->save();
    
            return Redirect::to('/testpage'); // Redirect to the appropriate route after updating
        }
    
        return redirect()->back()->with('error', 'User not found.');
    }
    public function destroy($id) {
        $user = User::find($id);
    
        if ($user) {
            $user->delete();
            return Redirect::to('/testpage'); // Redirect to the appropriate route after deletion
        }
    
        return redirect()->back()->with('error', 'User not found.');
    }
    public function store(Request $request) {
        // Validate the input fields
        $validatedData = $request->validate([
            'name' => 'required',
            'remainingamount' => 'required|numeric',
            'email' =>"required",
            "password" =>"required"
        ]);
    
        // Create a new user
        User::create($validatedData);
    
        return Redirect::to('/testpage');  // Redirect to the appropriate route after adding the user
    }
}
