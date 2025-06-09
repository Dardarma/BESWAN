@extends('user_page.layout')
@section('style')
    <style>
        .custom-card {
            color: white;
            border-radius: 5px;
            padding: 10px;
            align-items: flex-start;
            justify-content: space-between;
            width: 80%;
            height: 100%;
            min-height: 80px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
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
            min-height: 200px;
            max-height: 200px;
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
                        <h3>Materi</h3>
                        <div class="card-tools d-flex align-items-center ml-auto">
                            <form method="GET" action="{{ url('/user/materi') }}" class="d-flex align-items-center">
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
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mx-auto">
                            @foreach ($ebook as $index => $item)
                                <div class="col-md-6 col-12 m-2 justify-content-center">
                                    <div class="custom-card d-flex mx-2"
                                        style="cursor: pointer; background-color: rgb(9, 188, 211) "
                                        onclick="window.open('{{ Storage::url(str_replace('public/', '', $item->url_file)) }}', '_blank')">
                                        <div class="icon-container">
                                            <img class="card-img-top m-1" src="{{ Storage::url($item->tumbnail) }}"
                                                alt="Card image"
                                                style="width: 100%; height: auto; max-height: 200px; object-fit: cover;" />
                                        </div>
                                        <div class="text-content w-100">
                                            <h2 class="title"> {{ $item->judul }} </h2>

                                            <div class="author">
                                                Author: <br>
                                                <span class="author-name"> {{ $item->author }} </span>
                                            </div>

                                            <div class="published">
                                                Published: <br>
                                                <span class="publish-date">{{ $item->terbitan }} </span>
                                            </div>
                                            <div class="categories">
                                                Description: <br>
                                                <span class="category-tag text-truncate">
                                                    {{ Str::limit($item->deskripsi, 100) }} </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row justify-content-end">
                            @if (count($ebook) == 0)
                                <div class="col-auto m-2">
                                    <p>Showing 0 to 0 of 0 entries</p>
                                </div>
                            @else
                                <div class="col-auto m-2">
                                    <p>Showing {{ $ebook->firstItem() }} to {{ $ebook->lastItem() }} of
                                        {{ $ebook->total() }}
                                        entries</p>
                                </div>
                                <div class="col-auto m-2">
                                    {{ $ebook->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
