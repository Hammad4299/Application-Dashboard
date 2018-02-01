let path = require('path');

module.exports = function () {
    return {
        public: '/',
        contentOutput: path.join(__dirname,'public'),
        font: 'fonts',
        images: 'images',
        src: path.join(__dirname,'resources/assets'),
        toCopy: null
    };
}