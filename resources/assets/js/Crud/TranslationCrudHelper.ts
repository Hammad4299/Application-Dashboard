import FormSubmitter from "../FormSubmitters/FormSubmitter";
import CrudHelper from "./CrudHelper";
import global from "../globals";
import TranslationModalHandler from "../ModalHandler/TranslationModalHandler";
import BaseModalHandler from "../ModalHandler/BaseModalHandler";
declare var $:any;

export default class TranslationCrudHelper extends CrudHelper {
    protected modal:any;
    protected modalDriver:BaseModalHandler;
    protected rowTemplate:string;

    constructor(containers:any){
        super(containers);
        this.modal = $('#translation-add-modal');
        this.modalDriver = new TranslationModalHandler(this.modal);
        this.helperData.listClass = '.js-items';
        this.helperData.deleteClass = '.js-delete-item';
        this.helperData.creationClass = '.js-add-item';
        this.helperData.editClass = '.js-edit-item';
        this.helperData.deletionUrl = global.ajaxUrls.deleteTranslationUrl;

        // TO DO: get rows in page
        this.rowTemplate = $('#translationItemTemplate').html();

        this.init();
        this.hookEvents();
    }

    hookEvents ():void {
        const self = this;
        super.hookEvents();
        this.modalDriver.hookEvents();
        let form = this.modal.find('form');

        form.on('formSubmitted:ajaxformsubmitter', function(e:any){
            if(e.cusData.data.status) {
                form.attr('data-id', e.cusData.data.data.id);
                self.modal.modal('hide');
                self.addData(e.cusData.data.data);
            }
        })
    }

    handleDeletion (clickedElement:any):void {
        const self = this;
        const submitter = new FormSubmitter();
        submitter.setForm(clickedElement.parents('.js-crudable-item'));

        const id = self.getSelectedID(clickedElement);
        const initiatedData = this.getDataByID(id);

        const res = confirm('Are you sure you want to delete this?');
        if (res) {
            $.siteAjax({
                type: 'delete',
                url: self.getDeletionUrl(id),
                success: function (response:any) {
                    submitter.processResponseData(response, function (dd:any) {
                        self.removeData(initiatedData);
                    });
                }
            })
        }
    }

    getDeletionUrl (id:any):string {
        return this.helperData.deletionUrl.replace('##', id);
    }

    getViewToAddReplace (data:any):any {
        let toAdd = $(this.rowTemplate);
        toAdd.attr('data-id', data[this.getIdPropertyName()]);
        toAdd.find('.js-trans-group').text(data.group);
        toAdd.find('.js-trans-item').text(data.item);
        toAdd.find('.js-trans-text').text(data.text);
        toAdd.find('.js-trans-created_at').text(data.created_at);
        return toAdd;
    }
    viewForCreateEdit (data:any):void {
        let self = this;
        this.modalDriver.initView(data, function () {
            self.modalDriver.fillViewFromData();
            self.modal.modal('show');
        });
    }

}