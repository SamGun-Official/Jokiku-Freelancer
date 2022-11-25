@extends('layouts.app')

@section('title', ' Detail Request')

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container mx-auto">
        <div class="grid w-full gap-5 px-10 mx-auto md:grid-cols-12">
            <div class="col-span-8">
                <h2 class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                    My Requests
                </h2>
                <p class="text-sm text-gray-400">
                    {{ auth()->user()->order_buyer()->count() }} Total Requests
                </p>
            </div>
            <div class="col-span-4 lg:text-right">

            </div>
        </div>
    </div>

    <section class="container px-6 mx-auto mt-5">
        <div class="grid gap-5 md:grid-cols-12">
            <main class="col-span-12 p-4 md:pt-0">
                <div class="px-6 py-2 mt-2 bg-white rounded-xl">
                    <table class="w-full" aria-label="Table">
                        <thead>
                            <tr class="text-sm font-normal text-left text-gray-900 border-b border-b-gray-600">
                                <th class="py-4" scope="">Freelancer Name</th>
                                <th class="py-4" scope="">Service Details</th>
                                <th class="py-4" scope="">Service Price</th>
                                {{-- <th class="py-4" scope="">Service Deadline</th> --}}
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr class="mb-10 text-gray-700">
                                <td class="px-1 py-5 text-sm w-2/8">
                                    <div class="flex items-center text-sm">
                                        <div class="relative w-10 h-10 mr-3 rounded-full md:block">

                                            @if ($order->user_freelancer->detail_user->photo != NULL)
                                                <img class="object-cover w-full h-full rounded-full" src="{{ url(Storage::url($order->user_freelancer->detail_user->photo)) }}" alt="photo freelancer" loading="lazy" />

                                            @else
                                                <svg class="object-cover w-full h-full rounded-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            @endif

                                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                        </div>
                                        <div>
                                            <p class="font-medium text-black">{{ $order->user_freelancer->name ?? '' }}</p>
                                            <p class="text-sm text-gray-400">{{ $order->user_freelancer->detail_user->role ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="w-2/6 px-1 py-5">
                                    <div class="flex items-center text-sm">
                                        <div class="relative w-10 h-10 mr-3 rounded-full md:block">
                                            @if ($order->service->thumbnail_service[0]->thumbnail != NULL)
                                                <img class="object-cover w-full h-full rounded" src="{{ url(Storage::url($order->service->thumbnail_service[0]->thumbnail)) }}" alt="photo freelancer" loading="lazy" />

                                            @else
                                                <svg class="object-cover w-full h-full rounded text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium text-black">
                                                {{ $order->service->title ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-1 py-5 text-sm">
                                    {{ 'Rp '.number_format($order->service->price) ?? '' }}
                                </td>
                                {{-- <td class="px-1 py-5 text-xs text-red-500">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="inline mb-1">
                                        <path d="M7.0002 12.8332C10.2219 12.8332 12.8335 10.2215 12.8335 6.99984C12.8335 3.77818 10.2219 1.1665 7.0002 1.1665C3.77854 1.1665 1.16687 3.77818 1.16687 6.99984C1.16687 10.2215 3.77854 12.8332 7.0002 12.8332Z" stroke="#F26E6E" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M7 3.5V7L9.33333 8.16667" stroke="#F26E6E" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    {{ (strtotime($order->expired) - strtotime(date('Y-m-d'))) / 86400 ?? '' }} days left
                                </td> --}}
                            </tr>
                        </tbody>
                    </table>



                    @if($review)
                        <div>
                            <label for="service-name" class="mb-1 mx-1 font-medium text-gray-700 text-md">Rating</label>
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < $review->rating)
                                    <svg width="18" height="16" viewBox="0 0 26 24" fill="none"
                                    class="inline align-sub" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.0489 0.927052C12.3483 0.00574112 13.6517 0.00573993 13.9511 0.927051L16.1432 7.67376C16.2771 8.08578 16.661 8.36475 17.0943 8.36475H24.1882C25.1569 8.36475 25.5597 9.60436 24.7759 10.1738L19.0369 14.3435C18.6864 14.5981 18.5397 15.0495 18.6736 15.4615L20.8657 22.2082C21.1651 23.1295 20.1106 23.8956 19.3269 23.3262L13.5878 19.1565C13.2373 18.9019 12.7627 18.9019 12.4122 19.1565L6.67312 23.3262C5.88941 23.8956 4.83493 23.1295 5.13428 22.2082L7.32642 15.4615C7.46029 15.0495 7.31363 14.5981 6.96315 14.3435L1.22405 10.1738C0.440337 9.60436 0.843112 8.36475 1.81184 8.36475H8.90575C9.33897 8.36475 9.72293 8.08578 9.8568 7.67376L12.0489 0.927052Z"
                                            fill="#FFBF47" />
                                    </svg>
                                @else
                                    <svg width="18" height="16" viewBox="0 0 26 24" fill="none"
                                    class="inline align-sub" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.0489 0.927052C12.3483 0.00574112 13.6517 0.00573993 13.9511 0.927051L16.1432 7.67376C16.2771 8.08578 16.661 8.36475 17.0943 8.36475H24.1882C25.1569 8.36475 25.5597 9.60436 24.7759 10.1738L19.0369 14.3435C18.6864 14.5981 18.5397 15.0495 18.6736 15.4615L20.8657 22.2082C21.1651 23.1295 20.1106 23.8956 19.3269 23.3262L13.5878 19.1565C13.2373 18.9019 12.7627 18.9019 12.4122 19.1565L6.67312 23.3262C5.88941 23.8956 4.83493 23.1295 5.13428 22.2082L7.32642 15.4615C7.46029 15.0495 7.31363 14.5981 6.96315 14.3435L1.22405 10.1738C0.440337 9.60436 0.843112 8.36475 1.81184 8.36475H8.90575C9.33897 8.36475 9.72293 8.08578 9.8568 7.67376L12.0489 0.927052Z"
                                            fill="#808080" />
                                    </svg>
                                @endif
                            @endfor

                            <label for="service-name" class="block mt-3 mx-1 font-medium text-gray-700 text-md">Review</label>
                                <div class="border border-spacing-1 p-3 rounded-md text-sm">
                                    {{ $review->comment }}
                                </div>
                            </div>
                        </div>
                        <div class="col-span-6">
                            {!! RecaptchaV3::field('input') !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <p class="text-red-500 mb-3 text-sm">{{ $errors->first('g-recaptcha-response') }}</p>
                            @endif
                        </div>

                    @else
                        <form action="{{ route('member.request.rating.submit',$order->id) }}" method="POST">
                            @csrf
                            <div>
                                <label for="service-name" class="block mb-3 mx-1 font-medium text-gray-700 text-md">Rating</label>

                                <input type="number" class="form-control w-2/6 h-2/6 m-2" name="rating" min="1" max="5" id="" value="1">
                            </div>
                            <div class="">
                                <div class="p-1 mt-5">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6">
                                            <label for="service-name" class="block mb-3 font-medium text-gray-700 text-md">Review</label>
                                            <textarea placeholder="Enter your review here" type="text" name="review" id="" class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" rows="4"></textarea>
                                        </div>

                                        <div class="col-span-6">
                                            {!! RecaptchaV3::field('input') !!}
                                            @if ($errors->has('g-recaptcha-response'))
                                                <p class="text-red-500 mb-3 text-sm">{{ $errors->first('g-recaptcha-response') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="px-1 py-4 text-right">
                                    <button class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" onclick="return confirm('Are you sure want to approve this data?')">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>

                    @endif
                </div>
            </main>
        </div>
    </section>
</main>

@endsection
