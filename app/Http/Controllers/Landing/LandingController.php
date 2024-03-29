<?php

namespace App\Http\Controllers\Landing;

use App\Models\Service;
use App\Models\Tagline;
use Illuminate\Http\Request;
use App\Models\AdvantageUser;
use App\Models\AdvantageService;
use App\Models\ThumbnailService;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $services = Service::where('status', '1')->orderBy('created_at', 'desc')->get();
        if(auth()->user() == null) {
            $services = Service::orderBy('created_at', 'desc')->get();
        } else {
            $services = Service::where([
                ['status', '1'],
                ['users_id', '<>', auth()->user()->id],
            ])->orderBy('created_at', 'desc')->get();
        }

        return view('pages.landing.index', compact('services'));
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
        return abort(404);
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
    public function explore()
    {
        // User cannot see their own services.
        if(auth()->user() == null) {
            $services = Service::orderBy('created_at', 'desc')->get();
        } else {
            $services = Service::where([
                ['status', '1'],
                ['users_id', '<>', auth()->user()->id],
            ])->orderBy('created_at', 'desc')->get();
        }

        return view('pages.landing.explore', compact('services'));
    }

    public function detail($id)
    {
        $service = Service::where('id', $id)->first();
        $thumbnail = ThumbnailService::where('service_id', $id)->get();
        $advantage_user = AdvantageUser::where('service_id', $id)->get();
        $advantage_service = AdvantageService::where('service_id', $id)->get();
        $tagline = Tagline::where('service_id', $id)->get();
        $review = Order::join('review', 'review.order_id', 'order.id')->where('service_id', $id)->orderByDesc('rating')->get();

        // $thumbnail = ThumbnailService::where('service_id', $service['id'])->get();
        // $advantage_service = AdvantageService::where('service_id', $service['id'])->get();
        // $advantage_user = AdvantageUser::where('service_id', $service['id'])->get();
        // $tagline = Tagline::where('service_id', $service['id'])->get();
        // $reviews = Review::whereIn('order_id', Order::where([
        //     ['freelancer_id', auth()->user()->id],
        //     ['service_id', $id],
        // ])->pluck('id'))->get();

        return view('pages.landing.detail', compact('service', 'thumbnail', 'advantage_user', 'advantage_service', 'tagline', 'review'));
    }

    public function booking($id)
    {
        $service = Service::where('id', $id)->first();
        $user_buyer = Auth::user()->id;

        // validation booking
        if ($service->users_id == $user_buyer) {
            toast('Sorry, members cannot book their own service!', 'warning');
            return back();
        }

        $order = new Order;
        $order->buyer_id = $user_buyer;
        $order->freelancer_id = $service->user->id;
        $order->service_id = $service->id;
        $order->file = NULL;
        $order->note = NULL;
        $order->expired = Date('y-m-d', strtotime('+3 Days'));
        $order->order_status_id = 4;
        $order->save();

        $order_detail = Order::where('id', $order->id)->first();

        return redirect()->route('detail.booking.landing', $order->id);
    }

    public function detail_booking($id)
    {
        $order = Order::where('id', $id)->first();

        return view('pages.landing.booking', compact('order'));
    }
}
