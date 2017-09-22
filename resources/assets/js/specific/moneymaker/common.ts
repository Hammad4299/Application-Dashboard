import {default as global} from '../../globals';

declare var $:any;

class MoneymakerFunctions {
    replaceUrlParams(url: any, btn: any, dataName: string):string {
        let appId = $('#appId').val();
        // let appSlug = $('#appSlug').val();
        //
        // url = url.replace('####', appSlug);
        url = url.replace('###', appId);

        if(dataName.length>0) {
            let userId = $(btn).data(dataName);
            url = url.replace('##', userId);
        }
        return url;
    }
}

let moneymaker = new MoneymakerFunctions();
export default moneymaker;
