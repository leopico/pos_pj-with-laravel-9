@extends('admin.layouts.master')

@section('title', 'Delivery create Page')


@section('content')

    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Create Your Delivery Way</h3>
                            </div>
                            <hr>
                            <form action="{{ route('delivery#create') }}" method="post" novalidate="novalidate">
                                @csrf
                                <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                <div class="form-group">
                                    <label class="control-label mb-1">Delivery Way</label>
                                    <input name="deliveryWay" type="text" value="{{ old('deliveryWay') }}"
                                        class="form-control @error('deliveryWay') is-invalid @enderror" aria-required="true"
                                        aria-invalid="false" placeholder="Create your delivery way...">
                                    @error('deliveryWay')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-1">Delivery Fee</label>
                                    <input name="deliveryFee" type="text" value="{{ old('deliveryFee') }}"
                                        class="form-control @error('deliveryFee') is-invalid @enderror" aria-required="true"
                                        aria-invalid="false" placeholder="Create your delivery fee...">
                                    @error('deliveryFee')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <span id="payment-button-amount">Create</span>
                                        {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                        <i class="fa-solid fa-circle-right"></i>
                                    </button>
                                </div>
                            </form>
                            <div class="d-flex flex-row-reverse mt-2">
                                <div class="p-2">
                                    <a href="{{ route('category#list') }}">
                                        <button class="btn bg-dark text-white ">back</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
