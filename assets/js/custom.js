$(document).ready(function () {
    (function ($) {
        $.fn.extend({
            donetyping: function (callback, timeout) {
                timeout = timeout || 1e3; // 1 second default timeout
                var timeoutReference,
                        doneTyping = function (el) {
                            if (!timeoutReference)
                                return;
                            timeoutReference = null;
                            callback.call(el);
                        };
                return this.each(function (i, el) {
                    var $el = $(el);
                    // Chrome Fix (Use keyup over keypress to detect backspace)
                    // thank you @palerdot
                    $el.is(':input') && $el.on('keyup keypress paste', function (e) {
                        // This catches the backspace button in chrome, but also prevents
                        // the event from triggering too preemptively. Without this line,
                        // using tab/shift+tab will make the focused element fire the callback.
                        if (e.type == 'keyup' && e.keyCode != 8)
                            return;
                        // Check if timeout has been set. If it has, "reset" the clock and
                        // start over again.
                        if (timeoutReference)
                            clearTimeout(timeoutReference);
                        timeoutReference = setTimeout(function () {
                            // if we made it here, our timeout has elapsed. Fire the
                            // callback
                            doneTyping(el);
                        }, timeout);
                    }).on('blur', function () {
                        // If we can, fire the event since we're leaving the field
                        doneTyping(el);
                    });
                });
            }
        });
    })(jQuery);

    var site_url = $('#site_url').val();


    //resent Verification Email
    $('#resentVerificationEmail').click(function () {

        $.ajax({
            type: "POST",
            url: site_url + "resendVerificationEmail",
            data: {
                'email': $('#emailId').val()
            },
            dataType: 'json',
            beforeSend: function () {
                $(".loader_div").css("display", "block");
            },
            complete: function () {
                $(".loader_div").css("display", "none");
            },
            success: function (msg) {
                //alert(msg);
                if (msg.success == true) {
                    $("#successMsg").addClass("alert-success");
                    $("#successMsg").css("display", "block");
                    $("#successMsg").html(msg.success_msg);
                    setTimeout(
                            function ()
                            {
                                $("#successMsg").css("display", "none");
                            }, 3000);
                    //return false
                } else {
                    $("#successMsg").css("display", "none");
                    $('#emailId').css('border', '1px solid #0f4212');
                    $('#emailNextBtn').removeAttr('disabled');
                }
            }
        });

    });

    $('#step1').click(function () {

        if ($("#step-2").is(":visible") == true) {

            $("#step-1").css("display", "block");
            $(this).addClass("btn-success");
            $(".verfication").css("display", "block");
            $("#step-2").css("display", "none");
            $("#step2").removeClass("btn-success");
            $("#step2").removeClass("invalidMail");
            $("#mailSendBtn").css("display", "none");
            $("#successMsg").css("display", "none");
            $('#emailId').prop('readonly', true);
        }

    });

    $('#step2').click(function (e) {
        var email = $('#emailId').val();
        e.preventDefault();

        if (email == '')
        {
            $('#emailId').css('border', '1px solid #b92c28');
            $("#step-1").css("display", "block");
            $("#step-2").css("display", "none");
            return false;
        } else
        {
        if($(this).hasClass('invalidMail')){
           return false;
        }
            $("#step-1").css("display", "none");
            $(this).addClass("btn-success");
            $("#step1").removeClass("btn-success");
            $("#step-2").css("display", "block");
        }
    });
    
    $(document).on('click', '.vatApplied', function(event)
	{
		if($(this).prop("checked") == true)
		{
            $('#vatText').attr('disabled', 'true');
            $('#vatText').val('');
		}
		else {
			$('#vatText').removeAttr('disabled');
		}
	});

    //chek old Password
    $('#oldPassword').donetyping(function () {
        $.ajax({
            type: "POST",
            url: site_url + "checkOldPassword",
            data: {
                'oldpassword': $(this).val()
            },
            dataType: 'json',
            success: function (msg) {
                //alert(msg);
                if (!msg.success) {
                    //alert('ffff');
                    $('#oldPassword').css('border', '1px solid #b92c28');
                    $('#emailNextBtn').attr('disabled', 'true');
                    $('.form-control-feedback').removeClass('glyphicon glyphicon-ok');
                    $('.form-control-feedback').addClass('glyphicon glyphicon-remove');
                    $('.form-control-feedback').css("color", "red");
                    $('#oldPassword').focus();
                    //return false
                } else {
                    $("#successMsg").css("display", "none");
                    $('.form-control-feedback').removeClass('glyphicon glyphicon-remove');
                    $('.form-control-feedback').addClass('glyphicon glyphicon-ok');
                    $('.form-control-feedback').css("color", "green");
                    $('#oldPassword').css('border', '1px solid green');
                }
            }
        });

    });

    $(document).on('keypress', '.validNumber', function (eve) {
        if (eve.which == 0) {
            return true;
        } else {
            if (eve.which == '.') {
                eve.preventDefault();
            }
            if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57)) {
                if (eve.which != 8)
                {
                    eve.preventDefault();
                }
            }

            $('.validNumber').keyup(function (eve) {
                if ($(this).val().indexOf('.') == 0) {
                    $(this).val($(this).val().substring(1));
                }
            });
        }
    });

});
