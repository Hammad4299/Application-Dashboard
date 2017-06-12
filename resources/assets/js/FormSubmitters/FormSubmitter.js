/**
 * Created by talha on 4/5/2017.
 */
/**
 * Jquery Dependant
 */
export default class FormSubmitter {
    constructor(){
        this.form = null;
        this.type = 'ajaxformsubmitter';
        this.errorAttr = 'data-error';
        this.clientValidationErrors = {};
    }
    setForm(jForm){
        this.form = jForm;
    }
    addError(field,message){
        if (!this.clientValidationErrors[field])
            this.clientValidationErrors[field] = [];

        this.clientValidationErrors[field].push(message);
    }
    validate(){
        this.clientValidationErrors = {};
        return true;
    }
    getData(){
        if (this.getMethod() == 'get') {
            return null;
        } else {
            return new FormData(this.form[0]);
        }
    }
    getMethod(){
        return this.form.attr('method');
    }
    getUrl(){
        let method = this.getMethod();
        let url = this.form.attr('action');
        if (method == 'get') {
            return `${url}?${this.form.serialize()}`;
        } else {
            return url;
        }
    }
    processSuccessResponse (data, callback) {
        this.processResponseData(data);
        let event = $.Event(`formSubmitted:${this.type}`);
        event.cusData = {
            data: data,
            submitter: this
        };

        $(document).trigger(event);
        this.form.trigger(event);
    }
    processResponseData (data, callback) {
        if (data.status) {
            if (callback)
                callback(data);

            if (data.reload) {
                window.location.reload();
            }
            else if (data.redirectUrl) {
                window.location.href = data.redirectUrl;
            }
        } else {
            this.showErrors(data.errors);
        }
        if (data.message && data.message.length > 0) {
            alert(data.Message);
        }
    }
    showErrors (errors) {
        let self = this;

        for (let field in errors) {
            let container = self.getElement(`[${this.errorAttr}='${field}']`);
            if (errors[field].length > 0) {
                container.removeClass("field-validation-valid").addClass("field-validation-error");
                container.html(errors[field][0]);
            }
        }
    }
    getElement (selector) {
        let pref1 = this.form.find(selector);
        let pref2 = this.form.parents('.js-form').find(selector);
        return pref1.length > 0 ? pref1 : pref2
    }
    resetFormErrors () {
        this.getElement(`[${this.errorAttr}]`)
            .addClass("field-validation-valid")
            .removeClass("field-validation-error");
        this.getElement(`[${this.errorAttr}]`).text('');
    }
    submit (){
        this.clientValidationErrors = {};
        this.resetFormErrors();
        let self = this;

        $.siteAjax({
            url: this.getUrl(),
            method: this.getMethod(),
            success: function (data) {
                if ((typeof data) == 'string')
                    data = JSON.parse(data);
                self.processSuccessResponse(data);
            },
            processData: false,
            contentType: false,
            data: this.getData()
        });
    }
}

module.exports = FormSubmitter;