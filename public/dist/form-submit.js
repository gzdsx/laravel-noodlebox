(function ($) {
    var formFile = null;
    var form = $("#formElectronic");
    var btnSubmit = $("#btnSubmit");
    btnSubmit.on('click', function () {
        var data = {}, flag = true;
        $(form[0].elements).each(function () {
            var v = this.value, n = this.name, t = this.type, el = $(this);
            if (!n) {
                return;
            }

            if (typeof data[n] === 'undefined') {
                data[n] = null;
            }

            if (t === 'radio') {
                if (this.checked) {
                    data[n] = v;
                    flag = true;
                }
            } else if (t === 'checkbox') {
                if (this.checked) {
                    data[n] = v;
                }
            } else if (t === 'select') {
                data[n] = $(this).val();
            } else {
                data[n] = v;
            }

            if (this.required && !data[n]) {
                flag = false;
                el.addClass('is-invalid');
                if (el.siblings('.invalid-feedback').length === 0) {
                    el.parent().append('<div class="invalid-feedback"></div>');
                }
                el.siblings('.invalid-feedback').html('Required').show();
            }

            if ($(this).attr('regexp')) {
                var regExp = new RegExp($(this).attr('regexp'), 'ig');
                if (regExp.test(this.value)) {

                } else {

                }
            }
        });

        // form.find("[required]").each(function (index, el) {
        //     var input = $(el);
        //     if (input.val()) {
        //         input.removeClass('is-invalid');
        //         input.siblings('.invalid-feedback').hide();
        //     } else {
        //         flag = false;
        //         input.addClass('is-invalid');
        //         if (input.siblings('.invalid-feedback').length === 0) {
        //             input.parent().append('<div class="invalid-feedback"></div>');
        //         }
        //         input.siblings('.invalid-feedback').html('Required').show();
        //     }
        // });

        if (form.find('[name=UnitId]').val() === '0') {
            toast.show('Please Select Property');
            return false;
        }

        if (flag) {
            btnSubmit.attr('disabled', true).html('Sending...');
            // var data = formFile ? {file:formFile} : {};
            // form.ajaxSubmit({
            //     data:data,
            // });
            form.submit();
        }
    });

    form.find('[required]').on('blur', function () {
        if ($(this).val()) {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').hide();
        }
    });

    form.find('[type=radio]').on('change', function () {
        var el = $('[name="' + this.name + '"]');
        el.removeClass('is-invalid');
        el.siblings('.invalid-feedback').hide();
    });

    $(".custom-file").find('input[type=file]').on('change', function (e) {
        if (e.target.files.length > 0) {
            $(this).siblings('label').html(e.target.files[0].name);
        }
    });

    /**
     var uploadArea = document.getElementById('uploadArea');
     var btnSelectFile = $("#btnSelectFile");
     var inputFile = $("#inputFile");
     var inputAttachment = $("#inputAttachment");

     btnSelectFile.on('click', function () {
        inputFile.click();
    });

     inputFile.on('change', function (e) {
        //console.log(e.target.files);
        if (e.target.files.length > 0) {
            var formFile = e.target.files[0];
            $("#attachName").html(formFile.name);
            $("#inputAttachment").val(formFile.name);
        }
    });

     if (uploadArea) {
        uploadArea.ondrop = function (e) {
            e.preventDefault();
            var files = e.dataTransfer.files;
            if (files.length > 0) {
                formFile = files[0];
                $("#attachName").html(formFile.name);
                $("#inputAttachment").val(formFile.name);
            }
        }

        uploadArea.ondragover = function (e) {
            e.preventDefault();
        }

        uploadArea.ondragleave = function (e) {
            e.preventDefault();
        }
    }
     */
})(jQuery);