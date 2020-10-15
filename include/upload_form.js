$(function(){
    $('#upl-form').on('submit', function(e){
        e.preventDefault();
        var $object = $(this),
        formData = new FormData(this);
        $.ajax({
            url: $object.attr('action'),
            type: $object.attr('method'),
            processData: false,
            contentType: false,
            data: formData,
            dataType: 'json',
            success: function(json){
                if(json){
                    $('#result').html( json );
                    $('#my-file').val('');
                }
            }
        });
    });
});