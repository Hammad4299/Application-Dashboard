import './FormSubmitter'
import FormSubmitter from "./FormSubmitter";
import AjaxSettings = JQuery.AjaxSettings;
/**
 * Jquery Dependant
 */

let formSubmittersMap:any = {};
$(document).ready(function () {
    $.siteAjax = (settings?:AjaxSettings<any>): JQuery.jqXHR <any>  => {
        if (!settings.headers) {
            settings.headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }

        return $.ajax(settings);
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


    $(document).on('submit', '.js-ajax-form', function (e:any) {
        e.preventDefault();
        let form = $(this);
        submitFormUsingAjax(form);
        return false;
    })
})

export default function submitFormUsingAjax(jForm:any) {
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