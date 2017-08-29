import TranslationCrudHelper from "../Crud/TranslationCrudHelper"
declare var $:any;

$(document).ready(function () {
    let translationsData = $('#translations-data').val();
    let translationsContainer = new TranslationCrudHelper({
        listing: $('#translationsDataContainer'),
        edit: $('#translationsDataContainer'),
        deletion: $('#translationsDataContainer'),
        create: $('#translationsDataContainer'),
    });

    translationsContainer.setData(JSON.parse(translationsData).data);
});
