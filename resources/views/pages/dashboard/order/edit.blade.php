@extends('layouts.app')

@section('title', ' Order Details')

@push('polymer')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/polymer.css') }}">
@endpush

@section('content')
    <main class="h-full overflow-y-auto flex-column">
        <div class="container mx-auto">
            <div class="grid w-full gap-5 px-10 mx-auto md:grid-cols-12">
                <div class="col-span-8">
                    <h2 class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                        Order Details
                    </h2>
                    <p class="text-sm text-gray-400">
                        Submit Your Work
                    </p>
                </div>
                <div class="col-span-4 lg:text-right">
                </div>
            </div>
        </div>
        <section class="container mx-auto mt-5 flex flex-grow">
            <div class="grid gap-5 md:grid-cols-12 flex-grow">
                <main class="mb-8 col-span-12 px-10 md:pt-0 flex">
                    <div class="px-6 pt-2 pb-6 mt-2 bg-white rounded-xl flex-column flex-grow">
                        <table class="w-full" aria-label="Table">
                            <thead>
                                <tr class="text-sm font-normal text-left text-gray-900 border-b border-b-gray-600">
                                    <th class="px-0 py-4" scope="">Order Buyer Name</th>
                                    <th class="px-0 py-4" scope="">Service in Order</th>
                                    <th class="px-0 py-4" scope="">Service Price</th>
                                    <th class="px-0 py-4" scope="">Time Left (Days)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr class="text-gray-700">
                                    <td class="w-1/4 pr-10 py-5">
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
                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-medium text-black">{{ $order->user_buyer->name ?? '' }}</p>
                                                <p class="text-sm text-gray-400">
                                                    {{ $order->user_buyer->detail_user->role ?? '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="w-1/4 pr-10 py-5">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-10 h-10 mr-3 rounded-full md:block">
                                                @if (count($order->service->thumbnail_service) > 0)
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
                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-medium text-black flex-vcenter">
                                                    <span class="text-nowrap" style="max-width: 20rem;">
                                                        <a href="{{ route('member.service.show', ['service' => $order->service->id]) }}"
                                                            class="font-medium text-black title-url">
                                                            {{ $order->service->title ?? '' }}
                                                        </a>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="w-1/4 pr-10 py-5 text-sm">
                                        {{ 'Rp ' . number_format($order->service->price) ?? '' }}
                                    </td>
                                    <td class="w-1/4 pr-10 py-5 text-sm text-red-500">
                                        <?php
                                        date_default_timezone_set('Asia/Jakarta');

                                        $remaining_day = (strtotime($order->expired) - strtotime(date('Y-m-d'))) / 86400;
                                        ?>
                                        @if ($order->order_status_id == 1)
                                            <span class="text-black">Done</span>
                                        @elseif ($order->order_status_id == 3)
                                            <span class="text-black">-</span>
                                        @else
                                            <div class="flex flex-vcenter">
                                                @if ($remaining_day >= 0)
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg" class="inline mr-1.5">
                                                        <path
                                                            d="M7.0002 12.8332C10.2219 12.8332 12.8335 10.2215 12.8335 6.99984C12.8335 3.77818 10.2219 1.1665 7.0002 1.1665C3.77854 1.1665 1.16687 3.77818 1.16687 6.99984C1.16687 10.2215 3.77854 12.8332 7.0002 12.8332Z"
                                                            stroke="#F26E6E" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path d="M7 3.5V7L9.33333 8.16667" stroke="#F26E6E"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                @endif
                                                @if ($remaining_day > 0)
                                                    {{ $remaining_day ?? '' }}
                                                    @if ($remaining_day > 1)
                                                        days left
                                                    @else
                                                        day left
                                                    @endif
                                                @elseif ($remaining_day == 0)
                                                    Today
                                                @else
                                                    Late
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <form action="{{ route('member.order.update', [$order->id]) }}" method="POST"
                            enctype="multipart/form-data" class="flex-column flex-grow">
                            @method('PUT')
                            @csrf
                            <div class="flex p-8 border border-gray-300 rounded-lg bg-serv-upload-bg flex-grow">
                                <div class="w-2/3 flex-column">
                                    <label for="note" class="block mb-3 font-medium text-gray-700 text-md">Upload
                                        File</label>
                                    <div
                                        class="flex flex-grow align-center p-8 mr-8 border border-gray-300 rounded-lg bg-serv-upload-bg no-selection">
                                        <div class="m-auto text-center">
                                            <img src="{{ asset('/assets/images/services-file-icon.svg') }}" alt=""
                                                class="w-20 mx-auto">
                                            @if (isset($order->file))
                                                <h2 class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                                                    {{ substr($order->file, -10) ?? '' }}
                                                </h2>
                                            @else
                                                <h2 id="filename" class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                                                    Upload Your Work Here
                                                </h2>
                                                <p class="text-sm text-gray-400">
                                                    Browse for a file by clicking on "Choose File"
                                                </p>
                                            @endif
                                            <div class="relative mt-0 md:mt-6">
                                                @if (isset($order->file))
                                                    <a href="{{ url(Storage::url($order->file ?? '')) }}"
                                                        class="px-4 py-2 mt-2 text-left text-gray-700 rounded-xl bg-serv-hr"
                                                        onclick="return confirm('Are you sure you want to download this file?')">
                                                        Download File
                                                    </a>
                                                @else
                                                    @if ($remaining_day >= 0)
                                                        <input type="file" accept=".zip" id="choose"
                                                            name="file" hidden required onchange="fileChosen()">
                                                    @endif
                                                    <label for="choose"
                                                        class="px-4 py-2 mt-2 text-left text-gray-700 rounded-xl bg-serv-hr"
                                                        @if ($remaining_day < 0) style="cursor: not-allowed;" @else style="cursor: pointer;" @endif>
                                                        Choose File
                                                    </label>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($errors->has('file'))
                                            <p class="text-red-500 mb-3 text-sm">{{ $errors->first('file') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="w-1/3 flex-column">
                                    <div class="h-1/2 flex-column" id="note-area">
                                        <div class="grid grid-cols-6 gap-6 flex-grow">
                                            <div class="col-span-6 flex-column">
                                                <label for="note"
                                                    class="block mb-3 font-medium text-gray-700 text-md">Note For Buyer
                                                    (Optional)</label>
                                                <textarea placeholder="Enter your submission notes for the buyer here..." type="text" name="note"
                                                    id="note" autocomplete="note"
                                                    class="block w-full py-3 flex-grow border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 sm:text-sm mb-8 @if (isset($order->file) || $remaining_day < 0) no-selection @endif"
                                                    style="resize: none; @if (isset($order->file) || $remaining_day < 0) cursor: not-allowed; @endif" rows="4"
                                                    {{ isset($order->file) || $remaining_day < 0 ? 'disabled readonly unselectable=on' : '' }}>{{ $order->note ?? '' }}</textarea>
                                                @if ($errors->has('note'))
                                                    <p class="text-red-500 mb-3 text-sm">{{ $errors->first('note') }}</p>
                                                @endif
                                            </div>
                                            <div class="col-span-6 hidden">
                                                {!! RecaptchaV3::field('input') !!}
                                                @if ($errors->has('g-recaptcha-response'))
                                                    <p class="text-red-500 mb-3 text-sm">
                                                        {{ $errors->first('g-recaptcha-response') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-1/2 flex-column" id="review-area"
                                        @if ($review != null) class="hidden" @endif>
                                        @if ($buyer != null)
                                            <label for="note"
                                                class="block mb-3 font-medium text-gray-700 text-md">Review</label>
                                            <div class="flex flex-grow border border-gray-300 rounded-lg"
                                                style="overflow-y: auto;">
                                                <!--horizantil margin is just for display-->
                                                <div class="flex flex-grow items-start p-6">
                                                    @if ($buyer->detail_user->photo != null)
                                                        <img class="w-16 h-16 rounded-full object-cover mr-6"
                                                            src="{{ url(Storage::url($buyer->detail_user->photo)) }}"
                                                            alt="photo profile">
                                                    @else
                                                        <svg class="w-16 h-16 rounded-full object-cover mr-6 text-gray-300"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                        </svg>
                                                    @endif
                                                    <div class="w-full">
                                                        <div class="flex items-center justify-between">
                                                            <h2 class="text-xl font-medium text-serv-bg my-1">
                                                                {{ $buyer->name }}</h2>
                                                        </div>
                                                        <p class="text-md">
                                                            @for ($i = 0; $i < 5; $i++)
                                                                @if ($i < $review->rating)
                                                                    <svg width="14" height="13"
                                                                        viewBox="0 0 26 24" fill="none"
                                                                        class="inline align-sub"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M12.0489 0.927052C12.3483 0.00574112 13.6517 0.00573993 13.9511 0.927051L16.1432 7.67376C16.2771 8.08578 16.661 8.36475 17.0943 8.36475H24.1882C25.1569 8.36475 25.5597 9.60436 24.7759 10.1738L19.0369 14.3435C18.6864 14.5981 18.5397 15.0495 18.6736 15.4615L20.8657 22.2082C21.1651 23.1295 20.1106 23.8956 19.3269 23.3262L13.5878 19.1565C13.2373 18.9019 12.7627 18.9019 12.4122 19.1565L6.67312 23.3262C5.88941 23.8956 4.83493 23.1295 5.13428 22.2082L7.32642 15.4615C7.46029 15.0495 7.31363 14.5981 6.96315 14.3435L1.22405 10.1738C0.440337 9.60436 0.843112 8.36475 1.81184 8.36475H8.90575C9.33897 8.36475 9.72293 8.08578 9.8568 7.67376L12.0489 0.927052Z"
                                                                            fill="#FFBF47" />
                                                                    </svg>
                                                                @else
                                                                    <svg width="14" height="13"
                                                                        viewBox="0 0 26 24" fill="none"
                                                                        class="inline align-sub"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M12.0489 0.927052C12.3483 0.00574112 13.6517 0.00573993 13.9511 0.927051L16.1432 7.67376C16.2771 8.08578 16.661 8.36475 17.0943 8.36475H24.1882C25.1569 8.36475 25.5597 9.60436 24.7759 10.1738L19.0369 14.3435C18.6864 14.5981 18.5397 15.0495 18.6736 15.4615L20.8657 22.2082C21.1651 23.1295 20.1106 23.8956 19.3269 23.3262L13.5878 19.1565C13.2373 18.9019 12.7627 18.9019 12.4122 19.1565L6.67312 23.3262C5.88941 23.8956 4.83493 23.1295 5.13428 22.2082L7.32642 15.4615C7.46029 15.0495 7.31363 14.5981 6.96315 14.3435L1.22405 10.1738C0.440337 9.60436 0.843112 8.36475 1.81184 8.36475H8.90575C9.33897 8.36475 9.72293 8.08578 9.8568 7.67376L12.0489 0.927052Z"
                                                                            fill="#CCC" />
                                                                    </svg>
                                                                @endif
                                                            @endfor
                                                            <span
                                                                class="text-serv-yellow font-medium mt-2 ml-2 inline align-sub">{{ $review->rating }}</span>
                                                        </p>
                                                        <div class="mt-2 flex items-center">
                                                            <div class="flex mr-2 text-serv-text text-md">
                                                                Published in
                                                                {{ date('d F Y', strtotime($review->updated_at)) }}
                                                            </div>
                                                        </div>
                                                        <p class="mt-3 text-gray-700 text-sm leading-8 text-nowrap">
                                                            {{ $review->comment }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 text-right">
                                @if (isset($order->file) == false && $remaining_day >= 0)
                                    <a href="{{ route('member.order.index') }}" type="button"
                                        class="px-4 py-2 text-left text-white text-center rounded-xl bg-serv-email-override width-84 inline-block text-sm mr-2"
                                        onclick="return confirm('Are you sure you want to go back? Any changes you make will not be saved.')">
                                        Back
                                    </a>
                                    <button type="submit" id="submitBtn"
                                        class="px-4 py-2 text-left text-white text-center rounded-xl width-84 inline-block text-sm bg-grey-out"
                                        onclick="return confirm('Are you sure you want to submit this data?')" disabled>
                                        Submit
                                    </button>
                                @else
                                    <a href="{{ route('member.order.index') }}" type="button"
                                        class="px-4 py-2 text-left text-white text-center rounded-xl bg-serv-email-override width-84 inline-block text-sm mr-2">
                                        Back
                                    </a>
                                    <button type="submit"
                                        class="px-4 py-2 text-left text-white text-center rounded-xl bg-grey-out width-84 inline-block text-sm"
                                        disabled>
                                        Submit
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </section>
    </main>
@endsection

@push('after-script')
    <script>
        function fileChosen() {
            document.getElementById("filename").innerHTML = document.getElementById("choose").files.item(0).name;
            document.getElementById("submitBtn").disabled = false;
            document.getElementById("submitBtn").classList.remove("bg-grey-out");
            document.getElementById("submitBtn").classList.add("bg-serv-button-override");
        }
    </script>
@endpush
