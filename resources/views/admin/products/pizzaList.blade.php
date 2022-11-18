@extends('admin.layouts.master')

@section('title', 'Product List Page')


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
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('product#create') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Products
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
                            <form action="{{ route('product#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input class="form-control" type="text" value="{{ request('key') }}"
                                        placeholder="search..." name="key" id="">
                                    <button class="btn btn-dark text-white" type="submit"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- end for search category --}}
                    <div class="row">
                        <div class="col-1 offset-10 bg-white btn btn-white shadow-sm py-2 mt-2">
                            <h4><i class="fa-solid fa-database mr-2"></i> {{ $pizzas->total() }}</h4>
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
                    @if (session('updateSuccess'))
                        <div class="col-5 offset-4 mt-2">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('updateSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    {{-- end for alert delete --}}

                    @if (count($pizzas) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price ($)</th>
                                        <th>Category</th>
                                        <th>Customer Views</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pizzas as $p)
                                        <tr class="tr-shadow">
                                            <td class="col-3"> <img src="{{ asset('storage/' . $p->image) }}"
                                                    class="img-rounded shadow-sm">
                                            </td>
                                            <td class="col-2">{{ $p->name }}</td>
                                            <td>$ {{ $p->price }}</td>
                                            <td class="col-2">{{ $p->category_name }}</td>
                                            <td><i class="fa-solid fa-eye me-2"></i>{{ $p->view_count }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="{{ route('product#edit', $p->id) }}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                            title="View">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('product#updatePage', $p->id) }}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                            title="update">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('product#delete', $p->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                            </table>
                            {{-- for pagination --}}
                            <div class="">
                                {{ $pizzas->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <h3 class="text-secondary text-center mt-5">There is no Pizzas Here!</h3>
                    @endif
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
