abstract class BaseModalHandler{
    container:any;
    editableData:any;
    name:string;
    constructor(container:any){
        this.container = container;
        this.editableData = null;
        this.name = "BaseModelHandler";
    }
    initView(data:any|null|undefined,callback?:any):void{
        var self = this;
        var form = self.container.find('form');
        this.setEditableData(data);

        if (callback)
            callback();
    }
    protected setEditableData (data:any) {
        this.editableData = data;
    }
    public hookEvents () {
        var self = this;

        self.container.on('click', '.js-submit-form', function () {
            self.submit (self.container.find('form'));
        });
    }
    abstract fillViewFromData():any;
    protected submit(form:any) {
        form.trigger('submit');
    }
}

export default BaseModalHandler;