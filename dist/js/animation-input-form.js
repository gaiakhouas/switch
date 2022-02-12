$(document).ready(function() {
    // delegate() is used for preventing the disability of the animation in case of any html appending
    $("body").delegate(".input-form", "focus", function() {
        $(".input-form").focus(function() {
            // animation of placeholder
            if (!$(this).hasClass("focused-input-valid")) {
                $(this).parent().addClass("changed");
                // styling the input 
                $(this).addClass("focused-input");
            }

        }).blur(function() {
            // removal of the animation and styling on blur
            //$(this).parent().removeClass("changed");
            if ($(this).val() == "") {
                $(this).parent().removeClass("changed");
            }
            $(this).removeClass("focused-input");
        });
    });
});