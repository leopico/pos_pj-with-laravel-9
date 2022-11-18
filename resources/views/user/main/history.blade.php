@extends('user.layouts.master')

@section('content')
    <!-- Cart Start -->

    <div class="container-fluid" style="height: 600px">
        <div class="row mb-2">
            <div class="col-3 offset-7">
                <form action="{{ route('user#history') }}" method="get">
                    @csrf
                    <div class="d-flex">
                        <input class="form-control me-1" type="text" value="{{ request('key') }}"
                            placeholder="search for order id ..." name="key" id="">
                        <button class="btn btn-dark text-white" type="submit"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-8 offset-2 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order Id</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($order as $o)
                            <tr>
                                <td class="align-middle"> {{ $o->created_at }}</td>
                                <td class="align-middle"> {{ $o->order_code }}</td>
                                <td class="align-middle"> {{ $o->total_price }}</td>
                                <td class="align-middle">
                                    @if ($o->status == 0)
                                        <i class="fa-solid fa-user-clock me-2 text-warning"></i><span
                                            class="text-warning">Pending...</span>
                                    @elseif ($o->status == 1)
                                        <i class="fa-regular fa-circle-check me-2 text-success"></i><span
                                            class="text-success">Success...</span>
                                    @elseif ($o->status == 2)
                                        <i class="fa-solid fa-triangle-exclamation me-1 text-danger"></i><span
                                            class="text-danger">Rejected...</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-2">{{ $order->links() }}</div>
                <div class="d-flex flex-row-reverse mt-2">
                    <div class="p-2">
                        <a href="{{ route('user#home') }}">
                            <button class="btn bg-dark text-white ">back</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('jqueryScript')
    <script></script>
@endsection
