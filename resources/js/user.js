$(document).ready(function(){
    $('#submitButton').click(function(){

        var formData = $('#userForm').serialize();

        $.ajax({
            url: '/user/add',
            type: 'POST',
            data: formData,
            success: function(response){
                $('#addUser'),modal('hide');

                alert('User berhasil ditambahakan');
            },
            error: function(xhr){
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value){
                    $('input[name="' + key + '"]').next('.text-danger').remove();
                    $('input[name="'+ key +'"]').after('<div class="text-danger>'+value[0]+'</div>')
                });
            }
        });
    });
});