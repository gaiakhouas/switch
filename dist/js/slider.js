$(document).ready(function() {
    // cost view
    $("#slider-range").slider({
        range: "max",
        min: 0,
        max: 5000,
        values: [300],
        slide: function(event, ui) {
            $("#costText").val("maximum : " + ui.values[0] + "€");
            $("#cost").val(ui.values[0]).trigger('change');
            // add fonction ajax
        }
    });
    $("#costText").val("maximum : " + $("#slider-range").slider("values", 0));
    // grade view
    $("#slider-range2").slider({
        range: "max",
        min: 0,
        max: 5,
        values: [0],
        slide: function(event, ui) {
            $("#gradeText").val("Votre note : " + ui.values[0] + "/5");
            $("#grade").val(ui.values[0]).trigger('change');
            // add fonction ajax
        }
    });
    $("#gradeText").val("Votre note : " + $("#slider-range2").slider("values", 0) + "/5");

});