var FormSubmitter = function () {
    this.jForm = null;
};

FormSubmitter.prototype.getData = function (form) {
    this.jForm = form;
    return new FormData(form[0]);
}

FormSubmitter.prototype.validate = function () {
    
}

FormSubmitter.prototype.processResponse = function (data) {
    window.location.reload();
}