@extends('admin.layouts.master')

@section('title', 'Account password change Page')


@section('content')

    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Admin Profile</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#update', Auth::user()->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        @if (Auth::user()->image == null)
                                            @if (Auth::user()->gender == 'male')
                                                <img src="{{ asset('image/default_user.png') }}"
                                                    class="img-rounded shadow-sm">
                                            @else
                                                <img src="{{ asset('image/female_default.jpg') }}"
                                                    class="img-rounded shadow-sm">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                                class="img-rounded shadow-sm" />
                                        @endif
                                        <div class="mt-3">
                                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                                name="image">
                                            @error('image')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label mb-1">Name</label>
                                            <input name="name" value="{{ old('name', Auth::user()->name) }}"
                                                type="text" class="form-control @error('name') is-invalid @enderror "
                                                aria-required="true" aria-invalid="false" placeholder="Enter admin name">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label mb-1">Email</label>
                                            <input name="email" value="{{ old('email', Auth::user()->email) }}"
                                                type="email" class="form-control @error('email') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter admin email">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label mb-1">Phone</label>
                                            <input name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                                type="phone" class="form-control @error('phone') is-invalid @enderror "
                                                aria-required="true" aria-invalid="false" placeholder="Enter admin phone">
                                            @error('phone')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label mb-1">Gender</label>
                                            <select name="gender"
                                                class="form-control @error('gender') is-invalid @enderror">
                                                <option value="">Choose Gender</option>
                                                <option value="male" @if (Auth::user()->gender == 'male') selected @endif>
                                                    Male
                                                </option>
                                                <option value="female" @if (Auth::user()->gender == 'female') selected @endif>
                                                    Female
                                                </option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Address</label>
                                            <textarea name="address" type="text" class="form-control @error('address') is-invalid @enderror" cols="30"
                                                rows="10" placeholder="Enter Admin address">{{ old('address', Auth::user()->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label mb-1">Role</label>
                                            <input name="role" value="{{ old('role', Auth::user()->role) }}"
                                                type="text" class="form-control" aria-required="true"
                                                aria-invalid="false" disabled>
                                        </div>

                                        <div class="form-group col-6 float-end">
                                            <button type="submit" class="btn btn-dark text-white col-12">
                                                <i class="fa-solid fa-cloud-arrow-up me-1"></i>Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex flex-row-reverse mt-2">
                            <div class="p-2">
                                <a href="{{ route('admin#details') }}">
                                    <button class="btn bg-dark text-white ">back</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
