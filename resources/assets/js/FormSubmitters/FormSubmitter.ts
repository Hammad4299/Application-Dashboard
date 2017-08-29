/**
 * Created by talha on 4/5/2017.
 */

declare var $:any;

/**
 * Jquery Dependant
 */
export default class FormSubmitter {
    public form:any;
    public type:string;
    protected errorAttr:string;
    protected clientValidationErrors:any;
    constructor(){
        this.form = null;
        this.type = 'ajaxformsubmitter';
        this.errorAttr = 'data-error';
        this.clientValidationErrors = {};
    }
    public setForm(jForm:any):void{
        this.form = jForm;
    }
    public addError(field:string,message:string):void{
        if (!this.clientValidationErrors[field])
            this.clientValidationErrors[field] = [];

        this.clientValidationErrors[field].push(message);
    }
    protected validate():boolean{
        this.clientValidationErrors = {};
        return true;
    }
    protected getData():null|FormData{
        if (this.getMethod() == 'get') {
            return null;
        } else {
            return new FormData(this.form[0]);
        }
    }
    protected getMethod():string{
        return this.form.attr('method');
    }
    protected getUrl():string{
        let method = this.getMethod();
        let url = this.form.attr('action');
        if (method == 'get') {
            return `${url}?${this.form.serialize()}`;
        } else {
            return url;
        }
    }
    protected processSuccessResponse (data:any, callback?:any):void {
        this.processResponseData(data);
        let event = $.Event(`formSubmitted:${this.type}`);
        event.cusData = {
            data: data,
            submitter: this
        };

        $(document).trigger(event);
        this.form.trigger(event);
    }
    public processResponseData (data:any, callback?:any):void {
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
    public showErrors(errors:any):void {
        let self = this;

        for (let field in errors) {
            let container = self.getElement(`[${this.errorAttr}='${field}']`);
            if (errors[field].length > 0) {
                container.removeClass("field-validation-valid").addClass("field-validation-error");
                container.html(errors[field][0]);
            }
        }
    }
    protected getElement (selector:string):any {
        let pref1 = this.form.find(selector);
        let pref2 = this.form.parents('.js-form').find(selector);
        return pref1.length > 0 ? pref1 : pref2
    }
    public resetFormErrors ():void {
        this.getElement(`[${this.errorAttr}]`)
            .addClass("field-validation-valid")
            .removeClass("field-validation-error");
        this.getElement(`[${this.errorAttr}]`).text('');
    }
    public submit(callback?:any):void{
        this.clientValidationErrors = {};
        this.resetFormErrors();
        let self = this;

        $.siteAjax({
            url: this.getUrl(),
            method: this.getMethod(),
            success: function (data:any) {
                if ((typeof data) == 'string')
                    data = JSON.parse(data);

                self.processSuccessResponse(data,callback);
            },
            processData: false,
            contentType: false,
            data: this.getData()
        });
    }
}