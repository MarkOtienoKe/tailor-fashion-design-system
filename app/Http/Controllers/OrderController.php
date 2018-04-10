<?php

namespace App\Http\Controllers;

use App\Repositories\DocumentRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\TransactionRepository;
use App\Transaction;
use App\ViewModels\OrderView;
use Illuminate\Http\Request;
use App\Http\Requests;
use function view;
use Yajra\Datatables\Datatables;
use Log;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrdersData($status)
    {
        $query = OrderView::select(['order_id', 'amount_to_pay', 'amount_paid', 'balance', 'date_received', 'customer_name', 'date_of_collection', 'description', 'addedby_user_name', 'modifiedby_user_name', 'ip_address', 'created_at', 'order_status'])
            ->where('order_status', '=', $status);
        return Datatables::of($query)
            ->make(true);
    }

    //get orders count
    public function getOrdersCount()
    {
       $orders = OrderView::where('status','=','NEW')
           ->count();
       return $orders;
    }

    public function viewOrders($page)
    {
        $pageView = view('orders.new-orders');
        if ($page == 'partiallypaid') {
            $pageView = view('orders.partially-paid');
        }
        if ($page == 'fullypaid') {
            $pageView = view('orders.fully-paid');
        }
        if ($page == 'closed') {
            $pageView = view('orders.closed');
        }
        if ($page == 'create') {
            $pageView = view('orders.create');
        }
        return $pageView;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createOrder(Request $request)
    {
        $response = OrderRepository::createOrder($request);

        if ($response > 0) {

            return response()->json(['message' => 'success', 'status_code' => 200]);
        } else {

            return response()->json(['errors' => 'action failed', 'status_code' => 500]);
        }
    }

    public function makePayment(Request $request)
    {

        if ($request->hasFile('cheque_image')) {
            $request['payment_document']=$request['cheque_image'];
        }
        $paymentResponse = PaymentRepository::makePayment($request);
        if ($paymentResponse == true) {

            $response = OrderRepository::savePaymentAmount($request);
            if ($response == true) {
                //get the last transaction
                $request['balance'] = $request['amount'];

                $lastTransaction = Transaction::latest()->get()->toArray();

                $lastransActionData = null;
                if (!empty($lastTransaction)) {
                    foreach ($lastTransaction as $data) {

                        $lastransActionData = $data['balance'] + $request['amount'];
                    }
                    $request['balance'] = $lastransActionData;
                }
                TransactionRepository::saveTransaction($request);
            }
            return response()->json(['message' => 'success', 'status_code' => 200]);

        } else {
            return response()->json(['errors' => 'action failed', 'status_code' => 500]);

        }


    }
    public function closeOrder(Request $request)
    {
        $response= OrderRepository::closeOrder($request['order_id']);

        if ($response > 0) {

            return response()->json(['message' => 'success', 'status_code' => 200]);
        } else {

            return response()->json(['errors' => 'action failed', 'status_code' => 500]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
