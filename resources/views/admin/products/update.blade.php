@extends('admin.layouts.master')

@section('title', 'Account password change Page')


@section('content')

    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <d class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Update Pizza</h3>
                            </div>
                            <hr>
                            <form action="{{ route('product#update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        {{-- this is taking it --}}
                                        <input type="hidden" name="pizzaId" value="{{ $pizza->id }}">
                                        <img
                                            src="{{ asset('storage/' . $pizza->image) }}"class="img-thumbnail shadow-sm " />
                                        <div class="mt-3">
                                            <input type="file"
                                                class="form-control @error('pizzaImage') is-invalid @enderror"
                                                name="pizzaImage">
                                            @error('pizzaImage')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label mb-1">Name</label>
                                            <input name="pizzaName"
                                                value="{{ old('pizzaName', $pizza->name) }}"type="text"
                                                class="form-control @error('pizzaName') is-invalid @enderror "
                                                aria-required="true" aria-invalid="false" placeholder="Enter pizza name...">
                                            @error('pizzaName')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label mb-1">Description</label>
                                            <textarea name="pizzaDescription" class="form-control @error('pizzaDescription') is-invalid @enderror" cols="30"
                                                rows="10" placeholder="Enter description...">{{ old('pizzaDescription', $pizza->description) }}</textarea>
                                            @error('pizzaDescription')
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
                                                @foreach ($category as $c)
                                                    <option value="{{ $c->id }}"
                                                        @if ($pizza->category_id == $c->id) selected @endif>
                                                        {{ $c->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Price $</label>
                                            <input name="pizzaPrice" value="{{ old('description', $pizza->price) }}"
                                                type="pizzaPrice"
                                                class="form-control @error('pizzaPrice') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter price...">
                                            @error('pizzaPrice')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Waiting Time (mins)</label>
                                            <input name="pizzaWaitingTime"
                                                value="{{ old('pizzaWaitingTime', $pizza->waiting_time) }}" type="text"
                                                class="form-control @error('pizzaWaitingTime') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter waiting time">
                                            @error('pizzaWaitingTime')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">View Count</label>
                                            <input name="viewCount" value="{{ old('description', $pizza->view_count) }}"
                                                type="email" class="form-control" aria-required="true"
                                                aria-invalid="false" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Crated Date</label>
                                            <input name="created_at"
                                                value="{{ old('role', $pizza->created_at->format('j-F-Y')) }}"
                                                type="text" class="form-control" aria-required="true"
                                                aria-invalid="false" disabled>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row-reverse mt-2">
                                        <div class="p-2">
                                            <button type="submit" class="btn btn-dark text-white col-12">
                                                <i class="fa-solid fa-cloud-arrow-up me-1"></i>Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </d>
                    <div class="d-flex flex-row-reverse mt-2">
                        <div class="p-2">
                            <button class="btn bg-dark text-white" onclick="history.back()">back</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
