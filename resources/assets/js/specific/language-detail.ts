import LanguageCrudHelper from "../Crud/LanguageCrudHelper"
declare var $:any;

$(document).ready(function () {
    let languagesData = $('#languages-data').val();
    let languagesContainer = new LanguageCrudHelper({
        listing: $('#languagesDataContainer'),
        edit: $('#languagesDataContainer'),
        deletion: $('#languagesDataContainer'),
        create: $('#languagesDataContainer'),
    });
    languagesContainer.setData(JSON.parse(languagesData).data);
});
