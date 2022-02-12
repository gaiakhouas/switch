/** function : controls each input regarding the W3C standards :
 * controls : size, format(date), pattern
 * helps the user to write down inside the input correctly :
 */
$(document).ready(function() {
    var default_msg = "Aide à la saisie";
    sessionStorage.setItem("emailtest", "");
    sessionStorage.setItem("checkLog", "");
    //login control inputs
    $("body").delegate("#login, #emailLog, #passLog", "focus keyup", function checkLogin() {
        var idHelp = "";
        var inputVal = "";
        switch ($(this).attr('id')) {
            case "emailLog":
                idHelp = $("#help-email");
                inputVal = $('#emailLog').val();
                idHelp.removeClass("hidden");
                break;
            case "passLog":
                idHelp = $("#help-pass");
                inputVal = $('#passLog').val();
                idHelp.removeClass("hidden");
                break;
        }

        // email / pseudo
        if ($(this).attr('id') == "emailLog" || $(this).attr('id') == "passLog") {
            var emailC = $("#emailLog").val();
            var passC = $("#passLog").val();
            var emailSel = $("#emailLog");
            var passSel = $("#passLog");
            $.ajax({
                method: "POST",
                url: "inc/login-handler.php",
                data: {
                    emailC: emailC,
                    passC: passC
                },
                dataType: "JSON",
                async: false,
                success: function(data) {
                    if (data == 1) {
                        sessionStorage.setItem("checkLog", "ok");
                        emailSel.parent().removeClass(["error"]).addClass("valid");
                        emailSel.removeClass(["focused-input", "focused-input-error"]).addClass("focused-input-valid");
                        idHelp.removeClass("error-input").addClass("valid-input").text("Saisie valide");

                    } else {
                        sessionStorage.setItem("checkLog", "ko");
                        $("#emailLog").parent().removeClass(["valid"]).addClass("error");
                        $("#emailLog").removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                        idHelp.removeClass("hidden").addClass("error-input").text("Saisie invalide.");
                    }
                },
                error: function() {
                    //show modal error
                    $('#modal-notif').modal();
                }
            });
        }
        // password
        if ($(this).attr('id') == "passLog") {
            if (inputVal.length <= 0) {
                $(this).parent().removeClass(["valid"]).addClass("error");;
                $(this).removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                idHelp.removeClass("valid-input").addClass("error-input").text("Saisie trop court");
            } else {
                $(this).parent().removeClass(["error"]).addClass("valid");;
                $(this).removeClass(["focused-input-error"]).addClass("focused-input-valid");
            }

        }

        var email = $("#emailLog").val();
        var password = $("#passLog").val();

        if (sessionStorage.getItem("checkLog") == "ok") {
            $("#login").prop('type', 'submit');
        } else {
            $("#login").prop('type', 'button');
        }
        if ($("#signin").attr("type") == "button") {
            // check each input value
            if (($("#emailLog").val() == "")) {
                $("#emailLog").parent().removeClass(["valid"]).addClass("error");;
                $("#emailLog").removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                $("#help-email").removeClass("hidden").addClass("error-input").text("Veuillez renseigner un email valide.");
            }

            if (($("#passLog").val() == "")) {
                $("#passLog").parent().removeClass(["valid"]).addClass("error");;
                $("#passLog").removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                $("#help-pass").removeClass("hidden").addClass("error-input").text("Veuillez renseigner un mot de passe.");
            }

        }
    });

    // signup control inputs 
    $("body").delegate("#email, #pseudo, #password, #firstName, #lastName, #management, #subscribe", "keyup change focus", function checkForm() {
        var idHelp = "";
        var inputVal = "";
        var email = $("#email").val();
        switch ($(this).attr('id')) {
            case "pseudo":
                idHelp = $("#help-pseudo");
                inputVal = $('#pseudo').val();
                idHelp.removeClass("hidden");
                break;
            case "email":
                idHelp = $("#help-email");
                inputVal = $('#email').val();
                idHelp.removeClass("hidden");
                break;
            case "password":
                idHelp = $("#help-pass");
                inputVal = $('#password').val();
                idHelp.removeClass("hidden");
                break;
            case "firstName":
                idHelp = $("#help-firstname");
                inputVal = $('#firstName').val();
                idHelp.removeClass("hidden");
                break;
            case "lastName":
                idHelp = $("#help-lastname");
                inputVal = $('#lastName').val();
                idHelp.removeClass("hidden");
                break;
            case "management":
                idHelp = $("#help-man");
                inputVal = $('#management').val();
                idHelp.removeClass("hidden");
                break;
        }

        if ($(this).attr('id') == "pseudo") {

            if (inputVal.length <= 50 && inputVal.length >= 0) {
                var pseudo = $("#pseudo").val();
                var pseudoSel = $("#pseudo");
                $.ajax({
                    method: "POST",
                    url: "inc/signup.handler.inc.php",
                    data: {
                        pseudo: pseudo
                    },
                    dataType: "JSON",
                    async: false,
                    success: function(data) {
                        if (data == 1) {
                            sessionStorage.setItem("emailtest", "ko");
                            pseudoSel.parent().removeClass(["valid"]).addClass("error");;
                            pseudoSel.removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                            idHelp.removeClass("valid-input").addClass("error-input").text("Ce pseudo existe déjà.");

                        } else {
                            sessionStorage.setItem("emailtest", "ok");
                            pseudoSel.parent().removeClass(["error"]).addClass("valid");
                            pseudoSel.removeClass(["focused-input", "focused-input-error"]).addClass("focused-input-valid");
                            idHelp.removeClass("error-input").addClass("valid-input").text("Saisie valide");
                        }
                    },
                    error: function() {
                        //show modal error
                        $('#modal-notif').modal();
                    }
                });
            }
        }
        // password
        if ($(this).attr('id') == "password") {
            if (inputVal.length <= 128 && inputVal.length >= 10) {
                $(this).parent().removeClass(["error"]).addClass("valid");
                $(this).removeClass(["focused-input", "focused-input-error"]).addClass("focused-input-valid");
                idHelp.removeClass("error-input").addClass("valid-input").text("Saisie valide");

            } else {
                $(this).parent().removeClass(["valid"]).addClass("error");;
                $(this).removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                idHelp.removeClass("valid-input").addClass("error-input").text("Saisie trop court (1O caractères minimum)");
            }
        }
        // first and last name
        if ($(this).attr('id') == "firstName" || $(this).attr('id') == "lastName") {
            if (inputVal.length > 50) {
                $(this).parent().removeClass(["valid"]).addClass("error");;
                $(this).removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                idHelp.removeClass("valid-input").addClass("error-input").text("Saisie trop court");

            } else if (inputVal.length >= 2) {
                $(this).parent().removeClass(["error"]).addClass("valid");
                $(this).removeClass(["focused-input", "focused-input-error"]).addClass("focused-input-valid");
                idHelp.removeClass("error-input").addClass("valid-input").text("Saisie valide");
            } else {
                $(this).parent().removeClass(["valid"]).addClass("error");;
                $(this).removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                idHelp.removeClass("valid-input").addClass("error-input").text("Saisie trop court");
            }
        }
        //pseudo 
        if ($(this).attr('id') == "pseudo") {
            if (inputVal.length > 0 && inputVal.length <= 50) {
                var pseudo = $("#pseudo").val();
                var pseudoSel = $("#pseudo");
                $.ajax({
                    method: "POST",
                    url: "inc/signup.handler.inc.php",
                    data: {
                        pseudo: pseudo
                    },
                    dataType: "JSON",
                    async: false,
                    success: function(data) {
                        if (data == 1) {
                            sessionStorage.setItem("pseudotest", "ko");
                            pseudoSel.parent().removeClass(["valid"]).addClass("error");;
                            pseudoSel.removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                            idHelp.removeClass("valid-input").addClass("error-input").text("Ce pseudo existe déjà.");

                        } else {
                            sessionStorage.setItem("pseudotest", "ok");
                            pseudoSel.parent().removeClass(["error"]).addClass("valid");
                            pseudoSel.removeClass(["focused-input", "focused-input-error"]).addClass("focused-input-valid");
                            idHelp.removeClass("error-input").addClass("valid-input").text("Saisie valide");
                        }
                    },
                    error: function() {
                        //show modal error
                        $('#modal-notif').modal();
                    }
                });

            } else {
                inputSel = $(this);
                $(this).parent().removeClass(["valid"]).addClass("error");;
                $(this).removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                idHelp.removeClass("valid-input").addClass("error-input").text("Saisie invalide");
            }
        }

        // email
        pattern = /^[a-z0-9](\.?[a-z0-9]){5,}@(\.?[a-z0-9]){2,}\.com$/;
        if ($(this).attr('id') == "email") {
            if (pattern.test(inputVal)) {
                if (inputVal.length <= 50 && inputVal.length >= 20) {
                    var email = $("#email").val();
                    var emailSel = $("#email");
                    $.ajax({
                        method: "POST",
                        url: "inc/signup.handler.inc.php",
                        data: {
                            email: email
                        },
                        dataType: "JSON",
                        async: false,
                        success: function(data) {
                            if (data == 1) {
                                sessionStorage.setItem("emailtest", "ko");
                                emailSel.parent().removeClass(["valid"]).addClass("error");;
                                emailSel.removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                                idHelp.removeClass("valid-input").addClass("error-input").text("Cette email existe déjà.");

                            } else {
                                sessionStorage.setItem("emailtest", "ok");
                                emailSel.parent().removeClass(["error"]).addClass("valid");
                                emailSel.removeClass(["focused-input", "focused-input-error"]).addClass("focused-input-valid");
                                idHelp.removeClass("error-input").addClass("valid-input").text("Saisie valide");
                            }
                        },
                        error: function() {
                            //show modal error
                            $('#modal-notif').modal();
                        }
                    });

                } else {
                    inputSel = $(this);
                    $(this).parent().removeClass(["valid"]).addClass("error");;
                    $(this).removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                    idHelp.removeClass("valid-input").addClass("error-input").text("Saisie trop court (entre 20 et 50 caractères)");
                }

            } else {
                inputSel = $(this);
                $(this).parent().removeClass(["valid"]).addClass("error");;
                $(this).removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                idHelp.removeClass("valid-input").addClass("error-input").text("Veuillez renseigner un email valide");
            }

        }
        var pseudo = $("#pseudo").val();
        var sexe = $("#sexe").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var firstName = $("#firstName").val();
        var lastName = $("#lastName").val();


        if (sexe != "" && sessionStorage.getItem("emailtest") == "ok" && sessionStorage.getItem("pseudotest") == "ok" && password.length >= 10 && password.length <= 128 &&
            firstName.length >= 2 && firstName.length <= 50 &&
            lastName.length >= 2 && lastName.length <= 50
        ) {
            $("#subscribe").prop('type', 'submit');
        } else {
            $("#subscribe").prop('type', 'button');
        }
        if ($("#subscribe").attr("type") == "button") {
            // check each input value

            if (($("#pseudo").val() == "")) {
                $("#pseudo").parent().removeClass(["valid"]).addClass("error");;
                $("#pseudo").removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                $("#help-pseudo").removeClass("hidden").addClass("error-input").text("Veuillez renseigner un pseudo valide.");
            }

            if (($("#email").val() == "")) {
                $("#email").parent().removeClass(["valid"]).addClass("error");;
                $("#email").removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                $("#help-email").removeClass("hidden").addClass("error-input").text("Veuillez renseigner un email valide.");
            }

            if (($("#password").val() == "")) {
                $("#password").parent().removeClass(["valid"]).addClass("error");;
                $("#password").removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                $("#help-pass").removeClass("hidden").addClass("error-input").text("Veuillez renseigner un mot de passe.");
            }

            if (($("#firstName").val() == "")) {
                $("#firstName").parent().removeClass(["valid"]).addClass("error");;
                $("#firstName").removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                $("#help-firstname").removeClass("hidden").addClass("error-input").text("Veuillez renseigner votre prénom.");
            }

            if (($("#lastName").val() == "")) {
                $("#lastName").parent().removeClass(["valid"]).addClass("error");;
                $("#lastName").removeClass(["focused-input", "focused-input-valid"]).addClass("focused-input-error");
                $("#help-lastname").removeClass("hidden").addClass("error-input").text("Veuillez renseigner votre nom.");
            }


        }
    });



});