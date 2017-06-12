//Requirement. Creation model and override open modal. addViewForData, removeViewForData.   'js-crudable-item' class. Add event for form submition of modal
var CrudHelper = function (containers) {
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

CrudHelper.prototype.init = function () {
    this.helperData.listingElem = this.containers.listing.find(this.helperData.listClass);
}

//Calls setData and callback
CrudHelper.prototype.refreshData = function (callback) {
}

//Calls addData
CrudHelper.prototype.setData = function (data) {
    var self = this;
    self.data = {};
    self.clearListingView();
    data.map(function (item) {
        self.addData(item);
    })
}

//Calls addViewFofData
CrudHelper.prototype.addData = function (data) {
    var self = this;
    self.addReplaceViewForData(data);
    self.data[data[this.getIdPropertyName()]] = data;
}

CrudHelper.prototype.getIdPropertyName = function () {
    return 'id';
}

//Calls removeViewForData
CrudHelper.prototype.removeData = function (data) {
    var self = this;
    self.removeViewForData(data);
    delete self.data[data.id];
}

CrudHelper.prototype.clearListingView = function () {
    this.helperData.listingElem.html('');
}

CrudHelper.prototype.addReplaceViewForData = function (data) {
    var view = this.getViewToAddReplace(data);
    var existing = this.helperData.listingElem.find('.js-crudable-item[data-id=' + data[this.getIdPropertyName()] + ']');
    if (existing.length > 0) {
        existing.replaceWith(view);
    } else {
        this.helperData.listingElem.append(view);
    }
}

CrudHelper.prototype.getViewToAddReplace = function (data) {
}

CrudHelper.prototype.removeViewForData = function (data) {
    this.containers.listing.find('[data-id=' + data[this.getIdPropertyName()] + ']').remove();
}

CrudHelper.prototype.openModal = function (data) {
}

CrudHelper.prototype.getDataByID = function (id) {
    return this.data[id];
}

CrudHelper.prototype.getDeletionUrl = function (id) {
    return this.helperData.deletionUrl;
}

CrudHelper.prototype.getSelectedID = function (clickedElem) {
    return clickedElem.parents('.js-crudable-item').attr('data-id');
}

CrudHelper.prototype.handleDeletion = function (clickedElement) {
    var self = this;
    var submitter = new FormSubmitter();
    submitter.setForm(clickedElement.parents('.js-crudable-item'));

    var id = self.getSelectedID(clickedElement);
    var initiatedData = this.getDataByID(id);

    var res = confirm('Are you sure you want to delete this?');
    if (res) {
        $.siteAjax({
            type: 'delete',
            url: self.getDeletionUrl(id),
            success: function (response) {
                var data = JSON.parse(response);
                submitter.processResponseData(data, function (dd) {
                    self.removeData(initiatedData);
                });
            }
        })
    }
}

CrudHelper.prototype.hookEvents = function () {
    var self = this;
    if (this.containers.edit) {
        this.containers.edit.on('click', self.helperData.editClass, function (e) {
            var id = self.getSelectedID($(this));
            var d = self.getDataByID(id);
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