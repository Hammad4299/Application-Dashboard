import {default as global} from '../../globals';
import {default as moneymaker} from './common';

declare var $:any;

$(document).on('click','.js-transaction-accept,.js-transaction-reject',function(){
    let url=$('#ajax-urls').data('transaction-status-url');
    let button=$(this);
    url = moneymaker.replaceUrlParams(url,button,'trans-id');

    let status=button.data('status');
    let fD=new FormData();
    fD.append('status',status);

    $.siteAjax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        data: fD,
        success: function (data:any) {
            if ((typeof data) == 'string')
                data = JSON.parse(data);

            let td=button.parent();
            td.html('<span class="text-center status-text" >Accepted</span>');
            if(status===3)
            {
                td.find('span').text('Rejected');
            }
        },
    });
});