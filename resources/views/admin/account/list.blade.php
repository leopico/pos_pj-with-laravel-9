@extends('admin.layouts.master')

@section('title', 'Category List Page')


@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Admins List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="#">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Admin
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>
                    {{-- alert for delete --}}

                    {{-- for search category --}}
                    <div class="row">
                        <div class="col-3">
                            <h5 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span>
                            </h5>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('admin#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input class="form-control" type="text" value="{{ request('key') }}"
                                        placeholder="search..." name="key">
                                    <button class="btn btn-dark text-white" type="submit"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- end for search category --}}
                    <div class="row">
                        <div class="col-1 offset-10 bg-white btn btn-white shadow-sm py-2 mt-2">
                            <h4><i class="fa-solid fa-database mr-2"></i>{{ $admin->total() }}</h4>
                        </div>
                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-5 offset-4 mt-2">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    {{-- end for alert delete --}}
                    <div class="row table-responsive table-responsive-data2">
                        {{-- @if (count($categories) != 0) --}}
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admin as $a)
                                    <tr class="tr-shadow">
                                        <td class="col-2">
                                            @if ($a->image == null)
                                                @if ($a->gender == 'male')
                                                    <img src="{{ asset('image/default_user.png') }}"
                                                        class="img-thumbnail shadow-sm">
                                                @else
                                                    <img src="{{ asset('image/female_default.jpg') }}"
                                                        class="img-thumbnail shadow-sm">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $a->image) }}"
                                                    class="img-thumbnail shadow-sm">
                                            @endif
                                        </td>
                                        <td>{{ $a->name }}</td>
                                        <td>{{ $a->email }}</td>
                                        <td>{{ $a->gender }}</td>
                                        <td>{{ $a->phone }}</td>
                                        <td>{{ $a->address }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                @if (Auth::user()->id == $a->id)
                                                @else
                                                    <a href="{{ route('admin#changeRole', $a->id) }}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                            title="Change role">
                                                            <i class="fa-solid fa-person-circle-minus"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('admin#delete', $a->id) }}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- for pagination --}}
                        <div class="">
                            {{ $admin->appends(request()->query())->links() }}
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>


    <!-- END MAIN CONTENT-->
@endsection
