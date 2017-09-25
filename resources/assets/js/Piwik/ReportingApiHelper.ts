
import global from "../globals";
import TimeHelper from "../Utility/time";
/**
 * Created by talha on 9/25/2017.
 */
declare var $:any;


export enum DatePeriod{
    Range = 'range',
    Year = 'year',
    Month = 'month',
    Week = 'week',
    Day = 'day'
}

export class Segment{
    protected data:any;
    constructor(){
        this.data = [];
    }
    public and(name:string,operator:string,value:string){
        this.data.push({
            name: name,
            operator: operator,
            condition:';',
            value: value
        });
    }
    public or(name:string,operator:string,value:string){
        this.data.push({
            name: name,
            operator: operator,
            condition:',',
            value: value
        });
    }
    public build():string{
        let first = true;
        let str = '';
        this.data.map(function (part:any) {
            if(!first)
                str += part.condition;
            str += `${part.name}${part.operator}${part.value}`;
            first = false;
        });
        return str;
    }
}

export class PiwikConfig{
    protected siteId:string;
    protected authToken:string;
    protected baseUrl:string;
    protected timeOffset:number;
    constructor(){
        this.siteId = $('#piwik-info').attr('data-site-id');
        this.authToken = $('#piwik-info').attr('data-auth-token');
        this.baseUrl = $('#piwik-info').attr('data-base-url');
        this.timeOffset = 0;
    }
    public getBaseUrl(){
        return this.baseUrl;
    }
    public getAuthToken(){
        return this.authToken;
    }
    public getTimeOffset(){
        return this.timeOffset;
    }
    public getSiteId(){
        return this.siteId;
    }
}

export abstract class ReportingRequest{
    protected data:any;
    protected config:PiwikConfig;
    public setSegment(s:Segment){
        this.data.segment = s.build();
    }
    public setDateRange(userStartDate:string,userEndDate:string){
        this.data.period = DatePeriod.Range;
        const userOffset = global.timeHelper.getUserUtcOffset();
        const start = TimeHelper.convertTimeToDifferentZone(userStartDate + ' 00:00:00','YYYY-MM-DD HH:mm:ss',userOffset,this.config.getTimeOffset());
        const end = TimeHelper.convertTimeToDifferentZone(userEndDate + ' 23:59:59','YYYY-MM-DD HH:mm:ss',userOffset,this.config.getTimeOffset());
        this.data.date = `${start.format('YYYY-MM-DD')},${end.format('YYYY-MM-DD')}`;
    }
    public setDate(date:string,period:DatePeriod){
        this.data.period = period;
        const userOffset = global.timeHelper.getUserUtcOffset();
        this.data.date = TimeHelper.convertTimeToDifferentZone(date + ' 12:00:00','YYYY-MM-DD HH:mm:ss',userOffset,this.config.getTimeOffset()).format('YYYY-MM-DD');
    }
    constructor(config:PiwikConfig,data?:any){
        this.config = config;
        this.data = {};
        this.setDate(global.timeHelper.userTime().format('YYYY-MM-DD'),DatePeriod.Year);
        if(data){
            for(let i in data){
                if(data.hasOwnProperty(i))
                    this.data[i] = data[i];
            }
        }

    }
    abstract getMethodName():string;
    public getData(){
        return this.data;
    }
}

export class UserIdRequest extends ReportingRequest{
    getMethodName(): string {
        return 'UserId.getUsers';
    }
}

export class VisitorProfileRequest extends ReportingRequest{
    public setVisitorId(id:string){
        this.data.visitorId = id;
    }
    getMethodName(): string {
        return 'Live.getVisitorProfile';
    }
}

export class PiwikHelper{
    public config:PiwikConfig;
    constructor(){
        this.config = new PiwikConfig();
    }
    public executeRequest(request:ReportingRequest,callback:any){
        let d = request.getData();
        d.method = request.getMethodName();
        d.module = 'API';
        d.idSite = this.config.getSiteId();
        d.token_auth = this.config.getAuthToken();
        d.format = 'json';
        $.ajax({
            type: 'get',
            data: d,
            url: this.config.getBaseUrl(),
            success: function (da:any) {
                callback(da);
            }
        });
    }
}