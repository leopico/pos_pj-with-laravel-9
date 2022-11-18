@extends('admin.layouts.master')

@section('title', 'Account password change Page')


@section('content')

    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <button class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></button>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Change Role</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#change', $account->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        @if ($account->image == null)
                                            @if ($account->gender == 'male')
                                                <img src="{{ asset('image/default_user.png') }}"
                                                    class="img-thumbnail shadow-sm" />
                                            @else
                                                <img src="{{ asset('image/female_default.jpg') }}"
                                                    class="img-thumbnail shadow-sm" />
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/' . $account->image) }}"
                                                class="img-thumbnail shadow-sm " />
                                        @endif
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-dark text-white col-12 mt-1">
                                                <i class="fa-solid fa-cloud-arrow-up me-1"></i>change
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label mb-1">Name</label>
                                            <input name="name" value="{{ old('name', $account->name) }}" type="text"
                                                class="form-control " aria-required="true" aria-invalid="false" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Role</label>
                                            <select name="role" class="form-control">
                                                <option value="admin" @if ($account->role == 'admin') selected @endif>
                                                    Admin</option>
                                                <option value="user" @if ($account->role == 'user') selected @endif>
                                                    User</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Email</label>
                                            <input name="email" value="{{ old('email', $account->email) }}" type="email"
                                                class="form-control " aria-required="true" aria-invalid="false" disabled>

                                        </div>


                                        <div class="form-group">
                                            <label class="control-label mb-1">Phone</label>
                                            <input name="phone" value="{{ old('phone', $account->phone) }}" type="phone"
                                                class="form-control" aria-required="true" aria-invalid="false" disabled>

                                        </div>


                                        <div class="form-group">
                                            <label class="control-label mb-1">Gender</label>
                                            <select name="gender" class="form-control" disabled>
                                                <option value="">Choose Gender</option>
                                                <option value="male" @if ($account->gender == 'male') selected @endif>
                                                    Male
                                                </option>
                                                <option value="female" @if ($account->gender == 'female') selected @endif>
                                                    Female
                                                </option>
                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Address</label>
                                            <textarea name="address" disabled type="text" class="form-control" cols="30" rows="10">{{ old('address', $account->address) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
