<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function add_payment($user_id, Request $request)
    {
        $v = Validator::make($request->all(), [
            'balance' => 'required|min:1|max:200',
            'to_user_id' => 'required',
        ]);

        if ($v->fails()) return $this->apiFailResponse($v->errors()->first(), 'validation error');

        $inputs = $request->all();

        $user = User::find($user_id);
        $to_user = User::find($inputs['to_user_id']);
        if (!$user || $user->balance < $inputs['balance']) {
            return $this->apiFailResponse('your balance not valid to make this process');
        }

        $payments = Payment::where('user_id', $user_id)->where('action_at', date('Y-m-d H'))->get()->groupBy('action_at');
        if (count($payments) > 0) {
            if (array_values($payments->map->sum('balance')->toArray())[0] + $inputs['balance'] >= 200) {
                return $this->apiFailResponse('max balance is 200 in one hours');
            }
        }

        $inputs['user_id'] = $user_id;
        $inputs['status'] = 'approve';
        $inputs['transaction_number'] = date('Y') . time() . rand(0, 1000);
        $inputs['action_at'] = date('Y-m-d H');
        $data = Payment::create($inputs);
        if ($data) {
            $user->update(['balance' => $user->balance - $inputs['balance']]);
            $to_user->update(['balance' => $to_user->balance + $inputs['balance']]);
            return $this->apiSuccessResponse($data);
        }

        return $this->apiFailResponse('some thing wrong');
    }
}
