import AjaxSettings = JQuery.AjaxSettings;
/**
 * Created by talha on 9/27/2017.
 */
declare interface JQueryStatic {
    siteAjax: (settings?:AjaxSettings<any>) => JQuery.jqXHR <any>;
}