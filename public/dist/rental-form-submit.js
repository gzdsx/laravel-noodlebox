jQuery(function ($) {
    var unitForm = $("#unitForm");
    var btnSubmit = $("#btnSubmit");
    btnSubmit.on('click', function () {
        var flag = true;
        $("[required]").each(function (index, el) {
            var input = $(el);
            if (input.val()) {
                input.removeClass('is-invalid');
                input.siblings('.invalid-feedback').hide();
            } else {
                flag = false;
                input.addClass('is-invalid');
                if (input.siblings('.invalid-feedback').length === 0) {
                    input.parent().append('<div class="invalid-feedback"></div>');
                }
                input.siblings('.invalid-feedback').html('Required').show();
            }
        });

        if (flag) {
            unitForm.submit();
            // unitForm.ajaxForm({
            //     beforeSubmit: function () {
            //         btnSubmit.attr('disabled', true).html('Sending');
            //     },
            //     success: function () {
            //
            //     },
            //     complete: function () {
            //         btnSubmit.attr('disabled', false).html('Submit');
            //     }
            // });
        }
    });
});