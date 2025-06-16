@extends('user_page.layout')
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                           
                            {{-- Tambah flex-column agar teks jadi vertikal --}}
                            <div class="d-flex flex-column">
                                <h3 class="m-0">{{ $user->name }}</h3>
                                <small>{{ \Carbon\Carbon::now()->format('F') }}</small>
                            </div>
                        </div>
                    </div>


                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:5vw;">No</th>
                                        <th>Aktivitas</th>
                                        @foreach ($dates as $date)
                                            <th> {{ $date }} </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activity as $key => $activityItem)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $activityItem->activity }} </td>
                                            @foreach ($dates as $date)                                                <td>
                                                    @php
                                                        $found = $userActivity->where('id_activity', $activityItem->id);

                                                        $tanggal = Carbon\Carbon::createFromFormat(
                                                            'Y-m-d',
                                                            Carbon\Carbon::now()->format('Y-m-') . $date,
                                                        )->toDateString();

                                                        $statusRecord = $found->first(function ($item) use ($tanggal) {
                                                            return $item->created_at->format('Y-m-d') === $tanggal;
                                                        });
                                                    @endphp

                                                    @if ($statusRecord)
                                                        <div id="checkbox-wrapper-{{ $statusRecord->id }}">
                                                            <input type="checkbox" onclick="updateStatus(this)"
                                                                data-id="{{ $statusRecord->id }}"
                                                                data-activity-id="{{ $activityItem->id }}"
                                                                data-status="{{ $statusRecord->status ? 1 : 0 }}"
                                                                {{ $statusRecord->status ? 'checked' : '' }}>
                                                        </div>

                                                        <div id="spinner-{{ $statusRecord->id }}"
                                                            class="spinner-border spinner-border-sm text-primary d-none"
                                                            role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                        <div class="table-responsive col-md-6 col-12 mt-3">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:5vw;">No</th>
                                        <th>Aktivitas</th>
                                        <th> Jumlah </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activity as $key => $activityItem)
                                        @php
                                            $monthly = $monthlyActivity->firstWhere(
                                                'id_activity',
                                                $activityItem->jumlah_aktivitas,
                                            );
                                            $jumlahAktivitas = $monthly ? $monthly->jumlah_aktivitas : 0;
                                            // dd($monthlyActivity);
                                            // dd($jumlahAktivitas);
                                            // dd($mon)
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $activityItem->activity }}</td>
                                            <td id="jumlah-aktivitas-{{ $activityItem->id }}">{{ $jumlahAktivitas }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        function updateStatus(checkbox) {
            const id = $(checkbox).data('id');
            const id_activity = $(checkbox).data('activity');

            // Ambil status awal dari data-status (sebelum checkbox berubah)
            let currentStatus = parseInt($(checkbox).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            // Tampilkan spinner, sembunyikan checkbox
            $('#checkbox-wrapper-' + id).addClass('d-none');
            $('#spinner-' + id).removeClass('d-none');

            $.ajax({
                url: '{{ route('updateDailyActivity') }}',
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: newStatus
                },
                success: function(response) {
                    if (response.success) {
                        $('#jumlah-aktivitas-' + response.id_activity).text(response.jumlah_aktivitas);
                        // Update status baru ke data-status biar sync
                        $(checkbox).data('status', newStatus);
                    } else {
                        alert("Gagal memperbarui status.");
                        checkbox.checked = currentStatus === 1; // kembalikan
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan saat menyimpan.");
                    checkbox.checked = currentStatus === 1;
                },
                complete: function() {
                    // Show checkbox lagi, hide spinner
                    $('#checkbox-wrapper-' + id).removeClass('d-none');
                    $('#spinner-' + id).addClass('d-none');
                }
            });
        }
    </script>
@endsection
