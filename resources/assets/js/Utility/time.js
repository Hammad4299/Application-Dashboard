export default class TimeHelper{
    constructor(userTimezone){
        this.userTimezone = userTimezone;
        this.dateTimeFormat = 'YYYY-MM-DD hh:mm a';
    }
    getUserUtcOffset (){
        let baseOffset = moment().utcOffset();
        if(this.userTimezone){
            baseOffset = parseInt(this.userTimezone)*60;
        }

        return baseOffset;
    }
    convertUtcToUserTime (utcdateTime, parseFormat) {
        utcdateTime = moment.utc(utcdateTime, parseFormat).utcOffset(this.getUserUtcOffset());
        return utcdateTime;
    }
    timestampToLocal (timestamp){
        return this.convertUtcToUserTime(`${timestamp}`,'X').format(this.dateTimeFormat);
    }
    userTime () {
        return moment.utc().utcOffset(this.getUserUtcOffset());
    }
    utcTime (){
        return moment.utc();
    }
    convertLocalToUtc (localdateTime, parseFormat) {
        localdateTime = moment(localdateTime, parseFormat);
        let detectedOffset = localdateTime.utcOffset();
        let userOffset = this.getUserUtcOffset();
        localdateTime = localdateTime.subtract(userOffset - detectedOffset, 'minutes').utcOffset(this.getUserUtcOffset()).utcOffset(0);
        return localdateTime;
    }

    /**
     * Jquery dependant
     */
    static setTimeData (formattedTime, attrib, elem) {
        if(attrib!=null && attrib!=null && attrib.length>0){
            if(attrib == 'value'){
                rrr = elem;
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
    updateTimes (container){
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
    static getParsePattern (elem, forChange) {
        let parsePattern = elem.attr('data-change-parse-pattern');
        let pattern2 = elem.attr('data-parse-pattern');
    
        if(!parsePattern)
            parsePattern = elem.attr('data-parse-pattern');
    
        return forChange ? parsePattern : pattern2;
    }

    /**
     * Jquery dependant
     */
    static getParent (elem) {
        let parent = elem.parent();
        if(elem.attr('data-parent')){
            parent = elem.parents(elem.attr('data-parent'));
        }
        return parent;
    }

    /**
     * Jquery dependant
     */
    setUserTimeToUtc (elem) {
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
    
        function setInTarget(time, elem, parent) {
            let target = parent.find(elem.attr('data-target'));
            let attrib = target.attr('data-attr');
            let formattedTime = time.format(target.attr('data-format-pattern'));
            self.setTimeData(formattedTime,attrib,target);
        }
    
        let utcTime = this.convertLocalToUtc(value,parsePattern);
        setInTarget(utcTime,elem,parent);
        if(linked){
            setInTarget(utcTime,linked,parent);
        }
    }
}

module.exports = TimeHelper;