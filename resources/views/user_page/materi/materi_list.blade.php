@extends('user_page.layout')
@section('style')
    <style>
        .custom-card {
            color: white;
            border-radius: 10px;
            padding: 15px;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 100%;
            min-height: 100px;
        }

        .icon {
            font-size: 30px;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .icon-container {
            flex: 1;
            display: flex;
            justify-content: center;
            margin-right: 10px;
        }

        .text-content {
            flex: 6;
            text-align: left;
            overflow: hidden;
        }

        .text-content h3 {
            font-size: 18px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-content p {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .download-icon {
            font-size: 20px;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Materi</h3>
                        <div class="card-tools d-flex align-items-center ml-auto">
                            <form method="GET" action="{{ url('/user/materi') }}"
                                class="d-flex flex-column flex-md-row align-items-stretch w-100">
                                <div class="input-group input-group-sm mb-2 mr-md-2" style="width: 100%; max-width: 80px;">
                                    <select class="custom-select" name="paginate" onchange="this.form.submit()">
                                        <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                </div>

                                <div class="input-group input-group-sm mb-2 mr-md-2" style="width: 100%; max-width: 120px;">
                                    <select class="custom-select" name="level" onchange="this.form.submit()">
                                        <option value="">Semua Level</option>
                                         @php
                                            // Get levels owned by the current user
                                            $userLevels = [];
                                            if (Auth::user()->role == 'user') {
                                                $userLevels = Auth::user()->levels->pluck('id')->toArray();
                                                $levels = \App\Models\Level::select('id', 'nama_level')
                                                    ->whereIn('id', $userLevels)
                                                    ->orderBy('urutan_level')
                                                    ->get();
                                            } else {
                                                // For admin/superadmin/teacher, show all levels
                                                $levels = \App\Models\Level::select('id', 'nama_level')
                                                    ->orderBy('urutan_level')
                                                    ->get();
                                            }
                                        @endphp
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}"
                                                {{ request('level') == $level->id ? 'selected' : '' }}>
                                                {{ $level->nama_level }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group input-group-sm mb-2 mr-md-2" style="width: 100%; max-width: 150px;">
                                    <input type="text" name="table_search" class="form-control" placeholder="Search"
                                        value="{{ request('table_search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($materi as $index => $item)
                                <div class="col-md-6 mb-4">
                                    <div class="custom-card d-flex mx-2"
                                        style="cursor: pointer; background-color:{{ $item->warna }} "
                                        onclick="window.location.href='{{ url('user/materi/' . $item->id) }}'">
                                        <div class="icon-container">
                                            <i class="fa-solid fa-book-open icon"></i>
                                        </div>
                                        <div class="text-content w-100">
                                            <h3 class="mb-1"> {{ $item->judul }} </h3>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-0" style="font-size: 15px"> {{ $item->deskripsi }} </p>
                                                <a href="{{ route('materi.download', $item->id) }}"
                                                    class="download-icon mr-3 p-2" onclick="event.stopPropagation();">
                                                    <i class="fa-solid fa-arrow-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row justify-content-end">
                            @if (count($materi) == 0)
                                <div class="col-auto m-2">
                                    <p>Showing 0 to 0 of 0 entries</p>
                                </div>
                            @else
                                <div class="col-auto m-2">
                                    <p>Showing {{ $materi->firstItem() }} to {{ $materi->lastItem() }} of
                                        {{ $materi->total() }}
                                        entries</p>
                                </div>
                                <div class="col-auto m-2">
                                    {{ $materi->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        //     document.querySelectorAll('.badge').forEach(function(badge) {
        //     const bgColor = badge.getAttribute('data-color');
        //     badge.style.color = getContrastColor(bgColor);
        // });
    </script>
@endsection
