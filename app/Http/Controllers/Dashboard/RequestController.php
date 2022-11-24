<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
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
        $orders = Order::where('buyer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return view('pages.dashboard.request.index', compact('orders'));
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
    public function show($id)
    {
        $order = Order::where('id', $id)->first();

        return view('pages.dashboard.request.detail', compact('order'));
    }

    public function rating($id)
    {
        $order = Order::where('id',$id)->first();
        // $hasReview = false;
        $review = Review::where('service_id',$order->service_id)->where('users_id',Auth::user()->id)->first();
        return view('pages.dashboard.request.rating', compact('order','review'));
    }

    public function rating_submit(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required',
        ]);

        $order = Order::where('id',$id)->first();
        Review::create([
            'users_id' => Auth::user()->id,
            'service_id' => $order->service_id,
            'comment' => $request->review,
            'rating' => $request->rating,
        ]);

        return redirect()->route('member.request.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return abort(404);
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

    public function  approve($id){
        try {
            DB::beginTransaction();
            $order = Order::where('id', $id)->first();

            // update order
            $order= Order::find($order['id']);
            $order->order_status_id = 1;
            $order->save();

            toast('Approve has been success', 'success');
            DB::commit();
            return redirect()->route('member.request.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            toast('failed to approve', 'error');
            return back();
        }

    }
}
