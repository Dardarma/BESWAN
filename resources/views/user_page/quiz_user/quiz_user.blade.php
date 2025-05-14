@extends('admin_page.layout')
@section('content')

    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex  align-items-center">
                    <div class="col-1 m-0 p-0 text-end">
                        <a href="{{ url('/admin/quiz/'.$type_soal->quiz_id)}}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i></a>
                    </div> 
                    <h3 class="card-title">Informasi Soal</h3>
                </div>
                <div class="card-body">
                    <table style="width: 100%; table-layout: fixed;">
                        <tr>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Judul Quiz</strong>
                                <p>{{$type_soal->judul_quiz}} </p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Tipe soal</strong>
                                <p> Isian Singkat </p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Jumlah Soal</strong>
                                <p>{{$type_soal->jumlah_soal}}</p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Jumlah Soal Saat ini</strong>
                                <p>{{$type_soal->jumlah_soal_now}}</p>
                            </td>
                        </tr>
                    </table> 
            </div>
        </div>

         <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex  align-items-center">
                    <h3 class="card-title">Informasi Soal</h3>
                </div>
                <div class="card-body">
                    
            </div>
        </div>

       
    </div>

@endsection

@section('script')

@endsection
