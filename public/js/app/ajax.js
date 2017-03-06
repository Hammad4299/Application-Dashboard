var formSubmitter = {
    'simpleform': new FormSubmitter()
}

$(document).ready(function () {
    $(document).on('submit','.js-ajax-form',function (e) {
        e.preventDefault();
        submitFormUsingAjax($(this));
        return false;
    })
});

function submitFormUsingAjax(jForm) {
    var submitter = formSubmitter[jForm.attr('data-form')];
    var data = submitter.getData(jForm);
    var valid = submitter.velidate();
    if(valid){
        $.siteAjax({
            url: jForm.attr('action'),
            type: jForm.attr('method'),
            contentType: false,
            data: data,
            processData: false,
            success: function (data) {
                submitter.processResponse(data);
            }
        });
    }
}