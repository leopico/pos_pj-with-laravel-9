@extends('admin.layouts.master')

@section('title', 'Delivery create Page')


@section('content')

    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <button class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></button>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Your Delivery Way</h3>
                            </div>
                            <hr>
                            <form action="{{ route('delivery#update') }}" method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="deliveryId" value="{{ $deliEdit->id }}">
                                    <label class="control-label mb-1">Delivery Way</label>
                                    <input id="cc-pament" name="deliveryWay" type="text"
                                        value="{{ old('deliveryWay', $deliEdit->deli_way) }}"
                                        class="form-control @error('deliveryWay') is-invalid @enderror" aria-required="true"
                                        aria-invalid="false" placeholder="Create your food name">
                                    @error('deliveryWay')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-1">Delivery Fee</label>
                                    <input id="cc-pament" name="deliveryFee" type="text"
                                        value="{{ old('deliveryFee', $deliEdit->deli_fee) }}"
                                        class="form-control @error('deliveryFee') is-invalid @enderror" aria-required="true"
                                        aria-invalid="false" placeholder="Create your food name">
                                    @error('deliveryFee')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        </i><span id="payment-button-amount">Update</span>
                                        {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                        <i class="fa-solid fa-circle-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
