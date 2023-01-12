@extends('layouts.app')

@section('title', ' Dashboard')

@section('content')

<main class="h-full overflow-y-auto">
    <div class="container mx-auto">
        <div class="grid w-full gap-5 px-10 mx-auto md:grid-cols-12">
            <div class="col-span-8">
                <h2 class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                    Overviews
                </h2>
                <p class="text-sm text-gray-400">
                    Monthly Reports
                </p>
            </div>
            <div class="col-span-4 text-right">
                <div @click.away="open = false" class="relative z-10 hidden mt-5 lg:block" x-data="{ open: false }">
                    <button class="flex flex-row items-center w-full px-4 py-2 mt-2 text-left bg-white rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4">

                    @if (auth()->user()->detail_user()->first()->photo != NULL)
                        <img class="inline w-12 h-12 mr-3 rounded-full" src="{{ url(Storage::url(auth()->user()->detail_user()->first()->photo)) }}" alt="photo profile">
                    @else
                        <svg class="inline w-12 h-12 mr-3 rounded-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    @endif

                        Halo, {{ Auth::user()->name }}

                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="container px-6 mx-auto mt-5">
        <div class="grid gap-5 md:grid-cols-12">
            <main class="p-4 lg:col-span-12 md:col-span-12 md:pt-0">
                <div class="sm:grid sm:h-32 sm:grid-flow-row sm:gap-4 sm:grid-cols-3">
                    <div class="flex flex-col justify-center px-4 py-4 mb-4 bg-white rounded-xl">
                        <div>
                            <div>
                                <img src="{{ asset('/assets/images/services-progress-icon.svg') }}" alt="" class="w-8 h-8">
                            </div>
                            <p class="mt-2 text-2xl font-semibold text-left text-gray-800">{{ $users }}</p>
                            <p class="text-sm text-left text-gray-500">
                                User Counts
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center px-4 py-4 mb-4 bg-white rounded-xl">
                        <div>
                            <div>
                                <img src="{{ asset('/assets/images/services-completed-icon.svg') }}" alt="" class="w-8 h-8">
                            </div>
                            <p class="mt-2 text-2xl font-semibold text-left text-gray-800">{{ $services->count() }}</p>
                            <p class="text-sm text-left text-gray-500">
                                Service Counts
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-6 mt-8 bg-white rounded-xl">
                    <div>
                        <h2 class="mb-1 text-xl font-semibold">
                            Recent Service
                        </h2>
                        <p class="text-sm text-gray-400">
                            {{ $progress ?? '' }} Total Orders On Progress
                        </p>
                    </div>
                    <table class="w-full mt-4" aria-label="Table">
                        <thead>
                            <tr class="text-sm font-normal text-left text-gray-900 border-b border-b-gray-600">
                                <th class="py-4" scope="">Service Name</th>
                                <th class="py-4" scope="">Services Price</th>
                                <th class="py-4" scope="">Freelancer Name</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($services as $item)
                                <tr class="text-gray-700">
                                    <td class="w-1/3 px-1 py-5">
                                        {{ $item->title }}
                                    </td>

                                    <td class="w-2/4 px-1 py-5">
                                        Rp {{ number_format($item->price) ?? '' }}
                                    </td>

                                    <td class="px-1 py-5">
                                        {{ $item->user->name }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </section>
</main>

@endsection
