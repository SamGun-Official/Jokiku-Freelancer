<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Service;
use App\Models\Tagline;
use Illuminate\Http\Request;
use App\Models\AdvantageUser;
use App\Models\AdvantageService;
use App\Models\ThumbnailService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Dashboard\MyOrder\UpdateMyOrderRequest;
use Illuminate\Support\Facades\DB;

class MyOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('freelancer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return view('pages.dashboard.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $service = Service::where('id', $order['service_id'])->first();
        $thumbnail = ThumbnailService::where('service_id', $order['service_id'])->get();
        $advantage_service = AdvantageService::where('service_id', $order['service_id'])->get();
        $advantage_user = AdvantageUser::where('service_id', $order['service_id'])->get();
        $tagline = Tagline::where('service_id', $order['service_id'])->get();

        return view('pages.dashboard.order.detail', compact('order', 'thumbnail', 'advantage_service', 'advantage_user', 'tagline', 'service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('pages.dashboard.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMyOrderRequest $request, Order $order)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            if (isset($data['file'])){
                $data['file'] = $request->file('file')->store(
                    'assets/order/attachment', 'public'
                );

                $order = Order::find($order->id);
                $order->file = $data['file'];
                $order->note = $data['note'];
                $order->save();

                toast('Submit order has been success', 'success');
                DB::commit();
                return redirect()->route('member.order.index');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            toast('failed to update', 'error');
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return abort(404);
    }

    // custom

    public function accepted($id){
        try {
            DB::beginTransaction();
            $order = Order::find($id);
            $order->order_status_id = 2;
            $order->save();

            toast('Accept order has been success', 'success');
            DB::commit();
            return back();
        } catch (\Throwable $th) {
            DB::rollBack();
            toast('failed to accept', 'error');
            return back();
        }
    }

    public function rejected($id){
        try {
            DB::beginTransaction();
            $order = Order::find($id);
            $order->order_status_id = 3;
            $order->save();

            toast('Reject order has been success', 'success');
            DB::commit();
            return back();
        } catch (\Throwable $th) {
            DB::rollBack();
            toast('failed to reject', 'error');
            return back();
        }

    }
}
