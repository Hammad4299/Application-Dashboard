import moment = require("moment");
import {Moment} from "moment";

export default class TimeHelper{
    private userTimezone:string|null|undefined;
    private dateTimeFormat:string;

    constructor(userTimezone?:string|null|undefined){
        this.setTimezone(userTimezone);
        this.dateTimeFormat = 'YYYY-MM-DD hh:mm a';
    }
    public setTimezone(userTimezone?:string|null|undefined){
        this.userTimezone = userTimezone;
    }
    public getUserUtcOffset():number {
        let baseOffset = moment().utcOffset();

        if(this.userTimezone){
            baseOffset = parseInt(this.userTimezone)*60;
        }

        return baseOffset;
    }
    public convertUtcToUserTime (utcdateTime:string, parseFormat:string) : Moment {
        return moment.utc(utcdateTime, parseFormat).utcOffset(this.getUserUtcOffset());
    }
    public timestampToLocal(timestamp:number):string {
        return this.convertUtcToUserTime(`${timestamp}`,'X').format(this.dateTimeFormat);
    }
    public userTime():any{
        return moment.utc().utcOffset(this.getUserUtcOffset());
    }
    public static utcTime():any{
        return moment.utc();
    }

    public static convertTimeToDifferentZone(timestring:string, parseFormat:string, currentOffset:number,desiredOffset:number):Moment {
        let localdateTime1 = moment(timestring, parseFormat);
        return localdateTime1.subtract(desiredOffset - currentOffset, 'minutes').utcOffset(desiredOffset);

    }

    public convertLocalToUtc(localdateTime:string, parseFormat:string):Moment {
        let localdateTime1 = moment(localdateTime, parseFormat);
        return TimeHelper.convertTimeToDifferentZone(localdateTime,parseFormat, localdateTime1.utcOffset(), this.getUserUtcOffset()).utcOffset(0);
    }

    /**
     * Jquery dependant
     */
    protected static setTimeData (formattedTime:string, attrib:string, elem:JQuery):void {
        if(attrib && attrib.length>0){
            if(attrib == 'value'){
                elem.val(formattedTime);
            }
            else
                elem.attr(attrib,formattedTime);
        }else{
            elem.text(formattedTime);
        }
    }

    /**
     * Jquery dependant
     */
    public updateTimes (container:JQuery):void{
        let self = this;
        container.closest('[data-convert-time]').each(function(){
            let elem = $(this);
            let utcTime = elem.attr('data-convert-time');
            let timeToSet = null;
            if(utcTime.toLowerCase() === 'now'){
                timeToSet = self.userTime();
            }else if(utcTime.toLowerCase() === 'utcnow'){
                timeToSet = TimeHelper.utcTime();
            }else{
                timeToSet = self.convertUtcToUserTime(utcTime,TimeHelper.getParsePattern(elem,false))
            }

            let formattedTime = timeToSet.format(elem.attr('data-format-pattern'));
            let attrib = elem.attr('data-attr');
            TimeHelper.setTimeData(formattedTime,attrib,elem);
        });
    }

    /**
     * Jquery dependant
     */
    protected static getParsePattern (elem:JQuery, forChange:boolean):string {
        let parsePattern = elem.attr('data-change-parse-pattern');
        let pattern2 = elem.attr('data-parse-pattern');

        if(!parsePattern)
            parsePattern = elem.attr('data-parse-pattern');

        return forChange ? parsePattern : pattern2;
    }

    /**
     * Jquery dependant
     */
    protected static getParent (elem:JQuery):any {
        let parent = elem.parent();
        if(elem.attr('data-parent')){
            parent = elem.parents(elem.attr('data-parent'));
        }
        return parent;
    }

    /**
     * Jquery dependant
     */
    public setUserTimeToUtc (elem:JQuery):void {
        let parent = TimeHelper.getParent(elem);
        let value:string = <string>elem.val();
        let parsePattern = TimeHelper.getParsePattern(elem,true);
        let linked = null;

        if(elem.attr('data-linked')){
            linked = parent.find(elem.attr('data-linked'));
            value += ' ' + linked.val();
            parsePattern += ' ' + TimeHelper.getParsePattern(linked,true);
        }


        function setInTarget(time:Moment, elem:JQuery, parent:JQuery) {
            let target = parent.find(elem.attr('data-target'));
            let attrib = target.attr('data-attr');
            let formattedTime = time.format(target.attr('data-format-pattern'));
            TimeHelper.setTimeData(formattedTime,attrib,target);
        }

        let utcTime = this.convertLocalToUtc(value,parsePattern);
        setInTarget(utcTime,elem,parent);
        if(linked){
            setInTarget(utcTime,linked,parent);
        }
    }
}