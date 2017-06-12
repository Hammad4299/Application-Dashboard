import './FormSubmitter'
import FormSubmitter from "./FormSubmitter";

/**
 * Jquery Dependant
 */

let formSubmittersMap = {};
$(document).ready(function () {
    $.siteAjax = function (options) {
        if (!options.headers) {
            options.headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }

        return $.ajax(options);
    };

    const formSubmitters = [
        function () {
            return new FormSubmitter();
        }
    ];

    formSubmitters.map(function (d) {
        let de = d();
        formSubmittersMap[de.type] = d;
    })


    $(document).on('submit', '.js-ajax-form', function (e) {
        e.preventDefault();
        let form = $(this);
        submitFormUsingAjax(form);
        return false;
    })
})

export default function submitFormUsingAjax(jForm) {
    const form = jForm;
    console.log(formSubmittersMap);
    const submitter = formSubmittersMap[form.attr('data-form')]();
    submitter.setForm(form);
    if (submitter.validate()) {
        submitter.submit();
    } else {
        submitter.showErrors(submitter.clientValidationErrors);
    }
}

module.exports = submitFormUsingAjax;