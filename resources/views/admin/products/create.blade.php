@extends('admin.layouts.master')

@section('title', 'Category create Page')


@section('content')

    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Add Your Products</h3>
                            </div>
                            <hr>
                            <form action="{{ route('product#create') }}" enctype="multipart/form-data" method="post"
                                novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label mb-1">Name</label>
                                    <input name="pizzaName" type="text" value="{{ old('pizzaName') }}"
                                        class="form-control @error('pizzaName') is-invalid @enderror" aria-required="true"
                                        aria-invalid="false" placeholder="Enter pizza name...">
                                    @error('pizzaName')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">Category</label>
                                    <select name="pizzaCategory"
                                        class="form-control @error('pizzaCategory') is-invalid @enderror">
                                        <option value="">Choose Category</option>
                                        @foreach ($categories as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('pizzaCategory')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">Description</label>
                                    <textarea name="pizzaDescription" class="form-control @error('pizzaDescription') is-invalid @enderror"
                                        placeholder="Enter description..." cols="30" rows="10">{{ old('pizzaDescription') }}</textarea>
                                    @error('pizzaCategory')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">Image</label>
                                    <input name="pizzaImage" type="file" value="{{ old('pizzaImage') }}"
                                        class="form-control @error('pizzaImage') is-invalid @enderror" aria-required="true"
                                        aria-invalid="false">
                                    @error('pizzaImage')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">Waiting Time</label>
                                    <input name="pizzaWaitingTime"
                                        type="number"class="form-control @error('pizzaWaitingTime') is-invalid @enderror"
                                        aria-required="true" aria-invalid="false">
                                    @error('pizzaWaitingTime')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">Price</label>
                                    <input name="pizzaPrice" type="number" value="{{ old('pizzaPrice') }}"
                                        class="form-control @error('pizzaPrice') is-invalid @enderror" aria-required="true"
                                        aria-invalid="false" placeholder="Enter pizza price...">
                                    @error('pizzaPrice')
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
                                    <a href="{{ route('product#list') }}">
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
