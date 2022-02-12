$(document).ready(function() {

    function search() {
        //ajax
        var category = $('#category').val();
        var city = $('#city').val();
        var capacity = $('#capacity').val();
        var cost = $('#cost').val();
        var arrival_date = $('#arrival_date').val();
        var departure_date = $('#departure_date').val();
        var token = $('#token').val();
        $.ajax({
            method: "POST",
            headers: { "Authorization": localStorage.getItem(token) },
            url: "inc/room-search-result.php",
            data: {
                category: category,
                city: city,
                capacity: capacity,
                cost: cost,
                arrival_date: arrival_date,
                departure_date: departure_date
            },
            dataType: "JSON",
            success: function(data) {
                $("#results").html(data);
                //console.log(data);
            },
            error: function() {
                //show modal error
                $('#modal-notif').modal();
            }
        })
    }

    $("body").delegate("#category, #city, #capacity, #cost, #arrival_date, #departure_date", "change", function() {
        search();
    });

    $("body").delegate("#seeMore", "focus", function() {
        $('.moreData').css("display", "block");
        $(this).css("display", "none");
    });



})