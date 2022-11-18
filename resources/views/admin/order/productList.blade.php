@extends('admin.layouts.master')

@section('title', 'Order List Page')


@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">

                    <div class="row col-7">
                        <div class="card">
                            <div class="card-body">
                                <h3><i class="fa-solid fa-clipboard me-1"></i>Order Info</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col"><i class="fa-regular fa-id-badge me-1"></i>Customer Name</div>
                                    <div class="col">- {{ $orderList[0]->user_name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col"><i class="fa-solid fa-barcode me-1"></i>Order Code</div>
                                    <div class="col">- {{ $orderList[0]->order_code }}</div>
                                </div>
                                <div class="row">
                                    <div class="col"><i class="fa-solid fa-calendar-days me-1"></i>Order Date</div>
                                    <div class="col">- {{ $orderList[0]->created_at->format('F-j-Y') }}</div>
                                </div>
                                <div class="row">
                                    <div class="col"><i class="fa-solid fa-sack-dollar me-1"></i>Total</div>
                                    <div class="col">- $ {{ $order->total_price }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DATA TABLE -->
                    {{-- @if (count($order) != 0) --}}
                    <div class="table-responsive table-responsive-data2">
                        <h5><a href="{{ route('order#list') }}" class="text-dark"><i
                                    class="fa-solid fa-left-long me-1"></i>back</a></h5>
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Order Id</th>
                                    <th>User Name</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Order Date</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderList as $o)
                                    <tr class="tr-shadow">
                                        <td></td>
                                        <td>{{ $o->id }}</td>
                                        <td class="col-2">{{ $o->user_name }}</td>
                                        <td class="col-2"><img src="{{ asset('storage/' . $o->product_img) }}"
                                                class="img-thumbnail shadow-sm">
                                        </td>
                                        <td>{{ $o->product_name }}</td>
                                        <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                        <td>{{ $o->qty }}</td>
                                        <td class="col-2">$ {{ $o->total }}</td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                @endforeach
                        </table>
                    </div>
                    {{-- @else
                        <h3 class="text-secondary text-center mt-5">There is no order Here!</h3>
                    @endif --}}
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
