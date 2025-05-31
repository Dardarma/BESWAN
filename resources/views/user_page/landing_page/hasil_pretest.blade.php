@extends('user_page.layout')
@section('content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Informasi Pretest</h5>
                </div>

                <div class="card-body">
                    <table style="width: 100%; table-layout: fixed; mx-2">

                        <tr>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong> Waktu Pengerjaan </strong>
                                <p> {{ $quiz_user->waktu_pengerjaan }} </p>
                            </td>
                            @foreach ($type_soal as $type)
                                <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                    <strong> {{ $type->tipe_soal }} </strong>
                                    <p> {{ $type->jumlah_soal }} </p>
                                </td>
                            @endforeach
                        </tr>
                    </table>

                </div>

            </div>
        </div>
        <div class="col-12">
            <div class="card mt-4">

                <div class="card-body">
                    <table style="width: 100%; table-layout: fixed; mx-2">
                        <tr>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong> Lulus</strong>
                                <p> {{ $status }} </p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong> Waktu Mulai </strong>
                                <p> {{ $quiz_user->waktu_mulai}} </p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong> Waktu Selesai </strong>
                                <p> {{ $quiz_user->waktu_selesai }} </p>
                            </td>
                            <td class="p-2" style="background-color: #AADDFF; width: 25%;">
                                <strong>Nilai </strong>
                                <p> {{ $quiz_user->nilai_persen }} </p>
                            </td>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ url('/user/home') }}" class="btn btn-secondary btn-sm">Ke Halaman Home</a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    </div>
@endsection
