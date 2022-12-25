@extends('layouts.app')

@section('title', ' Service Details')

@push('polymer')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/polymer.css') }}">
@endpush

@section('content')
    <main class="h-full overflow-y-auto">
        <div class="container mx-auto">
            <div class="grid w-full mt-8 gap-5 px-10 mx-auto md:grid-cols-12">
                <div class="col-span-8">
                    <h2 class="mb-1 text-2xl font-semibold text-gray-700">Service Details</h2>
                    <!-- breadcrumb -->
                    <nav class="mt-2.5 text-sm" aria-label="Breadcrumb">
                        <ol class="inline-flex p-0 list-none">
                            <li class="flex items-center">
                                <a href="{{ route('member.service.index') }}" class="text-gray-400">My Services</a>
                                <svg class="w-3 h-3 mx-3 text-gray-400 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512">
                                    <path
                                        d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                                </svg>
                            </li>
                            <li class="flex items-center">
                                <p class="font-medium">{{ $order->service->title }}</p>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-span-4 lg:text-right">
                    <div class="relative">
                        <button class="px-4 py-2 mt-2 text-left text-white bg-red-400 rounded-xl">
                            Delete Service
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <section class="container px-6 mx-auto mt-5">
            <div class="grid gap-5 md:grid-cols-12">
                <main class="col-span-12 p-4 md:pt-0">
                    <div class="bg-white rounded-xl">
                        <section class="pt-6 pb-20 mx-8 w-auth">
                            <div class="grid gap-5 md:grid-cols-12">
                                <main class="p-4 lg:col-span-7 md:col-span-12">
                                    <span
                                        class="inline-flex items-center justify-center px-3 py-2 mb-4 mr-2 text-xs leading-none text-green-500 rounded-full bg-serv-green-badge">Active</span>
                                    <!-- details heading -->
                                    <div class="details-heading">
                                        <h1 class="text-2xl font-semibold">{{ $order->service->title ?? '' }}</h1>
                                        <div class="my-3 flex-vcenter">
                                            {{-- @include('component.dashboard.rating') --}}
                                            <?php
                                            $avg_rating = 0;
                                            ?>
                                            @if (count($reviews) > 0)
                                                @foreach ($reviews as $review)
                                                    @if ($review->order->service->id == $order->service->id)
                                                        <?php
                                                        $avg_rating += $review->rating;
                                                        ?>
                                                    @endif
                                                @endforeach
                                                <?php
                                                $avg_rating /= count($reviews);
                                                ?>
                                            @endif
                                            <svg class="inline-block align-sub" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.04894 0.927052C9.3483 0.00574112 10.6517 0.00573993 10.9511 0.927051L12.4697 5.60081C12.6035 6.01284 12.9875 6.2918 13.4207 6.2918H18.335C19.3037 6.2918 19.7065 7.53141 18.9228 8.10081L14.947 10.9894C14.5966 11.244 14.4499 11.6954 14.5838 12.1074L16.1024 16.7812C16.4017 17.7025 15.3472 18.4686 14.5635 17.8992L10.5878 15.0106C10.2373 14.756 9.7627 14.756 9.41221 15.0106L5.43648 17.8992C4.65276 18.4686 3.59828 17.7025 3.89763 16.7812L5.41623 12.1074C5.55011 11.6954 5.40345 11.244 5.05296 10.9894L1.07722 8.10081C0.293507 7.53141 0.696283 6.2918 1.66501 6.2918H6.57929C7.01252 6.2918 7.39647 6.01284 7.53035 5.60081L9.04894 0.927052Z"
                                                    fill="#FFBF47" />
                                            </svg>
                                            <span class="ml-2">
                                                @if ($avg_rating == 0 ||
                                                    $avg_rating == 1 ||
                                                    $avg_rating == 2 ||
                                                    $avg_rating == 3 ||
                                                    $avg_rating == 4 ||
                                                    $avg_rating == 5)
                                                    {{ $avg_rating . '.0' ?? '0.0' }}
                                                @else
                                                    {{ number_format((float) $avg_rating, 1, '.', '') ?? '0.0' }}
                                                @endif
                                            </span>
                                            <span class="text-gray-400">
                                                &nbsp;| {{ count($reviews) . ' Penilaian' }}
                                            </span>
                                        </div>
                                    </div>
                                    @if (count($thumbnail) > 0)
                                        <div class="p-3 my-4 bg-gray-100 rounded-lg image-gallery" x-data="gallery({{ '"' . url(Storage::url($thumbnail[0]->thumbnail)) . '"' }})">
                                        @else
                                            <div class="p-3 my-4 bg-gray-100 rounded-lg image-gallery"
                                                x-data="gallery()">
                                    @endif
                                    <img :src="featured" alt="" class="rounded-lg cursor-pointer w-full"
                                        data-lity>
                                    <div class="flex overflow-x-scroll hide-scroll-bar dragscroll">
                                        <div class="flex mt-2 flex-nowrap">
                                            <?php
                                            $counter = 0;
                                            $cap = count($thumbnail);
                                            ?>
                                            @forelse ($thumbnail as $item)
                                                <div class="@if ($counter < $cap - 1) mr-2 @endif flex-vcenter"
                                                    style="max-width: 100%; height: auto;">
                                                    <img :class="{
                                                        'border-4 border-serv-button': active ===
                                                            {{ $item->id }}
                                                    }"
                                                        @click="changeThumbnail('{{ url(Storage::url($item->thumbnail)) }}', {{ $item->id }})"
                                                        src="{{ url(Storage::url($item->thumbnail)) }}"
                                                        alt="thumbnail service"
                                                        class="inline-block w-24 rounded-lg cursor-pointer">
                                                </div>
                                                <?php
                                                ++$counter;
                                                ?>
                                            @empty
                                                {{-- empty --}}
                                            @endforelse
                                        </div>
                                    </div>
                            </div>
                </main>
                <aside class="p-4 lg:col-span-5 md:col-span-12 md:pt-0">
                    <div class="mb-4 border rounded-lg border-serv-testimonial-border">
                        <div
                            class="flex items-center px-2 py-3 mx-4 mt-4 border rounded-full border-serv-testimonial-border">
                            <div class="flex-1 text-sm font-medium text-center">
                                <svg class="inline" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="8" stroke="#082431"
                                        stroke-width="1.5" />
                                    <path d="M12 7V12L15 13.5" stroke="#082431" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                {{ $order->service->delivery_time ?? '' }} Days Delivery
                            </div>
                            <div class="flex-1 text-sm font-medium text-center">
                                <svg class="inline" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" fill="white" />
                                    <path d="M19 13C19 15 19 18.5 14.6552 18.5C9.63448 18.5 6.12644 18.5 5 18.5"
                                        stroke="#082431" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M4 11.5C4 9.5 4 6 8.34483 6C13.2455 6 16.8724 6 18 6" stroke="#082431"
                                        stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M7 21.5L4.14142 18.6414C4.06332 18.5633 4.06332 18.4247 4.14142 18.3586L7 15.5"
                                        stroke="#082431" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M16 3L18.8586 5.85858C18.9247 5.92468 18.9247 6.06332 18.8586 6.14142L16 9"
                                        stroke="#082431" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                {{ $order->service->revision_limit ?? '' }} Revision Limit
                            </div>
                        </div>
                        <div class="px-4 pt-4 pb-2 features-list">
                            <ul class="mb-4 text-sm list-check">
                                <li class="pl-10 my-4">3 Pages</li>
                                <li class="pl-10 my-4">Customized Design</li>
                                <li class="pl-10 my-4">Responsive Design</li>
                                <li class="pl-10 my-4">3 Plugins/Extensions</li>
                                <li class="pl-10 my-4">E-Commerce Functionality</li>
                            </ul>
                        </div>
                        <div class="px-4">
                            <table class="w-full mb-4">
                                <tr>
                                    <td class="text-sm leading-7 text-serv-text">
                                        Price starts from:
                                    </td>
                                    <td class="mb-4 text-xl font-semibold text-right text-serv-button">
                                        {{ 'Rp ' . number_format($order->service->price) ?? '' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="content">
                        <div>
                            <!-- The tabs content -->
                            <div class="leading-8 text-md">
                                <h2 class="text-xl font-semibold">About This <span
                                        class="text-serv-button">Services</span></h2>
                                <div class="mt-4 mb-8 content-description">
                                    <p>
                                        {{ $order->service->description ?? '' }}
                                    </p>
                                </div>
                                <h3 class="my-4 text-lg font-semibold">Why choose my Service?</h3>
                                <ul class="mb-4 list-check">
                                    @forelse ($advantage_service as $advantage_service_item)
                                        <li class="pl-10 my-2">
                                            {{ $advantage_service_item->advantage ?? '' }}</li>
                                    @empty
                                        {{-- empty --}}
                                    @endforelse
                                </ul>
                                <p class="mb-4">
                                    {{ $service->note ?? '' }}
                                </p>
                                <p class="mb-4 font-medium">
                                    Contact me to get started!
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="p-4 lg:col-span-6 md:col-span-12">
                    <button type="submit"
                        class="inline-flex justify-center px-3 py-2 mb-2 text-xs font-medium text-gray-700 bg-gray-100 border border-transparent rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Programming & Tech
                    </button>
                    <button type="submit"
                        class="inline-flex justify-center px-3 py-2 mb-2 text-xs font-medium text-gray-700 bg-gray-100 border border-transparent rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Website Developer
                    </button>
                </div>
                <div class="p-4 md:text-right lg:col-span-6 md:col-span-12">
                    <a href="{{ route('member.service.edit', $order->service_id) }}"
                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-lg shadow-sm bg-serv-email hover:bg-serv-email-text focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-serv-email">
                        Edit Service
                    </a>
                </div>
            </div>
        </section>
        </div>
    </main>
    </div>
    </section>
    </main>
@endsection

@push('after-script')
    <script>
        function gallery(source = "https://source.unsplash.com/_SgRNwAVNKw/1600x900/") {
            console.log(source);
            return {
                featured: source,
                active: 1,
                changeThumbnail: function(url, position) {
                    this.featured = url;
                    this.active = position;
                }
            }
        }
    </script>
@endpush
