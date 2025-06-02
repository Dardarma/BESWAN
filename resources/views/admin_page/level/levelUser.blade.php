@extends('admin_page.layout')
@section('content')

    <div class="row mx-2">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Level User</h3>

                    <div class="card-tools d-flex align-items-center ml-auto">

                        <form method="GET" action="{{ url('/admin/master/level/user') }}" class="d-flex align-items-center">
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
                        <a href="{{ url('/admin/master/level/list')}}" type="button" class="btn btn-info">List Level</a>
                    </div>
                </div>

                <div class="card-body">


                <div class="table-wrapper" style="overflow: hidden; border-radius: 10px;">
                    <table id="data" class="table table-bordered table-hover" style="border-radius: 10px;">
                      <thead style="background-color: #578FCA; color: white;">
                        <tr>
                            <th style="width: 5vw">No</th>
                            <th style="width: 30vw">User</th>
                            <th style="width: 30vw">level</th>
                            <th style="width: 10vw">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($users) == 0)
                            <tr>
                                <td colspan="5" class="text-center">Data not found</td>
                            </tr>
                        @endif
                        @foreach ($users as $key => $item)
                        <tr>
                            <td>{{ $users->firstItem() + $key }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                @foreach ($item->levels as $level)
                                <span class="badge" style="background-color: {{ $level->warna }};" data-color="{{ $level->warna }}">
                                    {{ $level->nama_level }}
                                </span>
                                @endforeach
                            </td>
                            <td>
                                <button 
                                    class="btn btn-primary" 
                                    data-toggle="modal" 
                                    data-target="#addUser"
                                    onclick="setUserId({{ $item->id }}, {{ $item->levels ? $item->levels->pluck('id') : '[]' }})"
                                    >
                                    Kelola Level
                                </button>
                            </td>                         
                        </tr>                        
                        @endforeach                        
                    </tbody>
                </table>
                </div>
                
                <!-- Pagination -->
                <div class="row justify-content-end">
                    @if (count($users) == 0)
                        <div class="col-auto m-2">
                            <p>Showing 0 to 0 of 0 entries</p>
                        </div>
                    @else
                        <div class="col-auto m-2">
                            <p>Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of
                                {{ $users->total() }}
                                entries</p>
                        </div>
                        <div class="col-auto m-2">
                            {{ $users->appends(request()->except('page'))->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>

        <!-- Modal tunggal di luar loop -->
        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">kelola level</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/admin/master/level/user/edit') }}" method="POST" id="addUserForm">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="user_id" id="user_id">
                            @foreach ($levels as $lvl)
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="levels[]" 
                                    value="{{ $lvl->id }}" 
                                    id="level_{{ $lvl->id }}"
                                    data-order="{{ $lvl->urutan_level }}"
                                    onchange="handleLevelCheck({{ $lvl->id }})"
                                >
                                <label class="form-check-label" for="level_{{ $lvl->id }}">
                                    {{ $lvl->nama_level }}
                                </label>
                            </div>
                            @endforeach

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        

        
    </div>
@endsection

@section('script')
<script>
function handleLevelCheck(levelId) {
    const checkbox = document.getElementById(`level_${levelId}`);
    const urutan = parseInt(checkbox.getAttribute('data-order'));

    document.querySelectorAll('input[name="levels[]"]').forEach((el) => {
        let elOrder = parseInt(el.getAttribute('data-order'));

        if (elOrder === urutan + 1) { 
            // Hanya aktifkan level langsung setelahnya
            if (checkbox.checked) {
                el.disabled = false;
            } else {
                el.checked = false;
                el.disabled = true;
            }
        } else if (elOrder > urutan + 1) {
            // Nonaktifkan semua level setelahnya kalau level sebelumnya dilepas
            el.checked = false;
            el.disabled = true;
        }
    });
}

function setUserId(userId, ownedLevels) {
    document.getElementById('user_id').value = userId;

    // Reset semua checkbox ke kondisi awal
    document.querySelectorAll('input[name="levels[]"]').forEach((checkbox) => {
        checkbox.checked = false;
        checkbox.disabled = true;
    });

    // Aktifkan level pertama
    const firstLevel = document.querySelector('input[name="levels[]"][data-order="1"]');
    if (firstLevel) {
        firstLevel.disabled = false;
    }

    // Centang dan aktifkan level yang sudah dimiliki user
    ownedLevels.forEach((id) => {
        let checkbox = document.getElementById(`level_${id}`);
        if (checkbox) {
            checkbox.checked = true;
            checkbox.disabled = false;
        }
    });

    // Jalankan logika dependency untuk membuka level selanjutnya
    ownedLevels.forEach((id) => handleLevelCheck(id));
}

function getContrastColor(hex) {
    const r = parseInt(hex.substring(1, 3), 16);
    const g = parseInt(hex.substring(3, 5), 16);
    const b = parseInt(hex.substring(5, 7), 16);

    // Hitung kecerahan (brightness) berdasarkan rumus W3C
    const brightness = (r * 299 + g * 587 + b * 114) / 1000;

    // Jika terang → warna teks hitam, jika gelap → warna teks putih
    return brightness > 128 ? '#000' : '#fff';
}

document.querySelectorAll('.badge').forEach(function(badge) {
    const bgColor = badge.getAttribute('data-color');
    badge.style.color = getContrastColor(bgColor);
});
    
</script>
@endsection
