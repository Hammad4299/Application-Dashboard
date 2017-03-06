function convertLocalToUtc(localdateTime, parseFormat) {
    localdateTime = moment(localdateTime, parseFormat);
    var detectedOffset = localdateTime.utcOffset();
    var userOffset = currentUserTime().utcOffset();
    localdateTime = localdateTime.subtract(userUtc - detectedUtc, 'minutes').utcOffset(getUserUtcOffset()).utcOffset(0);
    return localdateTime;
}

function convertUtcToUserTime(utcdateTime, parseFormat) {
    utcdateTime = moment.utc(utcdateTime, parseFormat).utcOffset(getUserUtcOffset());
    return utcdateTime;
}

function timestampToLocal(timestamp){
    return convertUtcToUserTime(''+timestamp,'X').format('YYYY-MM-DD hh:mm a');
}

function userTime() {
    return moment.utc().utcOffset(getUserUtcOffset());
}

 function utcTime() {
     return moment.utc();
 }

 function getUserUtcOffset() {
     var baseOffset = moment().utcOffset();
     if(userInfo.timezone){
         baseOffset = parseInt(userInfo.timezone)*60;
     }
     return baseOffset;
 }

 function updateTimes(container){
     container.find('[data-convert-time]').each(function(){
         var elem = $(this);
         var utcTime = elem.attr('data-convert-time');
         var localTime = convertUtcToUserTime(utcTime,elem.attr('data-parse-pattern'));
         elem.text(localTime.format(elem.attr('data-format-pattern')));
     });
 }