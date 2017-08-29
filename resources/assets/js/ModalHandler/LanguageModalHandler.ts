import BaseModalHandler from "./BaseModalHandler";

export default class LanguageModalHandler extends BaseModalHandler{
    constructor(container:any){
        super(container);
        this.name = "LanguageModalHandler"
    }

    fillViewFromData ():void {
        var self = this;
        var form = self.container.find('form');
        form.find('[name=locale]').val(self.editableData ? self.editableData.locale : '');
        form.find('[name=name]').val(self.editableData ? self.editableData.name : '');
        form.find('[name=created_at]').val(self.editableData ? self.editableData.created_at : '');

        if(self.editableData){
            let editableLink = form.attr('data-edit-url').replace('##', self.editableData.id);
            form.attr('action', editableLink);
        }else{
            let createLink = form.attr('data-create-url');
            form.attr('action', createLink);
        }
    }
}