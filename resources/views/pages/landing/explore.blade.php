@extends('layouts.front')

@section('title', ' Explore')

@push('polymer')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/polymer.css') }}">
@endpush

@section('content')
    <!-- content -->
    <div class="content flex-grow">
        <!-- services -->
        <div class="bg-serv-bg-explore overflow-hidden">
            <div class="pt-16 pb-16 lg:pb-20 lg:px-24 md:px-16 sm:px-8 px-8 mx-auto">
                <div class="text-center">
                    <h1 class="text-3xl font-semibold mb-1">Service Overviews</h1>
                    <p class="leading-8 text-serv-text mb-10">Discover the world's top Freelancers</p>
                </div>
                @if (count($services) == 0)
                    <div class="text-center mt-10">
                        @guest
                            <p class="text-xl mb-1">Currently we have no service available for you! But you can start your own
                                services here in Jokiku Freelancer!</p>
                        @endguest
                        @auth
                            @if (auth()->user()->role == 'user')
                                <p class="text-xl mb-1">Currently we have no service available for you! But you can start your
                                    own services here in Jokiku Freelancer!</p>
                            @else
                                <p class="text-xl mb-1">Currently no service is available at this moment!</p>
                            @endif
                        @endauth
                        <div class="text-center mt-10">
                            @guest
                                <div class="hidden lg:flex lg:items-center lg:justify-center lg:w-auto w-full" id="menu">
                                    <button onclick="toggleModal('loginModal')"
                                        class="bg-serv-services-darker-bg text-serv-login-text items-center border-0 block lg:inline-block  lg:py-3 lg:px-10 focus:outline-none rounded-2xl font-medium text-base mt-6 lg:mt-0">
                                        Create New Service
                                    </button>
                                </div>
                            @endguest
                            @auth
                                @if (auth()->user()->role == 'user')
                                    <a class="bg-serv-explore-button text-serv-bg block sm:inline-block my-2 py-2 px-8 mx-4 font-medium rounded-xl"
                                        href="{{ url('/member/service') }}">
                                        Create New Service
                                    </a>
                                @else
                                    <a class="bg-serv-explore-button text-serv-bg block sm:inline-block my-2 py-2 px-8 mx-4 font-medium rounded-xl"
                                        href="{{ url('/admin/service') }}">
                                        Approve Services
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                @else
                    {{-- <nav class="my-8 text-center" aria-label="navigation">
                        <a class="bg-serv-bg text-white block sm:inline-block my-2 py-2 px-8 mx-4 font-medium rounded-xl"
                            href="#">
                            All Services
                        </a>
                        <a class="bg-serv-explore-button text-serv-bg block sm:inline-block my-2 py-2 px-8 mx-4 font-medium rounded-xl"
                            href="#">
                            Programming & Tech
                        </a>
                        <a class="bg-serv-explore-button text-serv-bg block sm:inline-block my-2 py-2 px-8 mx-4 font-medium rounded-xl"
                            href="#">
                            Graphic Design
                        </a>
                        <a class="bg-serv-explore-button text-serv-bg block sm:inline-block my-2 py-2 px-8 mx-4 font-medium rounded-xl"
                            href="#">
                            Digital Marketing
                        </a>
                        <a class="bg-serv-explore-button text-serv-bg block sm:inline-block my-2 py-2 px-8 mx-4 font-medium rounded-xl"
                            href="#">
                            Business
                        </a>
                    </nav> --}}
                    <div class="grid grid-cols lg:grid-cols-3 md:grid-cols-2 gap-4">
                        @forelse ($services as $item)
                            @include('component.Landing.service-explorer')
                        @empty
                            {{-- empty --}}
                        @endforelse
                    </div>
                    <div class="text-center mt-10">
                        <a class="bg-serv-explore-button text-serv-bg block sm:inline-block my-2 py-2 px-8 mx-4 font-medium rounded-xl"
                            href="#">
                            Load More
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
