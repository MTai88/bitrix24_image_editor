import 'landing.imageeditor';

export class ImageEditor {
    constructor(image) {
        this.image = image;
    }

    async edit() {
        this.file = await this.openImageEditor({
            image: this.image.src,
            width: this.image.naturalWidth,
            height: this.image.naturalHeight,
        });

        return this.file;
    }

    updateElement() {
        if (this.file) {
            this.image.src = URL.createObjectURL(this.file);
        }
    }

    async openImageEditor(fileVal) {
        const file = BX.Landing.ImageEditor.edit({
            image: fileVal.image,
            dimensions: {
                height: fileVal.height,
                width: fileVal.width,
            }
        });
        file.width = fileVal.width;
        file.height = fileVal.height;

        return file;
    }
}