@extends('admin.layouts.master')

@section('title', 'Order List Page')


@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order Lists</h2>
                            </div>
                        </div>
                    </div>
                    {{-- for search category --}}
                    <div class="row mb-4">
                        <div class="col-3">
                            <h5 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span>
                            </h5>
                        </div>
                        <div class="col-4 offset-5">
                            <form action="{{ route('order#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input class="form-control" type="text" value="{{ request('key') }}"
                                        placeholder="search with username..." name="key" id="">
                                    <button class="btn btn-dark text-white" type="submit"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- end search categories --}}

                    <!-- DATA TABLE -->
                    {{-- search start --}}
                    <form action="{{ route('order#changeStatus') }}" method="get" class='col-8'>
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-append pb-2">
                                <span class="input-group-text me-3">
                                    <h4><i class="fa-solid fa-database mr-2"></i>{{ count($order) }}</h4>
                                </span>
                            </div>
                            <select name="orderStatus" class="custom-select">
                                <option value="">All</option>
                                <option value="0" @if (request('orderStatus') == '0') selected @endif>Pending</option>
                                <option value="1" @if (request('orderStatus') == '1') selected @endif>Accept</option>
                                <option value="2" @if (request('orderStatus') == '2') selected @endif>Rejected</option>
                            </select>
                            <div class="input-group-append"><button type="submit"
                                    class="btn btn-sm btn-dark input-group-text mb-2"><i
                                        class="fa-solid fa-magnifying-glass mr-2"></i>Search with status</button>
                            </div>
                        </div>
                    </form>
                    {{-- search end --}}

                    @if (count($order) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>User Id</th>
                                        <th>User Name</th>
                                        <th>Order Date</th>
                                        <th>Order Code</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order as $o)
                                        <tr class="tr-shadow">
                                            <input type="hidden" name="" value="{{ $o->id }}" id="orderId">
                                            <td>{{ $o->user_id }}</td>
                                            <td>{{ $o->user_name }}</td>
                                            <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                            <td><a
                                                    href="{{ route('order#listInfo', $o->order_code) }}">{{ $o->order_code }}</a>
                                            </td>
                                            <td>$ {{ $o->total_price }}</td>
                                            <td>
                                                <select name="status" class="form-control statusChange">
                                                    <option value="0"
                                                        @if ($o->status == 0) selected @endif>
                                                        Pending</option>
                                                    <option value="1"
                                                        @if ($o->status == 1) selected @endif>
                                                        Accept</option>
                                                    <option value="2"
                                                        @if ($o->status == 2) selected @endif>
                                                        Reject</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                            </table>
                        </div>
                    @else
                        <h3 class="text-secondary text-center mt-5">There is no order Here!</h3>
                    @endif
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')
    <script>
        $(document).ready(function() {
            // this is for searching with ajax method
            // $('#orderStatus').change(function() {
            //     $status = $('#orderStatus').val();
            //     // console.log($status);
            //     $.ajax({
            //         type: 'get',
            //         url: 'http://127.0.0.1:8000/order/ajax/status',
            //         data: {
            //             'status': $status,
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             // console.log(response);

            //             $list = '';
            //             for ($i = 0; $i < response.length; $i++) {


            //                 $months = ['January', 'February', 'March', 'April', 'May', 'June',
            //                     'July', 'August', 'September', 'October', 'November',
            //                     'December'
            //                 ]
            //                 // console.log(response[$i].created_at);
            //                 // console.log($dbDate.getFullYear());
            //                 $dbDate = new Date(response[$i].created_at);
            //                 // console.log($dbDate);
            //                 // console.log($months[$dbDate.getMonth()] + '-' + $dbDate.getDate() +
            //                 //     '-' + $dbDate.getFullYear());
            //                 $finalDate = $months[$dbDate.getMonth()] + '-' + $dbDate.getDate() +
            //                     '-' + $dbDate.getFullYear();

            //                 if (response[$i].status == 0) {
            //                     $statusMessage = `<select name="" class="form-control statusChange">
        //                     <option value="0" selected >Pending</option>
        //                     <option value="1">Accept</option>
        //                     <option value="2">Reject</option>
        //                 </select>`
            //                 } else if (response[$i].status == 1) {
            //                     $statusMessage = `<select name="" class="form-control statusChange">
        //                     <option value="0" >Pending</option>
        //                     <option value="1" selected>Accept</option>
        //                     <option value="2">Reject</option>
        //                 </select>`
            //                 } else if (response[$i].status == 2) {
            //                     $statusMessage = `<select name="" class="form-control statusChange">
        //                     <option value="0" >Pending</option>
        //                     <option value="1">Accept</option>
        //                     <option value="2" selected>Reject</option>
        //                 </select>`
            //                 }

            //                 $list += `<tr>
        //             <input type="hidden" name="" value="${response[$i].id}" id="orderId">
        //             <td>${response[$i].user_id}</td>
        //             <td>${response[$i].user_name}</td>
        //             <td> ${$finalDate} </td>
        //             <td>${response[$i].order_code}</td>
        //             <td>${response[$i].total_price}</td>
        //             <td>${$statusMessage}</td>
        //             </tr>
        //             <tr class="spacer"></tr>`;
            //             }
            //             // console.log(response);
            //             // console.log($list);
            //             $('#dataList').html($list);
            //         }

            //     })
            // })

            $('.statusChange').change(function() {
                $currentStatus = $(this).val();
                $parentNode = $(this).parents('tr');
                $orderId = $parentNode.find('#orderId').val()
                // console.log($orderId);
                $data = {
                    'status': $currentStatus,
                    'orderId': $orderId
                }
                $.ajax({
                    type: 'get',
                    url: '/order/ajax/change/status',
                    data: $data,
                    dataType: 'json',
                });
                location.reload();
            })

        })
    </script>
@endsection
