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
                <div class="col-lg-12 offset-0">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <button class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></button>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Your Pizza Details</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-2">
                                    <img class="img-thumbnail img-responsive shadow-sm" style="user-select: none"
                                        src="{{ asset('storage/' . $pizza->image) }}" />
                                </div>
                                <div class="col-10">
                                    <div class="my-1 btn btn-danger d-block w-50 fs-8">
                                        {{ $pizza->name }}
                                    </div>
                                    <span class="my-3 btn btn-dark text-white"><i
                                            class="fa-solid fa-money-bill-1-wave me-2"></i>{{ $pizza->price }}
                                        $
                                    </span>
                                    <span class="my-3 btn btn-dark text-white "><i
                                            class="fa-solid fa-user-clock me-2"></i>{{ $pizza->waiting_time }} mins
                                    </span>
                                    <span class="my-3 btn btn-dark text-white"><i
                                            class="fa-regular fa-eye me-2"></i>{{ $pizza->view_count }}
                                    </span>
                                    <span class="my-3 btn btn-dark text-white"><i
                                            class="fa-solid fa-clone me-2"></i>{{ $pizza->category_name }}
                                    </span>
                                    <span class="my-3 btn btn-dark text-white"><i
                                            class="fa-regular fa-calendar-plus me-2"></i>{{ $pizza->created_at->format('j-F-Y') }}
                                    </span>
                                    <h4 class="my-2"><i class="fa-solid fa-clipboard "></i>
                                        <span class="text-decoration-underline"> Details</span>
                                    </h4>
                                    <div class=" text-justify">{{ $pizza->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
