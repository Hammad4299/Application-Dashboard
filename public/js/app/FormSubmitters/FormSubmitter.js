/**
 * Created by talha on 4/5/2017.
 */
var FormSubmitter = function () {
    this.form = null;
    this.type = 'ajaxformsubmitter';
    this.clientValidationErrors = {};
}

FormSubmitter.prototype.setForm = function (jForm) {
    this.form = jForm;
}

FormSubmitter.prototype.addError = function (field, message) {
    if (!this.clientValidationErrors[field])
        this.clientValidationErrors[field] = [];

    this.clientValidationErrors[field].push(message);
}

FormSubmitter.prototype.validate = function () {
    this.clientValidationErrors = {};
    return this.form.valid();
}

FormSubmitter.prototype.getData = function () {
    if (this.getMethod() == 'get') {
        return null;
    } else {
        return new FormData(this.form[0]);
    }
}

FormSubmitter.prototype.getMethod = function () {
    return this.form.attr('method');
}

FormSubmitter.prototype.getUrl = function () {
    var method = this.getMethod();
    var url = this.form.attr('action');
    if (method == 'get') {
        return url + '?' + this.form.serialize();
    } else {
        return url;
    }
}

FormSubmitter.prototype.processSuccessResponse = function (data, callback) {
    this.processResponseData(data);
    var event = $.Event('formSubmitted:' + this.type);
    event.cusData = {
        data: data,
        submitter: this
    };
    $(document).trigger(event);
}

FormSubmitter.prototype.processResponseData = function (data, callback) {
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

FormSubmitter.prototype.showErrors = function (errors) {
    var self = this;

    for (var field in errors) {
        var container = self.getElement("[data-valmsg-for='" + field + "']");
        if (errors[field].length > 0) {
            container.removeClass("field-validation-valid").addClass("field-validation-error");
            container.html(errors[field][0]);
        }
    }
}

FormSubmitter.prototype.getElement = function (selector) {
    var pref1 = this.form.find(selector);
    var pref2 = this.form.parents('.js-form').find(selector);
    return pref1.length > 0 ? pref1 : pref2
}

FormSubmitter.prototype.resetFormErrors = function () {
    this.getElement('[data-valmsg-for]')
        .addClass("field-validation-valid")
        .removeClass("field-validation-error");
    this.getElement('[data-valmsg-for]').text('');
}

FormSubmitter.prototype.submit = function () {
    this.clientValidationErrors = {};
    this.resetFormErrors();
    var self = this;

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