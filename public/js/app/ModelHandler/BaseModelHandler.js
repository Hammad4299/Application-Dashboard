var BaseModelHandler = function (container) {
    this.container = container;
    this.editableData = null;
    this.name = "BaseModelHandler";
};

BaseModelHandler.prototype.initView = function (data,callback) {
    var self = this;    
    var form = self.container.find('form');
    this.setEditableData(data);

    if (callback)
        callback();
}

BaseModelHandler.prototype.setEditableData = function (data) {
    this.editableData = data;
}

BaseModelHandler.prototype.hookEvents = function () {
    var self = this;
    
    self.container.on('click', '.js-submit-form', function () {
        self.submit(self.container.find('form'));
    });
}

BaseModelHandler.prototype.fillViewFromData = function () {
    var self = this;
}

BaseModelHandler.prototype.submit = function (form) {
    form.trigger('submit');
}