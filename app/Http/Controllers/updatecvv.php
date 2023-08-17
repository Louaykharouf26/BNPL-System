<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class updatecvv extends Controller
{
    public function showCvvForm()
    {
        return view('test');
    }
    public function updateCvv(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'cvv' => 'required|string|max:4', // Adjust validation rules as needed
        ]);
        $cardnumber=$request->input('cn');
        $expirydate=$request->input('ed');

       // $user->cvv = $validatedData['cvv'];
        $user->update(['cvv' =>  $validatedData['cvv']]);
        $user->update(['card_number' =>  $cardnumber]);
        $user->update(['expiry_date' =>  $expirydate]);
        $user->save();

        return redirect()->back()->with('success', 'CVV updated successfully.');
    }
}
