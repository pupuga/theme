export default class FieldsImage {

    constructor() {
        this.selector = 'custom-image';
        this.button = `${this.selector}__download-button`;
        this.input = `${this.selector}__input`;
        this.image = `${this.selector}__preview-image`;
        this.eventClick();
    }

    eventClick() {
        let self = this;

        let $images = document.querySelectorAll(`.${self.image}`);
        for (let $image of $images) {
            $image.addEventListener('click', function(e) {
                this.closest(`.${self.selector}`).querySelector(`.${self.input}`).click();
            });
        }

        let $inputs = document.querySelectorAll(`.${self.input}`);
        if ($inputs.length) {
            for (let $input of $inputs) {
                $input.addEventListener('change', function(e) {
                    self.loadFile(this);
                });
            }
        }
    }

    loadFile($input) {
        let self = this;
        let $preview = $input.closest(`.${self.selector}`).querySelector(`.${self.image} img`);
        let reader = new FileReader();
        reader.readAsDataURL($input.files[0]);
        reader.onloadend = function () {
            $preview.src = reader.result;
        }
    }

}