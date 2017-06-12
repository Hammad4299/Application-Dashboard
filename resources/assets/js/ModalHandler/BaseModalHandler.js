export default class BaseModalHandler{
    constructor(container){
        this.container = container;
        this.editableData = null;
        this.name = "BaseModelHandler";
    }
    initView(data,callback){
        var self = this;
        var form = self.container.find('form');
        this.setEditableData(data);

        if (callback)
            callback();
    }
    setEditableData (data) {
        this.editableData = data;
    }
    hookEvents () {
        var self = this;

        self.container.on('click', '.js-submit-form', function () {
            self.submit(self.container.find('form'));
        });
    }
    fillViewFromData () {
        var self = this;
    }
    submit (form) {
        form.trigger('submit');
    }
}

module.exports = BaseModalHandler;