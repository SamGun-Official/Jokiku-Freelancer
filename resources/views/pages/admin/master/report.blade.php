@extends('layouts.app')

@section('title', ' Master Users')

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container mx-auto">
        <div class="grid w-full gap-5 px-10 mx-auto md:grid-cols-12">
            <div class="col-span-8">
                <h2 class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                    Report
                </h2>
                <p class="text-sm text-gray-400">
                    {{ auth()->user()->service()->count() }} Total Transaction
                </p>
            </div>
            <div class="col-span-4 lg:text-right">
                <div class="relative mt-0 md:mt-6">
                    {{-- <a href="{{ route('member.service.create') }}" class="inline-block px-4 py-2 mt-2 text-left text-white rounded-xl bg-serv-button">
                        Filter
                    </a> --}}
                    <a href="{{ route('admin.downloadReport') }}" class="inline-block px-4 py-2 mt-2 text-left text-white rounded-xl bg-serv-button">
                        Download Report
                    </a>
                </div>
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
                                <th class="py-4" scope="">Service Name</th>
                                <th class="py-4" scope="">Buyer Name</th>
                                <th class="py-4" scope="">Freelancer Name</th>
                                <th class="py-4" scope="">Price</th>
                                <th class="py-4" scope="">Deadline</th>
                                <th class="py-4" scope="">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse ($orders as $key => $item)
                                <tr class="text-gray-700 border-b">
                                    <td class="px-1 py-5 text-sm">
                                        {{ $item->service()->first()->title }}
                                    </td>
                                    <td class="w-2/6 px-1 py-5">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-10 h-10 mr-3 rounded-full md:block">
                                                @if ($item->user_buyer()->first()->detail_user()->first()->photo != NULL)
                                                    <img class="object-cover w-full h-full rounded" src="{{ url(Storage::url($item->user_buyer()->first()->detail_user()->first()->photo)) }}" alt="thumbnail" loading="lazy">
                                                @else
                                                    <svg class="object-cover w-full h-full rounded text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                @endif

                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                {{ $item->user_buyer()->first()->name ?? '' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="w-2/6 px-1 py-5">
                                        <div class="flex items-center text-sm">
                                            <div class="relative w-10 h-10 mr-3 rounded-full md:block">
                                                @if ($item->user_freelancer()->first()->detail_user()->first()->photo != NULL)
                                                    <img class="object-cover w-full h-full rounded" src="{{ url(Storage::url($item->user_freelancer()->first()->detail_user()->first()->photo)) }}" alt="thumbnail" loading="lazy">
                                                @else
                                                    <svg class="object-cover w-full h-full rounded text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                @endif

                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                {{ $item->user_freelancer()->first()->name ?? '' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-1 py-5 text-sm">
                                        Rp {{ number_format($item->service()->first()->price) ?? '' }}
                                    </td>
                                    <td class="px-1 py-5 text-sm">
                                        {{ $item->expired }}
                                    </td>
                                    <td class="px-1 py-5 text-sm">
                                        {{ $item->order_status()->first()->name }}
                                    </td>
                                </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </section>
</main>

@endsection
