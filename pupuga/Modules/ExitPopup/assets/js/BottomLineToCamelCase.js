export default class BottomLineToCamelCase {

    constructor(bottomLine, last = false) {
        this.camelCase = '';
        this.last = '';
        let parts = bottomLine.split('_');
        if (parts.length) {
            for (let i in parts) {
                let count = parseInt(i);
                if (count === 0) {
                    this.camelCase += parts[i];
                } else if ((count + 1) < parts.length || last) {
                    this.camelCase += parts[i].charAt(0).toUpperCase() + parts[i].slice(1);
                }
                if ((count + 1) === parts.length) {
                    this.last = parts[i];
                }
            }
        }
    }

    get() {
        return this.camelCase;
    }

    getLast() {
        return this.last;
    }

}