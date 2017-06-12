var TimeHelper = function (userTimezone) {
    this.userTimezone = userTimezone;
}

TimeHelper.prototype.getUserUtcOffset = function () {
    var baseOffset = moment().utcOffset();
    if(this.userTimezone){
        baseOffset = parseInt(this.userTimezone)*60;
    }

    return baseOffset;
}

TimeHelper.prototype.convertUtcToUserTime = function(utcdateTime, parseFormat) {
    utcdateTime = moment.utc(utcdateTime, parseFormat).utcOffset(this.getUserUtcOffset());
    return utcdateTime;
}

TimeHelper.prototype.timestampToLocal = function(timestamp){
    return this.convertUtcToUserTime(''+timestamp,'X').format('YYYY-MM-DD hh:mm a');
}

TimeHelper.prototype.userTime = function() {
    return moment.utc().utcOffset(this.getUserUtcOffset());
}

TimeHelper.prototype.utcTime = function() {
    return moment.utc();
}

TimeHelper.prototype.setTimeData = function(formattedTime, attrib, elem) {
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

TimeHelper.prototype.updateTimes = function(container){
    var self = this;
    container.closest('[data-convert-time]').each(function(){
        var elem = $(this);
        var utcTime = elem.attr('data-convert-time');
        var timeToSet = null;
        if(utcTime.toLowerCase() === 'now'){
            timeToSet = self.userTime();
        }else if(utcTime.toLowerCase() === 'utcnow'){
            timeToSet = self.utcTime();
        }else{
            timeToSet = self.convertUtcToUserTime(utcTime,self.getParsePattern(elem,false))
        }

        var formattedTime = timeToSet.format(elem.attr('data-format-pattern'));
        var attrib = elem.attr('data-attr');
        self.setTimeData(formattedTime,attrib,elem);
    });
}

TimeHelper.prototype.getParsePattern = function (elem, forChange) {
    var parsePattern = elem.attr('data-change-parse-pattern');
    var pattern2 = elem.attr('data-parse-pattern');

    if(!parsePattern)
        parsePattern = elem.attr('data-parse-pattern');

    return forChange ? parsePattern : pattern2;
}

TimeHelper.prototype.getParent = function (elem) {
    var parent = elem.parent();
    if(elem.attr('data-parent')){
        parent = elem.parents(elem.attr('data-parent'));
    }
    return parent;
}

TimeHelper.prototype.setUserTimeToUtc = function(elem) {
    var self = this;
    var parent = this.getParent(elem);
    var value = elem.val();
    var parsePattern = this.getParsePattern(elem,true);
    var linked = null;

    if(elem.attr('data-linked')){
        linked = parent.find(elem.attr('data-linked'));
        value += ' ' + linked.val();
        parsePattern += ' ' + this.getParsePattern(linked,true);
    }

    function setInTarget(time, elem, parent) {
        var target = parent.find(elem.attr('data-target'));
        var attrib = target.attr('data-attr');
        var formattedTime = time.format(target.attr('data-format-pattern'));
        self.setTimeData(formattedTime,attrib,target);
    }

    var utcTime = this.convertLocalToUtc(value,parsePattern);
    setInTarget(utcTime,elem,parent);
    if(linked){
        setInTarget(utcTime,linked,parent);
    }
}


TimeHelper.prototype.convertLocalToUtc = function(localdateTime, parseFormat) {
    localdateTime = moment(localdateTime, parseFormat);
    var detectedOffset = localdateTime.utcOffset();
    var userOffset = this.getUserUtcOffset();
    localdateTime = localdateTime.subtract(userOffset - detectedOffset, 'minutes').utcOffset(this.getUserUtcOffset()).utcOffset(0);
    console.log(localdateTime.format('HH:mm:ss'));
    return localdateTime;
}