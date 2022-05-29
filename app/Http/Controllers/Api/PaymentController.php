<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionDesignerRequest;
use App\Http\Requests\TransactionStoreRequest;
use App\Models\Cart;
use App\Models\TransactionDesigner;
use App\Models\TransactionStore;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Midtrans\Config;


class PaymentController extends Controller
{
    private $cart;
    public function __construct()
    {
        $this->cart = new Cart();
        Config::$isProduction = env("PRODUCTION");
        Config::$serverKey = env("SERVER_KEY");
        Config::$isSanitized = false;
        Config::$is3ds = false;
    }

    public function createTransactionStore(TransactionStoreRequest $request, PaymentService $payment_services, TransactionStore $transaction): \Illuminate\Http\JsonResponse
    {
        $cart                               = $this->cart->getCart((new User)->get_customer_id());
        if (count($cart) == 0)  return response()->json(['message' => "Cart is empty",], 500);
        $invoice                            = $transaction->generate_invoice();
        $transaction_value                  = $transaction->creatingTransaction($invoice, $request->validated(), $cart);
        if (!$transaction_value)  return response()->json(['message' => "Transaction cannot be made",], 500);
        $transactionStore                   = TransactionStore::query()->where('invoice', $invoice)->first();
        $generatedData                      = $payment_services->generatingData($invoice, $request->validated(), 'Store');
        return $this->transaction($generatedData, $transactionStore);
    }

    public function createTransactionDesigner(TransactionDesignerRequest $request, PaymentService $payment_services, TransactionDesigner $transaction): \Illuminate\Http\JsonResponse
    {
        $data                                   = $request->validated();
        $invoice                                = $transaction->generate_invoice();
        $transaction->creatingTransaction($invoice, $data);
        $transactionDesigner                    = TransactionDesigner::query()->where('invoice', $invoice)->first();
        $generatedData                          = $payment_services->generatingData($invoice, $data, 'Designer');
        return $this->transaction($generatedData, $transactionDesigner);
    }

    public function get_status(Request $request): \Illuminate\Http\JsonResponse
    {
        $status = \Midtrans\Transaction::status(urlencode($request->invoice));
        if ($status->payment_type == 'echannel') {
            $status->va_numbers = [
                [
                    'bank' => 'mandiri',
                    'va_number' => $status->biller_code . $status->bill_key
                ]
            ];
        }

        return response()->json([
            'status' => $status,
        ]);
    }

    public function approve(Request $request): \Illuminate\Http\JsonResponse
    {
        $approve = \Midtrans\Transaction::approve($request->invoice);
        return response()->json([
            'approve' => $approve,
        ]);
    }

    public function cancel(Request $request): \Illuminate\Http\JsonResponse
    {
        $cancel = \Midtrans\Transaction::cancel($request->invoice);
        return response()->json([
            'cancel' => $cancel,
        ]);
    }

    public function refund(Request $request): \Illuminate\Http\JsonResponse
    {
        $refunds = array(
            'refund_key' => 'order1-ref1',
            'amount' => $request->amount,
            'reason' => 'Deadline Expire'
        );
        $refund = \Midtrans\Transaction::refund($request->external_id, $refunds);
        return response()->json([
            'refund' => $refund,
        ]);
    }

    public function transaction($generatedData, $transaction): \Illuminate\Http\JsonResponse
    {
        try {
            $charge = \Midtrans\CoreApi::charge($generatedData);
            if ($charge->payment_type == 'echannel') {
                $charge->va_numbers = [
                    [
                        'bank' => 'mandiri',
                        'va_number' => $charge->biller_code . $charge->bill_key
                    ]
                ];
            }
            $transaction->transaction_id = $charge->transaction_id;
            $transaction->update();
            return response()->json([
                'data' => $charge,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => $e,
            ], 500);
        }
    }
}
