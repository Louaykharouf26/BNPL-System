<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
class BnplController extends Controller
{
    public function calculateMonthlyInstallments(Request $request)
    {
        // Retrieve the product and price from the request
       // $product = $request->input('product');
        //$price = $request->input('price');
        //$installmentNumber = $request->input('installment_number');
        //$product = $this->fetchProductDetails($id);
        //$price = $product->price;
        // Perform the BNPL calculations (example)
        $totalAmount = $request->input('totalAmount');
        $installmentsData = $request->input('installmentsData');
        $decodedData = json_decode(urldecode($installmentsData), true);
        $items = $decodedData['items'];// Get the items array from the request
       // Session::put('items', $items);
       
        if($totalAmount<200){
            return response()->json(['error' => 'the totalAmount cannot be devided']);
        }
        else {
        $installments = [
            //'product' => $product->name,
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

        // Return the response
        //return response()->json($installments);
        //return view('bnpl-result', ['installments' => $installments]);
       // return response()->json($installments);
      // return response()->json($installmentsData);
       //return $totalAmount;
      return response()->json($installmentsData);
    }
    }
    public function showBNPLResult(Request $request){
        $totalAmount = $request->input('totalAmount');
        //$items = $request->input('items');
        $user = Auth::user();
        $email = $user->email;
        $installmentsData = $request->input('installmentsData');
        $decodedData = json_decode(urldecode($installmentsData), true);
        $items = $decodedData['items'];// Get the items array from the request
        //Session::put('totalAmount', $totalAmount);
        Session::put('items', $items);
       // $items = Session::get('items');

        if($totalAmount<200){
            return response()->json(['error' => 'the totalAmount cannot be devided']);
        }
        else {
        $installments = [
            //'product' => $product->name,
            'price' => $totalAmount,
           // 'items'=>$items,
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
       // $this->showPaymentSuccess($request, $totalAmount);

        // Return the response
        //return response()->json($installments);
        //return view('bnpl-result', ['installments' => $installments]);
       // return response()->json($installments);
       return view('bnpl-result', ['installments' => $installments, 'totalAmount' => $totalAmount,'items'=>$items]);
    }
    }
   
    public function showPaymentSuccess(Request $request)
    {
        $user = Auth::user();
       // $totalAmount = $this->calculateMonthlyInstallments($request);
      // $localStorageScript = '<script>var totalAmount = localStorage.getItem("totalAmount");</script>';
       $totalAmount = Session::get('totalAmount');
       $items = Session::get('items');
       // Calculate installment amount based on totalAmount
      // $installmentAmount = '<script>document.write(totalAmount / 3);</script>';
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
    
        // Use the extracted data in showPaymentSuccess view
        return view('payment_success', [
            'installments' => $installments
           // 'totalAmount' => $totalAmount
        ]);
    }
    
    public function handleFormSubmission(Request $request)
{
    $user = Auth::user();
   // $cvv = $request->input('cvv');
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
    // Update the user's record with the CVV
   // $user->cvv = $cvv;
    $user->paidamount = $totalAmount/3;
    $user->remainingamount = $totalAmount/2;
    $user->save();
    return Redirect::to('/payment/success');
    // Rest of your code (redirect, response, etc.)
}
   /* public function calculateMonthlyInstallments(Request $request,$id)
    {
        $installmentNumber = $request->input('installment_number');
       // $product = $request->input('product');
        //$price = $request->input('price');
       
        $product = $this->fetchProductDetails($id);
        $price = $product->price;
        if ($installmentNumber > 0) {
            $installments = [
                'product' => $product,
                'price' => $price,
                'monthly_installments' => [],
            ];

            $installmentAmount = $price / $installmentNumber;

            for ($i = 1; $i <= $installmentNumber; $i++) {
                $installments['monthly_installments'][] = [
                    'month' => 'Month ' . $i,
                    'amount' => $installmentAmount,
                ];
            }

            return response()->json($installments);
        }

        return response()->json(['error' => 'Invalid installment number'], 400);
    }*/
    private function fetchProductDetails($id)
    {
        // Implement your logic to fetch the product details from the database or any other source
        // Return the product object
        $product = DB::connection('e_commerce')->table('products')->find($id);


        if (!$product) {
            abort(404, 'Product not found');
        }
    
        return $product;
    }
}
