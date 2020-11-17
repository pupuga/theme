export default class Points {

    constructor() {
        this.classMenuIsActive = 'is-active';
        this.classMenuPrefix = 'woocommerce-MyAccount-navigation-link';
        this.classFieldsPrefix = 'exit-popup-config__fields-type';

        this.points = popUpConfig.points;
        this.pointName = window.location.hash.split('#').pop();
        this.pointName = (this.pointName === '') ? popUpConfig.points[0] : this.pointName;

        this.loopPointName = null;
        this.loopPointSelector = null;
        this.loopPointObject = null;

        this.fieldsSelector = null;
        this.fieldsObject = null;

        this.setPoints();
    }

    setPoints() {
        if (this.points.length) {
            for (this.loopPointName of this.points) {
                this.setCurrentPointSelector();
                this.setCurrentPointObject();
                this.setLinkStyle();
                this.setFieldsSelector();
                this.setFieldsObject();
                this.setFieldsStyle();
                this.click();
            }
        }
    }

    setCurrentPointSelector() {
        this.loopPointSelector = this.classMenuPrefix + '--' + this.loopPointName;
    }

    setCurrentPointObject() {
        this.loopPointObject = document.querySelector(`.${this.loopPointSelector}`);
    }

    setLinkStyle() {
        if (this.pointName === this.loopPointName) {
            this.loopPointObject.classList.add(this.classMenuIsActive);
        } else {
            this.loopPointObject.classList.remove(this.classMenuIsActive);
        }
    }

    setFieldsSelector() {
        this.fieldsSelector = this.classFieldsPrefix + '--' + this.loopPointName;
    }

    setFieldsObject() {
        this.fieldsObject = document.querySelector(`.${this.fieldsSelector}`);
    }

    setFieldsStyle() {
        if (this.pointName === this.loopPointName) {
            this.fieldsObject.classList.remove('display-none');
        } else {
            this.fieldsObject.classList.add('display-none');
        }
    }

    click() {
        let set = this;
        document.querySelector(`.${this.loopPointSelector} a`).addEventListener('click', function(e) {
            set.pointName = this.dataset.point;
            set.setPoints();
        })
    }

}