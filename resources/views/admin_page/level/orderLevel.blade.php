
<div class="modal fade" id="orderLevel" tabindex="-1" role="dialog" aria-labelledby="orderLevelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Ordering Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container mb-3">
                    <ul id="sortable" style="list-style-type: none; padding: 0; width:50%; justify-content: center; margin: 0 auto;">
                        @foreach ($meta as $meta)
                            <li class="ui-state-default drag" data-id="{{ $meta->id }}" 
                                style="margin: 5px; padding: 10px; background-color: {{ $meta->warna }}; cursor: move; border-radius: 20px; text-align:center" data-color="{{ $meta->warna }}">
                                {{ $meta->nama_level }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                
                    <div class="my-2">
                        <button type="submit" class="btn btn-primary " id="saveButton">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                        </button>
                    </div>
                
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $("#sortable").sortable({
        placeholder: "ui-state-highlight", 
        update: function(event, ui) {
            let order = [];
            $('#sortable li').each(function(index, element) {
                order.push({
                    id: $(element).data('id'),
                    position: index + 1
                });
            });

            console.log(order); // Debug untuk memastikan data benar
        }
    });

    // Mencegah teks terseleksi saat di-drag
    $("#sortable").disableSelection();

    $("#saveButton").on('click', function(){
        let order = [];
        $('#sortable li').each(function(index, element) {
            order.push({
                id: $(element).data('id'),
                position: index + 1
            });
        });

        $.ajax({
            url: "{{ url('/admin/master/level/reoder') }}",
            type: "POST",
            data: {
                order: order,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
              Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Urutan level berhasil disimpan!',
                }).then(() => {
                    location.reload(); // Reload halaman setelah sukses
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: error,
                });
            }
        });
    })
})

function getContrastColor(hex) {
    const r = parseInt(hex.substring(1, 3), 16);
    const g = parseInt(hex.substring(3, 5), 16);
    const b = parseInt(hex.substring(5, 7), 16);

    const brightness = (r * 299 + g * 587 + b * 114) / 1000;

    return brightness > 128 ? '#000' : '#fff';
}

document.querySelectorAll('.drag').forEach(function(drag) {
    const bgColor = drag.getAttribute('data-color');
    drag.style.color = getContrastColor(bgColor);
});


</script>