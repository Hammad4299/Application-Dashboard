declare var moment:any;
declare var $:any;

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
    public convertUtcToUserTime (utcdateTime:string, parseFormat:string) : any {
        utcdateTime = moment.utc(utcdateTime, parseFormat).utcOffset(this.getUserUtcOffset());
        return utcdateTime;
    }
    public timestampToLocal(timestamp:number):any {
        return this.convertUtcToUserTime(`${timestamp}`,'X').format(this.dateTimeFormat);
    }
    public userTime():any{
        return moment.utc().utcOffset(this.getUserUtcOffset());
    }
    public utcTime():any{
        return moment.utc();
    }
    public convertLocalToUtc(localdateTime:string, parseFormat:string):any {
        let localdateTime1 = moment(localdateTime, parseFormat);
        let detectedOffset = localdateTime1.utcOffset();
        let userOffset = this.getUserUtcOffset();
        localdateTime = localdateTime1.subtract(userOffset - detectedOffset, 'minutes').utcOffset(this.getUserUtcOffset()).utcOffset(0);
        return localdateTime;
    }

    /**
     * Jquery dependant
     */
    protected static setTimeData (formattedTime:string, attrib:any, elem:any):void {
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
    public updateTimes (container:any):void{
        let self = this;
        container.closest('[data-convert-time]').each(function(){
            let elem = $(this);
            let utcTime = elem.attr('data-convert-time');
            let timeToSet = null;
            if(utcTime.toLowerCase() === 'now'){
                timeToSet = self.userTime();
            }else if(utcTime.toLowerCase() === 'utcnow'){
                timeToSet = self.utcTime();
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
    protected static getParsePattern (elem:any, forChange:boolean):string {
        let parsePattern = elem.attr('data-change-parse-pattern');
        let pattern2 = elem.attr('data-parse-pattern');
    
        if(!parsePattern)
            parsePattern = elem.attr('data-parse-pattern');
    
        return forChange ? parsePattern : pattern2;
    }

    /**
     * Jquery dependant
     */
    protected static getParent (elem:any):any {
        let parent = elem.parent();
        if(elem.attr('data-parent')){
            parent = elem.parents(elem.attr('data-parent'));
        }
        return parent;
    }

    /**
     * Jquery dependant
     */
    public setUserTimeToUtc (elem:any):void {
        let self = this;
        let parent = TimeHelper.getParent(elem);
        let value = elem.val();
        let parsePattern = TimeHelper.getParsePattern(elem,true);
        let linked = null;
    
        if(elem.attr('data-linked')){
            linked = parent.find(elem.attr('data-linked'));
            value += ' ' + linked.val();
            parsePattern += ' ' + TimeHelper.getParsePattern(linked,true);
        }
    
        function setInTarget(time:any, elem:any, parent:any) {
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