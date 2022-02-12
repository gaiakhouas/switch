$(document).ready(function() {
    $("body").delegate(".save, .update, .delete, .confirm", "click", function() {
        //ajax
        var form = $('#member').get(0);
        var formData = new FormData(form); // get the form data
        if ($(this).hasClass('save')) {
            formData.append('action', 'save');
        } else if ($(this).hasClass('update')) {
            formData.append('action', 'update');
        } else if ($(this).hasClass('delete')) {
            formData.append('action', 'delete');
        } else if ($(this).hasClass('confirm')) {
            formData.append('action', 'confirm');
        }

        var token = $('#token').val();
        $.ajax({
            method: "POST",
            headers: { "Authorization": localStorage.getItem(token) },
            url: "inc/member.handler.inc.php",
            data: formData,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function(data) {
                $("#results").html(data);
                //console.log(data);
            },
            error: function() {
                //show modal error
                $('#modal-notif').modal();
            }
        })
    });
});