import {
    PiwikConfig, PiwikHelper, Segment, UserIdRequest,
    VisitorProfileRequest
} from "../../../Piwik/ReportingApiHelper";
import * as Enumerable from "linq";
/**
 * Created by talha on 9/25/2017.
 */
declare var $:any;

export class VisitsActivity{
    protected flattenedScreens:any;
    protected flattenedEvents:any;

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
        let pre:FlattenedActionData = null;
        visits.map(function (visit:any) {
            visit.actionDetails.map(function (action:any) {
                let toIns = new FlattenedActionData();
                toIns.visitId = visit.idVisit;
                toIns.visitIp = visit.visitIp;
                toIns.visitorId = visit.visitorId;
                toIns.type = action.type;
                toIns.timestamp = action.timestamp;
                toIns.idpageview = action.idpageview;
                if(toIns.type == '4'){
                    toIns.actionName = action.pageTitle;
                    if(pre!=null) {
                        pre.duration = toIns.timestamp - pre.timestamp;
                    }
                    pre = toIns;
                    self.flattenedScreens.push(toIns);
                }else{
                    toIns.actionName = action.eventName;
                    toIns.actionPerformed = action.eventAction;
                    toIns.eventValue = action.eventValue;
                    toIns.eventCategory = action.eventCategory;
                    self.flattenedEvents.push(toIns);
                }
            })
        })
    }
}

export class FlattenedActionData{
    public actionName:string;
    public actionPerformed:string;
    public eventCategory:string;
    public idpageview:string
    public visitId:string;
    public visitIp:string;
    public visitorId:string;
    public type:string;
    public timestamp:number;
    public duration:number;
    public eventValue:number;

    public durationString(){
        return this.duration.toString();
    }



    public getTypeString():string{
        return this.type == '4' ? 'ScreenVisit' : this.type;
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
            segment.and('userId','==','10225');
            r.setSegment(segment);
            this.executeRequest(r,function (d:any) {
                if(d.length>0)
                    self.userIdToVisitorMap[userId] = d[0];

                callback(self.userIdToVisitorMap[userId]);
            });
        }
    }

    protected getVisitorId(visitor:any):string{
        if(visitor)
            return visitor.idvisitor;

        return null;
    }

    public getUserAnalyticDetail(userId:string,startDate:string,endDate:string,callback:(d:VisitsActivity) => any){
        let self = this;
        this.getVisitor(userId, (visitor:any|null) => {
            const visitorId = self.getVisitorId(visitor);
            if(visitorId === null){
                callback(null);
            } else {
                let r = new VisitorProfileRequest(this.config);
                r.setVisitorId(visitorId);
                r.setDateRange(startDate,endDate);
                console.log(r);
                this.executeRequest(r,function (d:any) {
                    callback(new VisitsActivity(d.lastVisits));
                });
            }
        })
    }
}