(function ($) {
    $("#inputFile").on('change', function (e) {
        if (e.target.files.length > 0) {
            var fileName = e.target.files[0].name;
            $("#uploadFileName").html(fileName);
        }
    });

    var btnUpload = $("#btnUpload");
    btnUpload.on('click', function () {
        var file = $("#inputFile").val();
        if (!file) {
            toast.show('Please Select Form');
            return false;
        }

        $("#fileForm").ajaxSubmit({
            url: '/forms/upload',
            beforeSubmit: function () {
                $("#btnLoading").show();
                $("#btnText").hide();
                $("#uploadFail").hide();
                $("#uploadSubmission").hide();
                btnUpload.attr('disabled', true)
            },
            success: function (res) {
                if (res.code) {
                    $("#uploadFail").html(res.message).show();
                } else {
                    $("#uploadSubmission").show();
                }
            },
            complete: function (xhr) {
                $("#btnLoading").hide();
                $("#btnText").show();
                btnUpload.attr('disabled', false)
            }
        });
    });
})(jQuery);