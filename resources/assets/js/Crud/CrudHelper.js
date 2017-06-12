//Requirement. Creation model and override open modal. addViewForData, removeViewForData.   'js-crudable-item' class. Add event for form submition of modal
import FormSubmitter from "../FormSubmitters/FormSubmitter";

export default class CrudHelper{
    constructor(containers){
        this.data = {};
        this.containers = containers;

        this.helperData = {
            listingElem: null,
            editClass: null,
            listClass: null,
            deleteClass: null,
            deletionUrl: null,
            creationClass: null
        };
    }
    init(){
        this.helperData.listingElem = this.containers.listing.find(this.helperData.listClass);
    }
    refreshData(callback){
    }
    //Calls addData
    setData(data){
        const self = this;
        self.data = {};
        self.clearListingView();
        data.map((item) => {
            this.addData(item);
        })
    }
    //Calls addViewFofData
    addData (data) {
        const self = this;
        self.addReplaceViewForData(data);
        self.data[data[this.getIdPropertyName()]] = data;
    }
    getIdPropertyName(){
        return 'id';
    }
    //Calls removeViewForData
    removeData (data) {
        const self = this;
        self.removeViewForData(data);
        delete self.data[data.id];
    }
    clearListingView () {
        this.helperData.listingElem.html('');
    }
    addReplaceViewForData (data) {
        const view = this.getViewToAddReplace(data);
        const existing = this.helperData.listingElem.find(`.js-crudable-item[data-id='${data[this.getIdPropertyName()]}']`);
        if (existing.length > 0) {
            existing.replaceWith(view);
        } else {
            this.helperData.listingElem.append(view);
        }
    }
    getViewToAddReplace(data) {
    }
    removeViewForData (data) {
        this.containers.listing.find(`[data-id='${data[this.getIdPropertyName()]}']`).remove();
    }
    openModal (data) {
    }
    getDataByID (id) {
        return this.data[id];
    }
    getDeletionUrl (id) {
        return this.helperData.deletionUrl;
    }
    getSelectedID (clickedElem) {
        return clickedElem.parents('.js-crudable-item').attr('data-id');
    }
    handleDeletion (clickedElement) {
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
                success: function (response) {
                    const data = JSON.parse(response);
                    submitter.processResponseData(data, function (dd) {
                        self.removeData(initiatedData);
                    });
                }
            })
        }
    }
    hookEvents(){
        const self = this;
        if (this.containers.edit) {
            this.containers.edit.on('click', self.helperData.editClass, function (e) {
                const id = self.getSelectedID($(this));
                const d = self.getDataByID(id);
                self.openModal(d);
            });
        }

        if (this.containers.delete) {
            this.containers.delete.on('click', self.helperData.deleteClass, function (e) {
                self.handleDeletion($(this));
            })
        }

        if (this.containers.create) {
            this.containers.create.on('click', self.helperData.creationClass, function () {
                self.openModal();
            })
        }
    }
}

module.exports = CrudHelper;