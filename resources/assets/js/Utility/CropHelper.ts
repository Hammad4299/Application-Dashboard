declare var $:any;
declare var Cropper:any;

export default class CropHelper{
    protected form:any;
    protected initOptions:any;
    protected outputOptions:any;
    protected cropbox:any;

    constructor(initOptions?:any,outputOptions?:any){
        this.initOptions = initOptions;
        this.outputOptions = outputOptions;

        if(!this.initOptions){
            this.initOptions = {};
        }

        if(!this.outputOptions){
            this.outputOptions = {};
        }

        if(this.initOptions.width != undefined && this.initOptions.height != undefined){
            this.initOptions['aspectRatio'] = this.initOptions.width/this.initOptions.height;
        }
        else{
            this.initOptions['aspectRatio'] = this.initOptions.aspectRatio;
        }


        this.initOptions.viewMode = 1;
        this.initOptions.autoCropArea = 1;
        this.initOptions.dragMode = 'move';
        this.initOptions.rotatable = false;
        // Cropper.setDefaults({
        //     aspectRatio: 16/9
        // });
    }

    protected initCropbox(canvas:any):any{
        const self = this;
        this.cropbox = new Cropper(canvas,this.initOptions);
        this.initOptions.ready = function () {
            // self.cropbox.setCropBoxData({
            //     left: 0,
            //     right: 0,
            //     width: self.initOptions.width,
            //     height: self.initOptions.height
            // });
        };



        //hook any events related to scaling and resizing if required
    }

    protected getCroppedOutput():any{
        console.log(this.outputOptions);
        return this.cropbox.getCroppedCanvas(this.outputOptions);
    }

    start(file:any,callback:(canvas:any)=>void){
        const self = this;
        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);
        fileReader.addEventListener('load', function(event){
            const img = new Image();
            img.onload = function () {
                const canvas = $('#cropping-image')[0];
                canvas.width = 500;      // set canvas size big enough for the image
                canvas.height = 500;
                let ctx = canvas.getContext("2d");

                const wrh = img.width / img.height;
                let newWidth = canvas.width;
                let newHeight = newWidth / wrh;
                if (newHeight > canvas.height) {
                    newHeight = canvas.height;
                    newWidth = newHeight * wrh;
                }

                $('#cropper-modal').one('shown.bs.modal',function () {
                    ctx.drawImage(img,0,0,newWidth,newHeight);
                    self.initCropbox(canvas);
                });

                $('#cropper-modal').one('hidden.bs.modal',function () {
                    self.cropbox.destroy();
                });

                $('#cropper-modal').modal('show');

                $('#cropper-modal').off('click','.js-crop-btn')
                    .on('click','.js-crop-btn',function () {
                        callback(self.getCroppedOutput());
                        $('#cropper-modal').modal('hide');
                    });
            };

            img.src = fileReader.result;
        });
    }
}