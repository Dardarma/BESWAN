@extends('admin_page.layout')
@section('style')

@endsection
@section('content')

<div class="container-fluid mt-3">
    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ url('/admin/user_activity')}}" class="btn btn-secondary me-3 mr-3">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h3 class="m-0">Monitoring Kegiatan {{$user->name}}</h3>
                </div>
                <div>
                    <form action="{{ url('/admin/user_activity/generate/monthly') }}" method="post" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </form>
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
                            @foreach($dates as $date)  <!-- Ganti nama parameter -->
                                <th > {{$date}} </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activity as $key => $activity)
                            <tr>
                                <td> {{$key + 1 }} </td>
                                <td> {{$activity->activity}} </td>
                                @foreach($dates as $date)  
                                    <td>
                                        @php
                                            $found = $userActivity->where('id_activity', $activity->id);
                    
                                            $tanggal = Carbon\Carbon::createFromFormat('Y-m-d', Carbon\Carbon::now()->format('Y-m-') . $date)->toDateString();

                                            $status = $found->first(function ($item) use ($tanggal) {
                                                return $item->created_at->format('Y-m-d') === $tanggal;
                                            });

                                        @endphp
                    
                                        @if(!$status)
                                            -
                                        @else
                                            @if($status->status == true)
                                                V
                                            @else
                                                X
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
            
            <div class="table-responsive col-6 mt-3">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width:5vw;">No</th>
                            <th>Aktivitas</th>
                            <th> Jumlah </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyActivity as $key=>$monthly)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td> {{$monthly->activity}} </td>
                                <td> {{$monthly->jumlah_aktivitas}} </td>
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
