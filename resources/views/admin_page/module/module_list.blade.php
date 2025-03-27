@extends('admin_page.layout')
@section('style')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('content')

<div class="container-fluid mt-3">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header row">
            <div class="col-6">
                <h3>Modul</h3>
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addModule">Add book</button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Cover</th>
                <th>File</th>
                <th>Author</th>
                <th>Aksi</th>
              </tr>
              </thead>
              <tbody>
                @foreach($modul as $key => $item)
              <tr>
                <td> {{ $key +1 }} </td>
                <td> {{ $item->judul}} </td>
                <td> {{ $item->deskripsi}} </td>
                <td> 
                  @if($item->tumbnail)
                  <img src="{{ Storage::url($item->tumbnail)}}" alt="" style="width: 100px"> 
                  @else
                   -
                  @endif
                </td>
                <td> <a  class="btn btn-primary btn-sm" href="{{ Storage::url($item->url_file) }}" target="_blank">Lihat File</a>  </td>
                <td> {{$item->author}} </td>
                <td>
                    <a  
                      class="btn btn-warning btn-edit btn-sm"
                      data-toggle="modal"
                      data-target="#editModule"
                      data-id="{{ $item->id }}"
                      data-judul="{{ $item->judul }}"
                      data-deskripsi="{{ $item->deskripsi }}"
                      data-tumbnail="{{ $item->tumbnail }}"
                      data-url="{{ $item->url_file }}"
                      data-author="{{ $item->author }}"
                    >
                    <i class="fa-solid fa-pencil"></i></a>
                    <form id="{{ $item->id }}" method="POST" style="display:inline;" action="{{url('/admin/module/delete/'.$item->id)}}">
                      @csrf
                      @method('DELETE') 
                      <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}" ><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
              </tr>
              @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskrisi</th>
                <th>thumbnail</th>
                <th>url</th>
                <th>Author</th>
                <th>Aksi</th>
              </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    @include('admin_page.module.module_add')
    @include('admin_page.module.module_edit')
  </div>
  @endsection
  @section('script')
  <script src=" {{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src=" {{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src=" {{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src=" {{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <script src=" {{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src=" {{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
  <script src=" {{asset('plugins/jszip/jszip.min.js')}}"></script>
  <script src=" {{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
  <script src=" {{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
  <script src=" {{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
  <script src=" {{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
  <script src=" {{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

  <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  $(document).ready(function(){
    $('.btn-edit').on('click', function (){
      let id = $(this).data('id');
      let judul = $(this).data('judul');
      let deskripsi = $(this).data('deskripsi');
      let tumbnail = $(this).data('tumbnail');
      let url_file = $(this).data('url_file');
      let author = $(this).data('author');

      $('#editModule').find('input[name="id"]').val(id);
      $('#editModule').find('input[name="judul"]').val(judul);
      $('#editModule').find('textarea[name="deskripsi"]').val(deskripsi);
      $('#editModule').find('input[name="tumbnail"]').val('');
      $('#editModule').find('input[name="url_file"]').val('');
      $('#editModule').find('input[name="author"]').val(author);


    })  
      $('editModule').modal('show');
  })

  document.addEventListener('DOMContentLoaded',function(){
      document.querySelectorAll('.btn-delete').forEach(function(button){
          button.addEventListener('click',function(){
              let formId = button.getAttribute('data-id');

              Swal.fire({
                  title: 'Apakah anda yakin?',
                  text: "Data yang dihapus tidak dapat dikembalikan!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Ya, hapus!',
                  cancelButtonText: 'Batal'
              }).then((result) => {
                  if (result.isConfirmed) {
                      document.getElementById('delete-form-'+ formId).submit();
                  }
          })
      })
    })
  })
  
  </script>
  @endsection