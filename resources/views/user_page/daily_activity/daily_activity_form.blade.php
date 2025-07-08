@extends('user_page.layout')
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="m-0">{{ $user->name }}</h3>
                                <small>{{ \Carbon\Carbon::now()->format('d-m-y') }}</small>
                            </div>    
                        </div>
                        <div class="ml-auto">
                            <a href="{{url('/user/daily_activity/info')}}" class="btn btn-info">more</a>
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
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                @foreach ($user_activity as $key => $activity)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $activity->activity }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="form-check
                                                    d-flex justify-content-center align-items-center"
                                                    id="checkbox-wrapper-{{ $activity->id }}">
                                                    <input type="checkbox" class="form-check-input"
                                                        data-id="{{ $activity->id }}"
                                                        data-activity-id="{{ $activity->id_activity ?? '' }}"
                                                        data-status="{{ $activity->status }}" onchange="updateStatus(this)"
                                                        id="checkbox-{{ $activity->id }}"
                                                        {{ $activity->status ? 'checked' : '' }}>
                                                    <span class="spinner-border spinner-border-sm d-none"
                                                        id="spinner-{{ $activity->id }}"></span>
                                                </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                        <div class="table-responsive col-md-6 col-12 mt-3">
                            <h5>Monthly Activity Summary</h5>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:5vw;">No</th>
                                        <th>Aktivitas</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($monthlyActivity as $key => $monthlyItem)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $monthlyItem->activity }}</td>
                                            <td id="monthly-{{ $monthlyItem->id_activity }}">
                                                {{ $monthlyItem->jumlah_aktivitas }}</td>
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
            const id_activity = $(checkbox).data('activity-id');

            // Ambil status awal dari data-status (sebelum checkbox berubah)
            let currentStatus = parseInt($(checkbox).data('status'));
            let newStatus = checkbox.checked ? 1 : 0;

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
                        // Update jumlah aktivitas di tabel monthly
                        $('#monthly-' + response.id_activity).text(response.jumlah_aktivitas);

                        // Update status baru ke data-status biar sync
                        $(checkbox).data('status', newStatus);

                        console.log('Status updated successfully');
                    } else {
                        alert("Gagal memperbarui status.");
                        checkbox.checked = currentStatus === 1; // kembalikan ke status sebelumnya
                    }
                },
                error: function(xhr, status, error) {
                    alert("Terjadi kesalahan saat menyimpan: " + error);
                    checkbox.checked = currentStatus === 1; // kembalikan ke status sebelumnya
                    console.error('Error:', error);
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
