$(function(){
    $('#viewForm').on('submit', function(e){
        e.preventDefault();
        var $object = $(this),
        formData = new FormData(this);
        $.ajax({
            url: $object.attr('action'),
            type: $object.attr('method'),
            processData: false,
            contentType: false,
            data: formData,
            dataType: 'html',
            success: function(html) {
                $('#load').val('');
                $('#load').html( html );
            }
        });
    });
});
