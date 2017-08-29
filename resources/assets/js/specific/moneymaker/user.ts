import {default as moneymaker} from './common';

declare var $:any;


$(document).on('click','.js-user-block,.js-user-unblock',function(){
    let url=$('#ajax-urls').data('user-state-url');
    let button=$(this);
    url =moneymaker.replaceUrlParams(url,button,'user-id');
    let state=button.data('state');

    let fD=new FormData();
    fD.append('state',state);

    $.siteAjax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        data: fD,
        success: function (data:any) {
            if ((typeof data) == 'string')
                data = JSON.parse(data);

            if(state==1) {
                button.html('Unblock');
                button.data('state', 2);
                button.removeClass('js-user-block btn-danger');
                button.addClass('js-user-unblock btn-primary');
            }
            else
            {
                button.html('Block');
                button.data('state', 1);
                button.removeClass('js-user-unblock btn-primary');
                button.addClass('js-user-block btn-danger');
            }
        },
    });
});

$(document).on('click','.js-user-delete',function(){
    let url=$('#ajax-urls').data('user-delete-url');
    let button=$(this);
    debugger;

    url =moneymaker.replaceUrlParams(url,button,'user-id');
    $.siteAjax({
        url: url,
        method: 'delete',
        contentType: false,
        success: function (data:any) {
            debugger;

            if ((typeof data) == 'string')
                data = JSON.parse(data);

            button.parents('tr').remove();
        },
    });
});