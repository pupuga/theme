export default class ImageToBase64 {

    constructor(image) {
        this.image = image;
        this.isBase64 = (this.image.src.search('data:image') === 0);
        this.mimeType = (this.isBase64) ? '' : this._type();
        this.base64 = (this.isBase64) ? this.image.src : this._create();
        this.split = this.base64.replace(/^data:image\//, "").split(';base64,');
    }

    get() {
        return this.base64;
    }

    getSplit() {
        return this.split;
    }

    _type() {
        let ext = this.image.src.split('.').pop();
        switch(ext) {
            case 'jpg':
            case 'jpeg' :
                ext = 'jpeg';
                break;
            case 'svg':
                ext = 'svg+xml';
                break;
        }

        return `image/${ext}`;
    }

    _create() {
        let canvas = document.createElement("canvas");
        canvas.width = this.image.width;
        canvas.height = this.image.height;
        canvas
            .getContext("2d")
            .drawImage(this.image, 0, 0);

        return canvas.toDataURL(this.mimeType);
    }

}