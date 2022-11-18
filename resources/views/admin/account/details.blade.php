@extends('admin.layouts.master')

@section('title', 'Account password change Page')


@section('content')

    <div class="main-content">
        <div class="row">
            <div class="col-4 offset-6 mb-2">
                @if (session('updateSuccess'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-xmark"></i> {{ session('updateSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="row">
                        <div class="col-3 offset-8">

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Info</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-1">
                                    @if (Auth::user()->image == null)
                                        @if (Auth::user()->gender == 'male')
                                            <img src="{{ asset('image/default_user.png') }}"
                                                class="img-thumbnail shadow-sm">
                                        @else
                                            <img src="{{ asset('image/female_default.jpg') }}"
                                                class="img-thumbnail shadow-sm">
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" />
                                    @endif
                                </div>
                                <div class="col-5 offset-1">
                                    <h4 class="my-3"><i class="fa-solid fa-user-pen me-2"></i> {{ Auth::user()->name }}
                                    </h4>
                                    <h4 class="my-3"><i
                                            class="fa-solid fa-envelope-circle-check me-2"></i>{{ Auth::user()->email }}
                                    </h4>
                                    <h4 class="my-3"><i
                                            class="fa-solid fa-mobile-screen-button me-3"></i>{{ Auth::user()->phone }}</h4>
                                    <h4 class="my-3"><i
                                            class="fa-solid fa-address-book me-3"></i>{{ Auth::user()->address }}
                                    </h4>
                                    <h4 class="my-3"><i class="fa-solid fa-venus-mars me-3"></i>{{ Auth::user()->gender }}
                                    </h4>
                                    <h4 class="my-3"><i
                                            class="fa-solid fa-user-clock me-3"></i>{{ Auth::user()->created_at->format('j-F-Y') }}
                                    </h4>
                                </div>
                                <div class="row">
                                    <div class="col-4 offset-2 mt-1">
                                        <a href="{{ route('admin#edit') }}">
                                            <button class="btn bg-dark text-white">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex flex-row-reverse mt-2">
                                    <div class="p-2">
                                        <a href="{{ route('category#list') }}">
                                            <button class="btn bg-dark text-white ">back</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
