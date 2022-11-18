@extends('admin.layouts.master')

@section('title', 'Order List Page')


@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->

                    <h4>Total - {{ $users->total() }}</h4>

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $u)
                                    <tr>
                                        <td class="col-2">
                                            @if ($u->image == null)
                                                @if ($u->image == 'male')
                                                    <img src="{{ asset('image/default_user.png') }}"
                                                        class="img-thumbnail shadow-sm">
                                                @else
                                                    <img src="{{ asset('image/female_default.jpg') }}"
                                                        class="img-thumbnail shadow-sm">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $u->image) }}"
                                                    class="img-thumbnail shadow-sm" />
                                            @endif
                                        </td>
                                        <input type="hidden" id="userId" value="{{ $u->id }}">
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->gender }}</td>
                                        <td>{{ $u->phone }}</td>
                                        <td>{{ $u->address }}</td>
                                        <td class="col-3">
                                            <select class="form-control statusChange">
                                                <option value="user" @if ($u->role == 'user') selected @endif>
                                                    User
                                                </option>
                                                <option value="admin" @if ($u->role == 'admin') selected @endif>
                                                    Admin</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
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
            $('.statusChange').change(function() {
                $currentStatus = $(this).val();
                // console.log($currentStatus);
                $parentNode = $(this).parents('tr');
                $userId = $parentNode.find('#userId').val();
                // console.log($userId);
                $data = {
                    'role': $currentStatus,
                    'userId': $userId
                }
                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/user/change/role',
                    data: $data,
                    dataType: 'json',
                });
                location.reload();
            })

        })
    </script>
@endsection
