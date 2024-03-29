import {
    LastVisitsDetailRequest,
    PiwikHelper, Segment, UserIdRequest
} from "../../../Piwik/ReportingApiHelper";
import global from "../../../globals";
import * as moment from "moment";




/**
 * Created by talha on 9/25/2017.
 */



export class VisitsActivity{
    protected flattenedScreens:FlattenedActionData[];
    protected flattenedEvents:FlattenedActionData[];

    public getVisitScreens(){
        return this.flattenedScreens;
    }

    public getFlattenedEvents(){
        return this.flattenedEvents;
    }

    constructor(visits:any){
        this.processResponse(visits);
    }

    protected processResponse(visits:any){
        this.flattenedEvents = [];
        const self = this;
        this.flattenedScreens = [];
        let timeOnScreens:any = {};
        const remainingScreensApproxAvg:FlattenedActionData[] = [];

        visits.map((visit:any) => {
            let pre:FlattenedActionData = null;
            //A visit has actions
            visit.actionDetails.map((action:any) => {
                let toIns = new FlattenedActionData();
                toIns.visitId = visit.idVisit;
                toIns.visitIp = visit.visitIp;
                toIns.visitorId = visit.visitorId;
                toIns.type = action.type;
                toIns.timestamp = action.timestamp;
                toIns.idpageview = action.idpageview;

                if(toIns.type == 'action'){  //Screen visit
                    toIns.actionName = action.pageTitle;

                    if(pre!=null) { //Set duration of previous visits equal to difference
                        pre.duration = toIns.timestamp - pre.timestamp;
                        //Track number of visits and cumulative duration on screen
                        if(!timeOnScreens[pre.actionName]){
                            timeOnScreens[pre.actionName] = {count: 0,duration: 0};
                        }

                        timeOnScreens[pre.actionName].duration += pre.duration;
                        timeOnScreens[pre.actionName].count++;
                    }

                    pre = toIns;
                    self.flattenedScreens.push(toIns);
                }else if(toIns.type == 'event') {  //Event. Coins or ingots
                    toIns.actionName = action.eventName;
                    toIns.actionPerformed = action.eventAction;
                    toIns.eventValue = action.eventValue;
                    toIns.eventCategory = action.eventCategory;
                    self.flattenedEvents.push(toIns);
                }
            });

            if(pre!=null)
                remainingScreensApproxAvg.push(pre);
        });

        //Sets visit duration of last actions on screen equal to avg duration on that screen during that visit
        remainingScreensApproxAvg.map((d)=>{
            if(timeOnScreens[d.actionName]){
                d.duration = Math.floor(timeOnScreens[d.actionName].duration/timeOnScreens[d.actionName].count);
                timeOnScreens[d.actionName].count++;
                timeOnScreens[d.actionName].duration += d.duration;
            }
        });
    }
}

export class FlattenedActionData{
    public actionName:string;
    public actionPerformed:string;
    public eventCategory:string;
    public idpageview:string;
    public visitId:string;
    public visitIp:string;
    public visitorId:string;
    public type:string;
    public timestamp:number;
    public duration:number;
    protected _eventValue:number;
    public get eventValue():number{
        return this._eventValue ? this._eventValue : null;
    }
    public set eventValue(value:number){
        this._eventValue = value;
    }
    get timestampFormatted():string{
        return global.timeHelper.convertUtcToUserTime(this.timestamp.toString(),'X').format('MMMM DD, YYYY');
    }
    get timestampFormattedWithTime():string{
        return global.timeHelper.convertUtcToUserTime(this.timestamp.toString(),'X').format('MMMM DD, YYYY - hh:mm:ss a');
    }
    get durationFormatted():string{
        return moment.duration(this.duration,'s').humanize();
    }
}


export default class MoneyMakerPiwikHelper extends PiwikHelper{
    protected userIdToVisitorMap:any;
    constructor(){
        super();
        this.userIdToVisitorMap = {};
    }
    protected getVisitor(userId:string, callback:(id:string|null)=>any){
        if(this.userIdToVisitorMap[userId]){
            callback(this.userIdToVisitorMap[userId]);
        }else{
            let self = this;
            let r = new UserIdRequest(this.config);
            let segment = new Segment();
            segment.and('userId','==',userId);
            r.setSegment(segment);
            this.executeRequest(r,function (d:any) {
                if(d.length>0)
                    self.userIdToVisitorMap[userId] = d[0];

                callback(self.userIdToVisitorMap[userId]);
            });
        }
    }

    protected static getVisitorId(visitor:any):string{
        if(visitor)
            return visitor.idvisitor;

        return null;
    }

    public getUserAnalyticDetail(userId:string,startDate:string,endDate:string,callback:(d:VisitsActivity) => any){
        let r = new LastVisitsDetailRequest(this.config);
        let s = new Segment();
        s.and('userId','==',userId);
        r.setSegment(s);
        r.setDateRange(startDate,endDate);
        this.executeRequest(r,function (d:any) {
            callback(new VisitsActivity(d));
        });
    }
}