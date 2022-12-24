@extends('layouts.app')

@section('title', ' My Order')

@push('polymer')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/polymer.css') }}">
@endpush

@section('content')
    @if (count($orders))
        <main class="h-full overflow-y-auto">
            <div class="container mx-auto">
                <div class="grid w-full gap-5 px-10 mx-auto md:grid-cols-12">
                    <div class="col-span-8">
                        <h2 class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                            My Orders
                        </h2>
                        <p class="text-sm text-gray-400">
                            {{ auth()->user()->order_freelancer()->count() }} Total Orders
                        </p>
                    </div>
                    <div class="col-span-4 lg:text-right">
                    </div>
                </div>
            </div>
            <section class="container mx-auto mt-5">
                <div class="grid gap-5 md:grid-cols-12">
                    <main class="col-span-12 px-10 pb-4 md:pt-0">
                        <div class="px-6 py-2 mt-2 bg-white rounded-xl">
                            <table class="w-full" aria-label="Table">
                                <thead>
                                    <tr class="text-sm font-normal text-left text-gray-900 border-b border-b-gray-600">
                                        <th class="py-4" scope="">#</th>
                                        <th class="py-4" scope="">Order Buyer Name</th>
                                        <th class="py-4" scope="">Service in Order</th>
                                        <th class="py-4" scope="">Time Left (Days)</th>
                                        <th class="py-4" scope="">Order Status</th>
                                        <th class="py-4" scope="">Available Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <?php $counter = 0; ?>
                                    @forelse ($orders as $key => $order)
                                        <tr class="text-gray-700 @if ($counter < count($orders) - 1) border-b @endif">
                                            <td class="w-16 pr-7 py-5 text-sm">
                                                {{ ++$counter }}
                                            </td>
                                            <td class="w-1/4 pr-7 py-5 text-sm">
                                                <div class="flex items-center text-sm">
                                                    <div class="relative w-10 h-10 mr-3 rounded-full md:block">
                                                        @if ($order->user_buyer->detail_user->photo != null)
                                                            <img class="object-cover w-full h-full rounded-full"
                                                                src="{{ url(Storage::url($order->user_buyer->detail_user->photo)) }}"
                                                                alt="photo freelancer" loading="lazy" />
                                                        @else
                                                            <svg class="object-cover w-full h-full rounded text-gray-300"
                                                                fill="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                        @endif
                                                        <div class="absolute inset-0 rounded-full shadow-inner"
                                                            aria-hidden="true"></div>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-black">
                                                            {{ $order->user_buyer->name ?? '' }}
                                                        </p>
                                                        <p class="text-sm text-gray-400">
                                                            {{ $order->user_buyer->detail_user->role ?? '' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="w-1/4 pr-7 py-5">
                                                <div class="flex items-center text-sm">
                                                    <div class="relative w-10 h-10 mr-3 rounded-full md:block">
                                                        @if ($order->service->thumbnail_service[0]->thumbnail != null)
                                                            <img class="object-cover w-full h-full rounded"
                                                                src="{{ url(Storage::url($order->service->thumbnail_service[0]->thumbnail)) }}"
                                                                alt="photo freelancer" loading="lazy" />
                                                        @else
                                                            <svg class="object-cover w-full h-full rounded text-gray-300"
                                                                fill="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                        @endif
                                                        <div class="absolute inset-0 rounded-full shadow-inner"
                                                            aria-hidden="true"></div>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-black flex-vcenter">
                                                            <span class="text-nowrap" style="max-width: 20rem;">
                                                                {{ $order->service->title ?? '' }}
                                                                <?php
                                                                $given_rating = 0;
                                                                $rating_exist = false;
                                                                ?>
                                                                @foreach ($reviews as $review)
                                                                    @if ($review->order->id == $order->id)
                                                                        <?php
                                                                        $given_rating = $review->rating;
                                                                        $rating_exist = true;
                                                                        ?>
                                                                    @endif
                                                                @endforeach
                                                            </span>
                                                            <span>
                                                                <svg class="inline align-sub ml-3" width="20" height="19"
                                                                    viewBox="0 0 20 19" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M9.04894 0.927052C9.3483 0.00574112 10.6517 0.00573993 10.9511 0.927051L12.4697 5.60081C12.6035 6.01284 12.9875 6.2918 13.4207 6.2918H18.335C19.3037 6.2918 19.7065 7.53141 18.9228 8.10081L14.947 10.9894C14.5966 11.244 14.4499 11.6954 14.5838 12.1074L16.1024 16.7812C16.4017 17.7025 15.3472 18.4686 14.5635 17.8992L10.5878 15.0106C10.2373 14.756 9.7627 14.756 9.41221 15.0106L5.43648 17.8992C4.65276 18.4686 3.59828 17.7025 3.89763 16.7812L5.41623 12.1074C5.55011 11.6954 5.40345 11.244 5.05296 10.9894L1.07722 8.10081C0.293507 7.53141 0.696283 6.2918 1.66501 6.2918H6.57929C7.01252 6.2918 7.39647 6.01284 7.53035 5.60081L9.04894 0.927052Z"
                                                                        @if ($rating_exist) fill="#FFBF47" @else fill="#CCC" @endif />
                                                                </svg>
                                                            </span>
                                                            {{ $given_rating ?? '0' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="w-40 pr-7 py-5 text-sm text-red-500">
                                                @if ($order->order_status_id == 1)
                                                    <span class="text-black">Done</span>
                                                @else
                                                    <div class="flex flex-vcenter">
                                                        <svg width="14" height="14" viewBox="0 0 14 14"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                                            class="inline mr-1.5">
                                                            <path
                                                                d="M7.0002 12.8332C10.2219 12.8332 12.8335 10.2215 12.8335 6.99984C12.8335 3.77818 10.2219 1.1665 7.0002 1.1665C3.77854 1.1665 1.16687 3.77818 1.16687 6.99984C1.16687 10.2215 3.77854 12.8332 7.0002 12.8332Z"
                                                                stroke="#F26E6E" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                            <path d="M7 3.5V7L9.33333 8.16667" stroke="#F26E6E"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        {{ (strtotime($order->expired) - strtotime(date('Y-m-d'))) / 86400 ?? '' }}
                                                        days left
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="w-40 pr-7 py-5 text-sm">
                                                <p
                                                    class="inline text-left
                                                    @if ($order->order_status_id == '1') {{ 'text-green-500' }}
                                                    @elseif ($order->order_status_id == '2')
                                                        {{ 'text-yellow-500' }}
                                                    @elseif ($order->order_status_id == '3')
                                                        {{ 'text-red-500' }}
                                                    @else
                                                        {{ 'text-orange-500' }} @endif">
                                                    {{ $order->order_status->name }}
                                                </p>
                                            </td>
                                            <td class="pr-7 py-5 text-sm">
                                                @if ($order->order_status_id == '1' || $order->order_status_id == '2' || $order->order_status_id == '3')
                                                    <a href="{{ route('member.order.show', $order->id) }}"
                                                        class="px-4 py-2 mr-2 text-center text-white rounded-xl bg-serv-email width-84 inline-block">Details</a>
                                                    @if ($order->order_status_id == '2')
                                                        <a href="{{ route('member.order.edit', $order->id) }}"
                                                            class="px-4 py-2 text-center text-white rounded-xl bg-serv-button width-84 inline-block">Submit</a>
                                                    @else
                                                        <span
                                                            class="px-4 py-2 text-center text-white rounded-xl bg-serv-email no-selection bg-grey-out width-84 inline-block">Submit</span>
                                                    @endif
                                                @elseif ($order->order_status_id == '4')
                                                    <a href="{{ route('member.accept.order', $order->id) }}"
                                                        class="px-4 py-2 mr-2 text-left text-white text-center rounded-xl bg-serv-button width-84 inline-block">
                                                        Accept
                                                    </a>
                                                    <a href="{{ route('member.reject.order', $order->id) }}"
                                                        class="px-4 py-2 text-left text-white text-center rounded-xl bg-serv-button bg-red-500 width-84 inline-block">
                                                        Reject
                                                    </a>
                                                @else
                                                    {{-- {{ 'N/A' }} --}}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        {{-- empty --}}
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </main>
                </div>
            </section>
        </main>
    @else
        <div class="flex h-screen">
            <div class="m-auto text-center">
                <img src="{{ asset('/assets/images/empty-illustration.svg') }}" alt="" class="w-48 mx-auto">
                <h2 class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                    There's No Order Yet
                </h2>
                <p class="text-base text-gray-400">
                    It seems that you don't have any order at this moment. <br>
                    Hope you have an order soon!
                </p>
            </div>
        </div>
    @endif
@endsection
