@extends('user.layouts.master')

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="position-relative text-uppercase mb-3">
                    <div class="text-center">Filter
                        by categories</div>
                </h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class=" d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-3 py-1">
                            {{-- <input type="" class="-input" checked id="price-all"> --}}
                            <label class="mt-2 px-2" for="price-all">Categories</label>
                            <span class="badge border font-weight-normal">{{ count($category) }}</span>
                        </div>
                        <div class=" d-flex align-items-center justify-content-between mb-3 pt-1">
                            <a href="{{ route('user#home') }}" class="text-dark"><label class=""
                                    for="price-1">All</label></a>
                        </div>
                        @foreach ($category as $c)
                            <div class=" d-flex align-items-center justify-content-between mb-3 pt-1">
                                <a href="{{ route('user#filter', $c->id) }}" class="text-dark"><label class=""
                                        for="price-1">{{ $c->name }}</label></a>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->
                <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>

            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="">
                                <a class="btn btn-outline-dark btn-square position-relative me-3" title="Total cart"
                                    href="{{ route('user#cartList') }}"><i class="fa-solid fa-cart-arrow-down"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ count($cart) }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </a>
                                <a class="btn btn-outline-dark btn-square position-relative me-3" title="history"
                                    href="{{ route('user#history') }}"><i class="fa-solid fa-clock-rotate-left"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ count($history) }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </a>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <select name="" class="form-control" id="sortingOption">
                                        <option value="">Choose one option</option>
                                        <option value="asc">from lastest product to new product</option>
                                        <option value="desc">from new product to lastest product</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="row" id="myForm">
                        @if (count($pizza) != 0)
                            @foreach ($pizza as $p)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style="height: 200px"
                                                src="{{ asset('storage/' . $p->image) }}" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square"
                                                    href="{{ route('user#pizzaDetails', $p->id) }}"><i
                                                        class="fa-solid fa-circle-info" title="order & detail"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate"
                                                href="">{{ $p->name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ $p->price }} $</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="fs-1 p-3 mt-5 text-center shadow-sm"><i class="fa-solid fa-pizza-slice"></i> There is
                                no
                                pizza!</p>
                        @endif
                    </span>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@section('jqueryScript')
    <script>
        $(document).ready(function() {
            // $.ajax({
            //     type: 'get',
            //     url: 'http://127.0.0.1:8000/user/ajax/pizza/list',
            //     dataType: 'json',
            //     success: function(response) {
            //         console.log(response);
            //     }
            // })
            $('#sortingOption').change(function() {
                $eventOption = $('#sortingOption').val();
                // console.log($eventOption);
                if ($eventOption == 'asc') {
                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/pizza/list',
                        data: {
                            'status': 'asc' //this is for controller that puting data
                        },
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response[0].name);
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                $list += `<div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" style="height: 200px"
                                        src="{{ asset('storage/${response[$i].image}') }}" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i
                                                class="fa-solid fa-cart-arrow-down"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i
                                                class="fa-solid fa-circle-info"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate"
                                        href="">${response[$i].name}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>${response[$i].price}$</h5>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                            }
                            // console.log($list);
                            $('#myForm').html($list);
                        },
                    })
                } else if ($eventOption == 'desc') {
                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/pizza/list',
                        data: {
                            'status': 'desc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response[0].name);
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                $list += `<div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" style="height: 180px"
                                        src="{{ asset('storage/${response[$i].image}') }}" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i
                                                class="fa-solid fa-cart-arrow-down"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i
                                                class="fa-solid fa-circle-info"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate"
                                        href="">${response[$i].name}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>${response[$i].price}$</h5>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                            }
                            // console.log($list);
                            $('#myForm').html($list);
                        },
                    })
                }
            });
        });
    </script>
@endsection
