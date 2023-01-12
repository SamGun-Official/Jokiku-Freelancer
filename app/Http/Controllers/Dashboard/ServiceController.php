<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Service;
use App\Models\Tagline;
use Illuminate\Http\Request;
use App\Models\AdvantageUser;
use App\Models\AdvantageService;
use App\Models\ThumbnailService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Dashboard\Service\StoreServiceRequest;
use App\Http\Requests\Dashboard\Service\UpdateServiceRequest;
use App\Models\Order;
use App\Models\Review;
use File;

class ServiceController extends Controller
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
        $services = Service::where('users_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $orders = Order::whereIn('service_id', $services->pluck("id"))->get();
        $reviews = Review::whereIn('order_id', $orders->pluck('id'))->get();

        return view('pages.dashboard.service.index', compact('services', 'reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            $data['users_id'] = Auth::user()->id;

            // add to service
            $service = Service::create($data);

            // add to advantage service
            foreach ($data['advantage-service'] as $key => $value) {
                $advantage_service = new AdvantageService;
                $advantage_service->service_id = $service->id;
                $advantage_service->advantage = $value;
                $advantage_service->save();
            }

            // add to advantage user
            foreach ($data['advantage-user'] as $key => $value) {
                $advantage_user = new AdvantageUser;
                $advantage_user->service_id = $service->id;
                $advantage_user->advantage = $value;
                $advantage_user->save();
            }

            // add to thumbnail service
            if ($request->hasfile('thumbnail')) {
                foreach ($request->file('thumbnail') as $file) {
                    $path = $file->store(
                        'assets/service/thumbnail',
                        'public'
                    );

                    $thumbnail_service = new ThumbnailService;
                    $thumbnail_service->service_id = $service['id'];
                    $thumbnail_service->thumbnail = $path;
                    $thumbnail_service->save();
                }
            }

            // add to tagline
            foreach ($data['tagline'] as $key => $value) {
                $tagline = new Tagline;
                $tagline->service_id = $service->id;
                $tagline->tagline = $value;
                $tagline->save();
            }

            toast('Save has been success', 'success');
            DB::commit();
            return redirect()->route('member.service.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toast('failed to create', 'error');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        $services = Service::where('id', $service['id'])->first();
        $thumbnail = ThumbnailService::where('service_id', $service['id'])->get();
        $advantage_service = AdvantageService::where('service_id', $service['id'])->get();
        $advantage_user = AdvantageUser::where('service_id', $service['id'])->get();
        $tagline = Tagline::where('service_id', $service['id'])->get();
        $reviews = Review::whereIn('order_id', Order::where([
            ['freelancer_id', auth()->user()->id],
            ['service_id', $service['id']],
        ])->pluck('id'))->get();

        return view('pages.dashboard.service.detail', compact('service', 'services', 'thumbnail', 'advantage_service', 'advantage_user', 'tagline', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $advantage_service = AdvantageService::where('service_id', $service->id)->get();
        $tagline = Tagline::where('service_id', $service['id'])->get();
        $advantage_user = AdvantageUser::where('service_id', $service['id'])->get();
        $thumbnail_service = ThumbnailService::where('service_id', $service['id'])->get();

        return view('pages.dashboard.service.edit', compact('service', 'advantage_service', 'tagline', 'advantage_user', 'thumbnail_service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            // dd($data);

            // update to service
            $service->update($data);

            // update to advantage service
            foreach ($data['advantage-services'] as $key => $value) {
                $advantage_service = AdvantageService::find($key);
                $advantage_service->advantage = $value;
                $advantage_service->save();
            }

            //add new advantage service
            if (isset($data['advantage-service'])) {
                foreach ($data['advantage-service'] as $key => $value) {
                    $advantage_service = new AdvantageService;
                    $advantage_service->service_id = $service['id'];
                    $advantage_service->advantage = $value;
                    $advantage_service->save();
                }
            }

            // update to advantage user
            foreach ($data['advantage-users'] as $key => $value) {
                $advantage_user = AdvantageUser::find($key);
                $advantage_user->advantage = $value;
                $advantage_user->save();
            }

            //add new advantage user
            if (isset($data['advantage-user'])) {
                foreach ($data['advantage-user'] as $key => $value) {
                    $advantage_user = new AdvantageUser;
                    $advantage_user->service_id = $service['id'];
                    $advantage_user->advantage = $value;
                    $advantage_user->save();
                }
            }

            // update to tagline
            foreach ($data['taglines'] as $key => $value) {
                $tagline = Tagline::find($key);
                $tagline->tagline = $value;
                $tagline->save();
            }

            //add new tagline
            if (isset($data['tagline'])) {
                foreach ($data['tagline'] as $key => $value) {
                    $tagline = new Tagline;
                    $tagline->service_id = $service['id'];
                    $tagline->tagline = $value;
                    $tagline->save();
                }
            }

            // update to thumbnail service
            if ($request->hasfile('thumbnails')) {
                foreach ($request->file('thumbnails') as $key => $file) {
                    // get old photo thumbnail
                    $get_photo = ThumbnailService::where('id', $key)->first();

                    // store photo
                    $path = $file->store(
                        'assets/service/thumbnail',
                        'public'
                    );

                    // update thumbail
                    $thumbnail_service = ThumbnailService::find($key);
                    $thumbnail_service->thumbnail = $path;
                    $thumbnail_service->save();

                    // delete old photo thumbnail
                    $data = 'storage/' . $get_photo['photo'];
                    if (File::exists($data)) {
                        File::delete($data);
                    } else {
                        File::delete('storage/app/public/' . $get_photo['photo']);
                    }
                }
            }

            // add to thumbnail service
            if ($request->hasfile('thumbnail')) {
                foreach ($request->file('thumbnail') as $file) {
                    $path = $file->store(
                        'assets/service/thumbnail',
                        'public'
                    );

                    $thumbnail_service = new ThumbnailService;
                    $thumbnail_service->service_id = $service['id'];
                    $thumbnail_service->thumbnail = $path;
                    $thumbnail_service->save();
                }
            }

            toast()->success('Update service successful!');
            DB::commit();
            return redirect()->route('member.service.index');
        } catch (\Throwable $th) {
            toast('Failed to update!', 'error');
            DB::rollBack();
            return back();;
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

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $service = Service::withTrashed()->find($id);
            if ($service->trashed()) {
                $result = $service->restore();
            } else {
                $result = $service->delete();
            }

            toast()->success('Delete service successful!');
            DB::commit();
            return redirect()->route('member.service.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toast('Failed to update!', 'error');
            return back();;
        }
    }
}
