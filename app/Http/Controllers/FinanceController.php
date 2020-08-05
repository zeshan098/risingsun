<?php

namespace App\Http\Controllers;

use App\Product;
use App\Customer;
use App\City;
use App\Product_Location;
use App\Billing;
use App\Statement;
use App\PaymentReceipt;
use App\Product_Sale;
use App\CreditNote;
use App\GetBalance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class FinanceController extends Controller
{
    public function get_statement(Request $request)
    {
        $customer_list = Customer::where('status', '=', '1')->get();
        $StatementRecords = null;
        $company_name = "";
        if ($request->method() == "POST") {
            $company_name = $request->input('company_name');
            $StatementRecords = Statement::where('company_name', '=', $company_name)
                ->OrderBy('id', 'ASC')->get();
        }

        return view('admin.finance.statement', compact(['StatementRecords', 'customer_list', 'company_name']));
    }

    public function get_payment_receipt(Request $request)
    {
        $customer_list = Customer::where('status', '=', '1')->get();
        // $StatementRecords = null;
        // $company_name = "";
        $PaymentReceipts = PaymentReceipt::all();
        // if ($request->method() == "POST") {

        // }

        return view('admin.finance.get_payment_receipt', compact(['PaymentReceipts', 'customer_list']));
    }
    public function post_payment_receipt(Request $request)
    {
        $customer_list = Customer::where('status', '=', '1')->get();
        // $StatementRecords = null;
        // $company_name = "";
        $PaymentReceipts = PaymentReceipt::all();
        $customer = Customer::where('company_name', '=', $request->input('company_name'))->first();
        $company_name = $request->input('company_name');
        $payment_receipt = PaymentReceipt::create([
            'company_name' => $company_name,
            'amount' => $request->input('amount')
        ]);
        $payment_receipt_number = "PR-" . $payment_receipt->id;
        $payment_receipt->payment_receipt_number = $payment_receipt_number;
        $payment_receipt->save();
        // Settle Customer Balance
        $customer->balance = $customer->balance + $request->input('amount');
        // Add to statement as well that you received payment
        $statement = Statement::create([
            'type' => "Payment Receipt",
            'document_number' => $payment_receipt_number,
            'company_name' => $company_name,
            'debit' => '0.00',
            'credit' => $request->input('amount'),
            'balance' => $customer->balance,
        ]);
        $customer->save();
        // if ($request->method() == "POST") {

        // }
        return redirect()->route('get-payment-receipt', compact(['PaymentReceipts', 'customer_list']));
        // return view('admin.finance.get_payment_receipt', compact(['PaymentReceipts', 'customer_list']));
    }

    public function get_payment_balance(Request $request)
    {
        $customer_list = Customer::where('status', '=', '1')->get(); 
        $city_list = \DB::table('cities')->where('status', '=', '1')->get();
        $getbalance = GetBalance::all(); 
        return view('admin.get_balance.get_payment_balance', compact(['getbalance', 'customer_list', 'city_list']));
    }
    public function post_payment_balance(Request $request)
    {
        $customer_list = Customer::where('status', '=', '1')->get();
        // $StatementRecords = null;
        // $company_name = "";
        $getbalance = GetBalance::all();
        $customer = Customer::where('company_name', '=', $request->input('company_name'))->first();
        $company_name = $request->input('company_name');
        $payment_receipt = GetBalance::create([
            'company_name' => $company_name,
            'amount' => abs($request->input('amount'))
        ]);
        $payment_get_number = "PG-" . $payment_receipt->id;
        $payment_receipt->payment_get_number = $payment_get_number;
        $payment_receipt->save();
        // Settle Customer Balance
        $customer->balance = $customer->balance + $request->input('amount');
        // Add to statement as well that you received payment
        $statement = Statement::create([
            'type' => "Payment Receipt",
            'document_number' => $payment_get_number,
            'company_name' => $company_name,
            'debit' => '0.00',
            'credit' => abs($request->input('amount')),
            'balance' => $request->input('amount'),
        ]);
        $customer->save();
        // if ($request->method() == "POST") {

        // }
        return redirect()->route('get-payment-balance', compact(['getbalance', 'customer_list']));
        // return view('admin.finance.get_payment_receipt', compact(['PaymentReceipts', 'customer_list']));
    }

    public function return_product(Request $request)
    {
        $product_sale_id = $request->input('product_sale_id');
        $comments = $request->input('comments');
        $product_sale = Product_Sale::find($product_sale_id);
        $bill_id = $product_sale->bill_id;
        $bill = Billing::find($bill_id);
        $customer = Customer::find($bill->customer_id);
        // $returned_amount = 0;
        // if ($request->input('is_returned')) {
        //     $returned_amount = $request->input('returned_amount');
        // }
        $credit_note = CreditNote::create([
            'company_name' => $customer->company_name,
            'discounted_amount' => $product_sale->discounted_amount,
            'qty' => $product_sale->qty,
            'comments' => $comments,
            'product_sale_id' => $product_sale->id,
            'original_amount' => $product_sale->discounted_amount,
            'returned_amount' => $product_sale->discounted_amount,
        ]);
        $credit_note->credit_note_number = "CN-" . $credit_note->id;
        $credit_note->save();

        // if($returned_amount == 0){
        //     $customer->balance = $customer->balance + $product_sale->discounted_amount;
        //     $statement = Statement::create([
        //         'type' => "Credit Note",
        //         'document_number' => "CN-" . $credit_note->id,
        //         'company_name' => $customer->company_name,
        //         'debit' => '0.00',
        //         'credit' => $product_sale->discounted_amount,
        //         'balance' => $customer->balance,
        //     ]);
        //     $customer->save();
        // }

        $customer->balance = $customer->balance + $product_sale->discounted_amount; // Adding for returning product
        $statement = Statement::create([
            'type' => "Credit Note",
            'document_number' => "CN-" . $credit_note->id,
            'company_name' => $customer->company_name,
            'debit' => '0.00',
            'credit' => $product_sale->discounted_amount,
            'balance' => $customer->balance,
        ]);
        //When we implement custom amount return then we will make changes in following
        $customer->balance = $customer->balance - $product_sale->discounted_amount; // Sutracting for returning product amount
        $statement = Statement::create([
            'type' => "Returned",
            'document_number' => "CN-" . $credit_note->id,
            'company_name' => $customer->company_name,
            'debit' => $product_sale->discounted_amount,
            'credit' => '0.00',
            'balance' => $customer->balance,
        ]);
        $customer->save();
        $product_sale->is_returned = 1;
        $product_sale->save();

        return redirect()->route('view_invoice', ['id' => $bill_id]);
    }
}
