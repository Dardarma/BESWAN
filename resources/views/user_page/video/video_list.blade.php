@extends('user_page.layout')
@section('style')
    <style>
        .custom-card {
            color: white;
            border-radius: 10px;
            padding: 10px;
            align-items: flex-start;
            justify-content: space-between;
            width: 100%;
            height: 100%;
            min-height: 80px;
        }

        .icon {
            font-size: 30px;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .icon-container {
            flex: 3;
            display: flex;
            justify-content: center;
            margin-right: 10px;
            max-height: 120px;
            overflow: hidden;
        }

        .text-content {
            flex: 4;
            text-align: left;
            overflow: hidden;
            padding-top: 0;
        }

        .text-content h3 {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 5px;
        }

        .text-content small {
            font-size: 15px;
        }

        .text-content p {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            font-size: 20px;
            margin-top: 5px;
        }


    </style>
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                       <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Video</h3>
                        <div class="card-tools d-flex align-items-center ml-auto">
                            <form method="GET" action="{{ url('/user/video') }}"
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
                        <div class="row mx-auto">
                            @foreach ($video as $index => $item)
                                <div class="col-md-6 m-2">
                                    <div class="custom-card d-flex mx-2"
                                        style="cursor: pointer; background-color:{{ $item->warna }} "
                                        onclick="window.location.href='{{ url('user/video/' . $item->id) }}'">
                                        <div class="icon-container">
                                            <img class="card-img-top m-1"
                                                src="https://img.youtube.com/vi/{{ Str::before(Str::afterLast($item->url_video, '/'), '?') }}/hqdefault.jpg"
                                                alt="Card image"
                                                style="width: 100%; height: auto; max-height: 110px; object-fit: cover;" />
                                        </div>
                                        <div class="text-content w-100">
                                            <h3> {{ $item->judul_materi }} </h3>
                                            <small
                                                class="text-light d-block">{{ \Carbon\Carbon::parse($item->updated_at)->format('d-m-Y') }}</small>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-0"> {{ $item->deskripsi }} </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row justify-content-end">
                            @if (count($video) == 0)
                                <div class="col-auto m-2">
                                    <p>Showing 0 to 0 of 0 entries</p>
                                </div>
                            @else
                                <div class="col-auto m-2">
                                    <p>Showing {{ $video->firstItem() }} to {{ $video->lastItem() }} of
                                        {{ $video->total() }}
                                        entries</p>
                                </div>
                                <div class="col-auto m-2">
                                    {{ $video->links() }}
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
