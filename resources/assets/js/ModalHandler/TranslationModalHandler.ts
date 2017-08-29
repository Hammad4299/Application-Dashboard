import BaseModalHandler from "./BaseModalHandler";
declare var $:any;
export default class TranslationModalHandler extends BaseModalHandler{
    constructor(container:any){
        super(container);
        this.name = "TranslationModalHandler"
    }

    fillViewFromData ():void {
        let self = this;
        let form = self.container.find('form');
        form.find('[name=group]').prop('disabled',!!self.editableData);
        form.find('[name=item]').prop('disabled', !!self.editableData);
        form.find('[name=locale]').val($(document).find('[name=locale]').val());
        form.find('[name=group]').val(self.editableData ? self.editableData.group : '');
        form.find('[name=item]').val(self.editableData ? self.editableData.item : '');
        form.find('[name=text]').val(self.editableData ? self.editableData.text : '');

        if(self.editableData){
            let editableLink = form.attr('data-edit-url').replace('##', self.editableData.id);
            form.attr('action', editableLink);
        }else{
            let createLink = form.attr('data-create-url');
            form.attr('action', createLink);
        }
    }
}