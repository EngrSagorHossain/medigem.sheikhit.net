<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentHistory;

class PaymentHistoryController extends Controller
{
    public function makePayment(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'payment_method' => 'required',
            'sent_number' => 'required',
            'transaction_id' => 'required',
            'amount' => 'required|numeric',
            'remarks' => 'nullable',
            'status' => 'required',
            'package_id'=>'required'
        ]);

        $validatedData['user_id'] = $request->user()->id;

        $payment = PaymentHistory::create($validatedData);

        // Return a response indicating success
        return response()->json(['message' => 'Payment added successfully', 'payment' => $payment], 201);
    }

    public function getRanksOnExamId(Request $request, $exam_id)
    {
        $ranks = Rank::with('user')->where('exam_id', $exam_id)->get();
       
        return response()->json(['ranks' => $ranks], 200);
    }
    
}
