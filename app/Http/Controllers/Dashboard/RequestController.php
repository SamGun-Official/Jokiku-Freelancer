<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
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
        $orders = Order::where('buyer_id', Auth::user()->id)
            ->leftJoin('review', 'review.order_id', '=', 'order.id')
            ->select(['order.*', 'rating', 'comment'])
            ->orderBy('order.created_at', 'desc')->get();
        $reviews = Review::whereIn('order_id', $orders->pluck('id'))->get();

        return view('pages.dashboard.request.index', compact('orders', 'reviews'));
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
        $review = Review::where('order_id', $id)->first();

        return view('pages.dashboard.request.detail', compact('order', 'review'));
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
    public function approve($id)
    {
        try {
            DB::beginTransaction();
            $order = Order::where('id', $id)->first();

            // update order
            $order = Order::find($order['id']);
            $order->order_status_id = 1;
            $order->status_bayar = 1;
            $service_id = $order->service_id;
            $service = Service::where('id', $service_id)->select(['users_id', 'price'])->first();
            $user_id = $service['users_id'];
            $price = $service['price'];
            $order->save();

            $user = User::find($user_id);
            $user->account_balance += $price;
            $user->save();

            toast('Payment has been confirmed!', 'success');
            DB::commit();
            return redirect()->route('member.request.index');
        } catch (\Throwable $th) {
            toast('Failed to pay!', 'error');
            DB::rollBack();
            return back();
        }
    }

    public function rating($id)
    {
        $order = Order::where('id', $id)->first();
        $review = Review::where('order_id', $id)->where('users_id', Auth::user()->id)->first();

        return view('pages.dashboard.request.rating', compact('order', 'review'));
    }

    public function rating_submit(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required',
        ]);

        Review::create([
            'users_id' => Auth::user()->id,
            'order_id' => $id,
            'comment' => $request->review,
            'rating' => $request->rating,
        ]);

        return redirect()->route('member.request.index');
    }
}
