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
                                <th class="py-4" scope="">Service Deadline</th>
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
                                <td class="px-1 py-5 text-xs text-red-500">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="inline mb-1">
                                        <path d="M7.0002 12.8332C10.2219 12.8332 12.8335 10.2215 12.8335 6.99984C12.8335 3.77818 10.2219 1.1665 7.0002 1.1665C3.77854 1.1665 1.16687 3.77818 1.16687 6.99984C1.16687 10.2215 3.77854 12.8332 7.0002 12.8332Z" stroke="#F26E6E" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M7 3.5V7L9.33333 8.16667" stroke="#F26E6E" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    {{ (strtotime($order->expired) - strtotime(date('Y-m-d'))) / 86400 ?? '' }} days left
                                </td>
                            </tr>
                        </tbody>
                    </table>



                    @if($review)
                        <div>
                            <label for="service-name" class="block mb-3 mx-1 font-medium text-gray-700 text-md">Rating</label>
                            <span>{{ $review->rating }}</span>

                            <div>
                                Review
                                <div>
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
                                {{-- <div class="m-1 flex">
                                    <svg id="star1" aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <svg id="star2" aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Second star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <svg id="star3" aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Third star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <svg id="star4" aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Fourth star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <svg id="star5" aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Fifth star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <input type="hidden" name="rating" value="1" id="rating">
                                </div> --}}
                                <input type="number" class="form-control w-2/6 h-2/6" name="rating" min="1" max="5" id="">
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

<script>
    // let star1 = document.querySelector("#star1");
    // let star2 = document.querySelector("#star2");
    // let star3 = document.querySelector("#star3");
    // let star4 = document.querySelector("#star4");
    // let star5 = document.querySelector("#star5");
    // let rating = document.querySelector("#rating");
    // star1.addEventListener('click', () => {
    //     rating = 1;
    //     star1.className = "w-5 h-5 text-yellow-400";
    //     star2.className = "w-5 h-5 text-gray-300 dark:text-gray-500";
    //     star3.className = "w-5 h-5 text-gray-300 dark:text-gray-500";
    //     star4.className = "w-5 h-5 text-gray-300 dark:text-gray-500";
    //     star5.className = "w-5 h-5 text-gray-300 dark:text-gray-500";
    //     console.log(star2);
    // });
    // star2.addEventListener('click', () => {
    //     rating = 2;
    //     star1.className = "w-5 h-5 text-yellow-400";
    //     star2.className = "w-5 h-5 text-yellow-400";
    //     star3.className = "w-5 h-5 text-gray-300 dark:text-gray-500";
    //     star4.className = "w-5 h-5 text-gray-300 dark:text-gray-500";
    //     star5.className = "w-5 h-5 text-gray-300 dark:text-gray-500";
    // });
    // star3.addEventListener('click', () => {
    //     rating = 3;
    //     star1.className = "w-5 h-5 text-yellow-400";
    //     star2.className = "w-5 h-5 text-yellow-400";
    //     star3.className = "w-5 h-5 text-yellow-400";
    //     star4.className = "w-5 h-5 text-gray-300 dark:text-gray-500";
    //     star5.className = "w-5 h-5 text-gray-300 dark:text-gray-500";
    // });
    // star4.addEventListener('click', () => {
    //     rating = 4;
    //     star1.className = "w-5 h-5 text-yellow-400";
    //     star2.className = "w-5 h-5 text-yellow-400";
    //     star3.className = "w-5 h-5 text-yellow-400";
    //     star4.className = "w-5 h-5 text-yellow-400";
    //     star5.className = "w-5 h-5 text-gray-300 dark:text-gray-500";
    // });
    // star5.addEventListener('click', () => {
    //     rating = 5;
    //     star1.className = "w-5 h-5 text-yellow-400";
    //     star2.className = "w-5 h-5 text-yellow-400";
    //     star3.className = "w-5 h-5 text-yellow-400";
    //     star4.className = "w-5 h-5 text-yellow-400";
    //     star5.className = "w-5 h-5 text-yellow-400";
    // });
</script>

@endsection
