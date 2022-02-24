<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payments()
    {
        $data = Payment::with('user', 'to_user');
        if (request('user_id')) {
            $data = $data->where('user_id', request('user_id'));
        }
        $data = $data->paginate(10);

        return $this->apiSuccessResponse($data);
    }

    public function add_payment($user_id , Request $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = $user_id;
        $inputs['transaction_number'] = date('Y') . time() . rand(0, 1000);
        $data = Payment::create($inputs);

        return $this->apiSuccessResponse($data);
    }
}
