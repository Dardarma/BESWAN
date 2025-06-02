@extends('user_page.layout')
@section('style')
    <style>
        .book-card {
            display: flex;
            background: #AADDFF;
            border-radius: 10px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .image-container {
            width: 150px;
            min-width: 150px;
            height: 200px;
            background: #f0f4f8;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .book-image {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
        }

        .content {
            flex: 1;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .title {
            font-size: 20px;
            font-weight: 700;
            color: #2d3748;
            margin: 0 0 8px 0;
            line-height: 1.3;
        }

        .author {
            color: #718096;
            font-size: 14px;
            font-weight: 500;
        }

        .author-name {
            color: #4a5568;
            font-weight: 600;
        }

        .categories {
            color: #718096;
            font-size: 14px;
            margin: 0 0 4px 0;
        }

        .category-tag {
            color: #4a5568;
            font-weight: 600;
        }

        .published {
            color: #718096;
            font-size: 14px;
        }

        .publish-date {
            color: #4a5568;
            font-weight: 600;
        }

        @media (max-width: 480px) {
            .book-card {
                flex-direction: column;
                max-width: 300px;
            }

            .image-container {
                width: 100%;
                min-width: auto;
                height: 180px;
            }

            .content {
                padding: 20px;
            }
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
                                <div class="book-card">
                                    <div class="image-container">
                                        <!-- Uncomment and replace src to use actual image -->
                                        <img src="{{ Storage::url($item->tumbnail) }}" alt="Book Cover" class="book-image">
                                    </div>

                                    <div class="content">
                                        <h2 class="title"> {{ $item->judul }} </h2>

                                        <div class="author">
                                            Author: <span class="author-name"> {{ $item->author }} </span>
                                        </div>

                                        <div class="published">
                                            Published: <span class="publish-date">{{$item->terbitan}} </span>
                                        </div>

                                        <div class="categories">
                                           Description: <span class="category-tag"> {{$item->deskripsi}} </span>
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
