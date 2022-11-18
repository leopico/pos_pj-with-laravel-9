@extends('admin.layouts.master')

@section('title', 'Delivery List Page')


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
                                <h2 class="title-1">Delivery Route</h2>
                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('delivery#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Delivery Way
                                </button>
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    CSV download
                                </button>
                            </a>
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
                            <form action="{{ route('delivery#list') }}" method="get">
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
                            <h4><i class="fa-solid fa-database mr-2"></i></h4>
                        </div>
                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8 mt-2">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    {{-- end for alert delete --}}

                    <div class="table-responsive table-responsive-data2">
                        @if (count($deliveries) != 0)
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th class="col-6">delivery way</th>
                                        <th>delivery fee</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deliveries as $d)
                                        <tr class="tr-shadow">
                                            <td class="">{{ $d->id }}</td>
                                            <td class="col-6">
                                                <span class="block-email">{{ $d->deli_way }}</span>
                                            </td>
                                            <td class="">$ {{ $d->deli_fee }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="{{ route('delivery#edit', $d->id) }}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                            title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('delivery#delete', $d->id) }}">
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
                                </tbody>

                            </table>
                            {{-- for pagination --}}
                            <div class="">
                                {{ $deliveries->appends(request()->query())->links() }}
                            </div>
                        @else
                            <h3 class="text-secondary text-center mt-5">There is no Delivery Route Here!</h3>
                        @endif
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
