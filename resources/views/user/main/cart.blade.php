@extends('user.layouts.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartList as $c)
                            <tr>
                                <td><img src="{{ asset('storage/' . $c->product_img) }}" class="img-thumbnail shadow-sm"
                                        style="width: 100px"></td>
                                <td class="align-middle">
                                    {{ $c->pizza_name }}
                                    <input type="hidden" value="{{ $c->product_id }}" class="productId">
                                    <input type="hidden" value="{{ $c->user_id }}" class="userId">
                                    <input type="hidden" value="{{ $c->id }}" class="orderId">
                                </td>
                                <td class="align-middle" id="price">$ {{ $c->pizza_price }}</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus text-white"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm  border-0 text-center"
                                            value="{{ $c->qty }}" id="qty">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle col-3" id="total">$ {{ $c->pizza_price * $c->qty }}</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotalPrice">$ {{ $totalPrice }}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium pt-1">Delivery</h6>
                            <select name="" id="location" class="mr-3">
                                <option>choose your location</option>
                                @foreach ($delivery as $d)
                                    <option value="{{ $d->id }}" id="deli">
                                        {{ $d->deli_way }}
                                    </option>
                                @endforeach
                            </select>
                            <h5 class="deliPrice"> $</h5>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">$ {{ $totalPrice }}</h5>
                        </div>
                        <button id="orderBtn" class="btn btn-block btn-primary font-weight-bold my-3 py-3 text-white"><span
                                class="text-white">Proceed To
                                Checkout</span></button>
                        <button id="clearBtn" class="btn btn-block btn-danger font-weight-bold my-3 py-3 text-white"><span
                                class="text-white">Clear Cart</span></button>
                    </div>
                    <button class="btn btn-dark">
                        <a href="{{ route('user#home') }}" class="text-decoration-none text-white"><i
                                class="fa-solid fa-arrow-left me-1"></i>back</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('jqueryScript')
    <script>
        //when plus button click
        $(document).ready(function() {
            $('.btn-plus').click(function() {
                $parentNode = $(this).parents('tr');
                $price = Number($parentNode.find('#price').text().replace('$', ''));
                $qty = Number($parentNode.find('#qty').val());
                $total = $price * $qty;
                $parentNode.find('#total').html('$' + ' ' + $total);
                summaryCalculation();
            })

            //when minus button click
            $('.btn-minus').click(function() {
                $parentNode = $(this).parents('tr');
                $price = Number($parentNode.find('#price').text().replace('$', ''));
                $qty = Number($parentNode.find('#qty').val());
                $total = $price * $qty;
                $parentNode.find('#total').html('$' + ' ' + $total);
                summaryCalculation();
            })

            //when cross button click
            $('.btnRemove').click(function() {
                $parentNode = $(this).parents('tr');
                $productId = $parentNode.find('.productId').val();
                $orderId = $parentNode.find('.orderId').val();
                // console.log($productId);
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/clear/current/product',
                    data: {
                        'productId': $productId,
                        'orderId': $orderId
                    },
                    dataType: 'json',
                });
                $parentNode.remove();
                summaryCalculation();
            })

            //calculate final price for order
            function summaryCalculation() {
                //summary
                $totalPrice = 0;
                $('#dataTable tbody tr').each(function(index, row) {
                    // console.log(row);
                    $totalPrice += Number($(row).find('#total').text().replace('$', ''));
                    // console.log($totalPrice);
                })
                $('#subTotalPrice').html(`${$totalPrice} $`);
                $('#finalPrice').html(`${$totalPrice} $ `);
            }

            //for delivery
            $('#location').change(function() {
                $deli_id = $(this).val();
                $deli = $(this).parents('div');
                $deliPrice = $deli.find('.deliPrice').val();
                // console.log($deliPrice);
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/location',
                    data: {
                        'id': $deli_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response[0].deli_fee);
                        $deli.find('.deliPrice').text('$' + ' ' + response[0].deli_fee);

                    }
                })
            })

            $('#orderBtn').click(function() {
                $orderList = [];
                $random = Math.floor(Math.random() * 10000000001)
                $('#dataTable tbody tr').each(function(index, row) {
                    $orderList.push({
                        'userId': $(row).find('.userId').val(),
                        'productId': $(row).find('.productId').val(),
                        'qty': $(row).find('#qty').val(),
                        'total': Number($(row).find('#total').text().replace('$', '')),
                        'order_code': 'POS' + $random,
                    });
                });
                // console.log($orderList);
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/order',
                    data: Object.assign({}, $orderList),
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 'true') {
                            window.location = "/user/homePage";
                        }
                    }
                });
            })
            // clear cart
            $('#clearBtn').click(function() {
                // console.log('clear');
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/clear/cart',
                    dataType: 'json',
                })
                $('#dataTable tbody tr').remove();
                $('#subTotalPrice').html('$ 0');
                $('#finalPrice').html('$ 0');
            })
        })
    </script>
@endsection
