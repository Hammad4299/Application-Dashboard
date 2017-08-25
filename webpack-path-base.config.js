let path = require('path');

module.exports = function () {
    return {
        public: 'http://localhost:8080/base-laravel-5.4/public/',
        contentOutput: path.join(__dirname,'public'),
        font: 'fonts',
        images: 'images',
        src: path.join(__dirname,'resources/assets'),
        toCopy: null
    };
}