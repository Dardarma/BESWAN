@extends('admin_page.layout')
@section('content')

    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Level</h3>
                    <div class="card-tools d-flex align-items-center ml-auto">
                        <form method="GET" action="{{ url('master/level/list') }}" class="d-flex align-items-center">
                            <!-- Pagination Dropdown -->
                            <div class="input-group input-group-sm" style="width: 80px; margin-right: 10px;">
                                <select class="custom-select" name="paginate" onchange="this.form.submit()">
                                    <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        
                            <div class="input-group input-group-sm" style="width: 150px; margin-right: 10px;">
                                <input type="text" name="table_search" class="form-control" placeholder="Search" value="{{ request('table_search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>                        
                
                        <!-- Add Level Button -->
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addQuiz" >Add Quiz</button>
                    </div>
                </div>
                

                <div class="card-body">  
                    <table class="table table-bordered table-hover" style="width: 100%; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th style="width: 5vw">No</th>
                                <th style="width: 20vw">Judul Quiz</th>
                                <th style="width: 5vw">Jumlah Soal</th>
                                <th style="width: 10vw">Waktu</th>
                                <th style="width: 6vw">Level</th>
                                <th style="width: 8vw">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($quiz) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endif
                            @foreach ($quiz as $key => $item)
                                <tr>
                                    <td>{{ $quiz->firstItem() + $key }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->jumlah_soal}}</td>
                                    <td>{{ $item->waktu_pengerjaan}}</td>
                                    <td>{{$item->urutan_level}}  </td>
                                    <td>
                                        <a class="btn btn-primary btn-edit btn-sm" href="{{ url('quiz/edit/'.$item->id) }}" >
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <form id="delete-form-{{ $item->id }}" method="POST" style="display:inline;" action="{{url('/article/delete/'.$item->id)}}">
                                            @csrf
                                            @method('DELETE') 
                                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}" ><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>                         
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-end">
                    <div class="col-auto m-2">
                        <p>Showing {{ $quiz->firstItem() }} to {{ $quiz->lastItem() }} of {{ $quiz->total() }} entries</p>
                    </div>
                    <div class="col-auto m-2">
                        {{$quiz->links()}}
                    </div>
                </div>
                </div>
            </div>

    </div>
@include('admin_page.quiz.quiz_add_modal')
@endsection

@section('script')
<script>

</script>
@endsection
