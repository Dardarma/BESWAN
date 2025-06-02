@extends('admin_page.layout')
@section('style')
@endsection
@section('content')

    <div class="fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h3 class="card-title">User Activity</h3>
                        <div class="card-tools d-flex align-items-center ml-auto">
                            <form method="GET" action="{{ url('/admin/master/daily_activity') }}"
                                class="d-flex align-items-center">
                                <div class="input-group input-group-sm" style="width: 80px; margin-right: 10px;">
                                    <select class="custom-select" name="paginate" onchange="this.form.submit()">
                                        <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                </div>

                                <div class="input-group input-group-sm" style="width: 150px; margin-right: 10px;">
                                    <input type="text" name="table_search" class="form-control" placeholder="Search"
                                        value="{{ request('table_search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Add Level Button -->
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add">Add
                                Feed</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @php
                            $chunks = $user->chunk(ceil($user->count() / 2));
                        @endphp

                        <!-- TABEL MOBILE (1 TABLE) -->
                        <div class="d-block d-md-none">
                            <div class="table-wrapper" style="border-radius: 10px; overflow: hidden;">
                                <table id="data" class="table table-bordered table-hover" style="margin-bottom: 0;">
                                    <thead style="background-color: #578FCA; color: white;">
                                        <tr>
                                            <th style="width:5vw;">No</th>
                                            <th>User</th>
                                            <th style="width:10vw;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($user) == 0)
                                            <tr>
                                                <td colspan="8" class="text-center">Data not found</td>
                                            </tr>
                                        @endif
                                        @foreach ($user as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <a href="{{ url('/admin/user_activity/activity/' . $item->id) }}"
                                                        class="btn btn-primary btn-sm">Lihat</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- TABEL DESKTOP (2 TABLE) -->
                        <div class="row d-none d-md-flex">
                            <div class="col-md-6">
                                <div class="table-wrapper" style="border-radius: 10px; overflow: hidden;">
                                    <table id="data" class="table table-bordered table-hover"
                                        style="margin-bottom: 0;">
                                        <thead style="background-color: #578FCA; color: white;">
                                            <tr>
                                                <th style="width:5vw;">No</th>
                                                <th>User</th>
                                                <th style="width:10vw;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($chunks[0]) == 0)
                                                <tr>
                                                    <td colspan="3" class="text-center">Data not found</td>
                                                </tr>
                                            @endif
                                            @foreach ($chunks[0] as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>
                                                        <a href="{{ url('/admin/user_activity/activity/' . $item->id) }}"
                                                            class="btn btn-primary btn-sm">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if (isset($chunks[1]))
                                <div class="col-md-6">
                                    <div class="table-wrapper" style="border-radius: 10px; overflow: hidden;">
                                        <table id="data" class="table table-bordered table-hover"
                                            style="margin-bottom: 0;">
                                            <thead style="background-color: #578FCA; color: white;">
                                                <tr>
                                                    <th style="width:5vw;">No</th>
                                                    <th>User</th>
                                                    <th style="width:10vw;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($chunks[1]) == 0)
                                                    <tr>
                                                        <td colspan="3" class="text-center">Data not found</td>
                                                    </tr>
                                                @endif
                                                @foreach ($chunks[1] as $key => $item)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>
                                                            <a href="{{ url('/admin/user_activity/activity/' . $item->id) }}"
                                                                class="btn btn-primary btn-sm">Lihat</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Pagination for desktop view -->
                        <div class="row justify-content-end d-none d-md-flex">
                            @if (count($user) == 0)
                                <div class="col-auto m-2">
                                    <p>Showing 0 to 0 of 0 entries</p>
                                </div>
                            @else
                                <div class="col-auto m-2">
                                    <p>Showing {{ $user->firstItem() }} to {{ $user->lastItem() }} of
                                        {{ $user->total() }}
                                        entries</p>
                                </div>
                                <div class="col-auto m-2">
                                    {{ $user->links() }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Pagination for mobile view -->
                    <div class="row justify-content-end d-block d-md-none">
                        @if (count($user) == 0)
                            <div class="col-auto m-2">
                                <p>Showing 0 to 0 of 0 entries</p>
                            </div>
                        @else
                            <div class="col-auto m-2">
                                <p>Showing {{ $user->firstItem() }} to {{ $user->lastItem() }} of
                                    {{ $user->total() }}
                                    entries</p>
                            </div>
                            <div class="col-auto m-2">
                                {{ $user->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </div>
@endsection
