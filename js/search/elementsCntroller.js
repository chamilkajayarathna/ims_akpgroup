//// JavaScript Document
$(document).ready(function () {
    setTimeout(function () {
        $('#message').fadeOut('fast');
    }, 4000);

    $('#ddlMachine').change(function () {
        var val = $('#ddlMachine option:selected').val();
        var dataString = 'ddlID=' + val;
        $.ajax({
            type: "POST",
            url: "ajaxGetSerDetails.php",
            data: dataString,
            success: function (html)
            {
                $("#get_service").html(html);
            }
        });
    })
});
