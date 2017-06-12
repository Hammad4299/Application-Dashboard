$(document).ready(function () {
    $.siteAjax = function (options) {
        if (!options.headers) {
            options.headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }

        return $.ajax(options);
    };

    var formSubmitters = [
        function () { return new FormSubmitter(); }
    ]
    var formSubmittersMap = {};
    formSubmitters.map(function (d) {
        var de = d();
        formSubmittersMap[de.type] = d;
    })


    $(document).on('submit', '.js-ajax-form', function (e) {
        e.preventDefault();
        var form = $(this);
        submitFormUsingAjax(form);
        return false;
    })
})

function submitFormUsingAjax(jForm) {
    var form = jForm;
    var submitter = formSubmittersMap[form.attr('data-form')]();
    submitter.setForm(form);
    if (submitter.validate()) {
        submitter.submit();
    } else {
        submitter.showErrors(submitter.clientValidationErrors);
    }
}