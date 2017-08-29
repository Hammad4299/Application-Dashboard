import TimeHelper from './Utility/time'

class Globals{
    userInfo:any;
    ajaxUrls:any;
    timeHelper:TimeHelper;
    constructor(){
        this.timeHelper = null;
    }
}

let global = new Globals();
export default global;

