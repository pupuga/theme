export default class Message {

    constructor(parentObject) {
        this._parentObject = parentObject;
        this._class = 'pupuga-message';
        this._messageType = `${this._class}--info`;
        this._messageVisible = `${this._class}--enable`
        this._content = '';
        this._visibleTime = 5000;
    }

    setContent(content) {
        this._content = content;

        return this;
    }

    setInfo() {
        this.setMessageType('info');

        return this;
    }

    setUrgent() {
        this.setMessageType('urgent');

        return this;
    }

    setError() {
        this.setMessageType('error');

        return this;
    }

    setMessageType(type) {
        this._messageType = `${this._class}--${type}`;

        return this;
    }

    setEnable() {
        this.setVisible('enable');

        return this;
    }

    setDisable() {
        this.setVisible('disable');

        return this;
    }

    setVisible(visible) {
        this._messageVisible = `${this._class}--${visible}`;
        let messageObject = this._parentObject.querySelector(`.${this._class}`);
        if (messageObject !== null) {
            messageObject.classList.add(this._messageVisible);
        }

        return this;
    }

    add(remove = true) {
        let self = this;
        this._parentObject.insertAdjacentHTML('beforeend', this._setTemplate());
        if (remove) {
            setTimeout(function() {
                self.setDisable();
                setTimeout(function() {self.remove()}, 1100);
            }, self._visibleTime);
        }
    }

    remove() {
        this._parentObject.querySelector(`.${this._class}`).remove();
    }

    _setTemplate() {
         return `<div class="${this._class} ${this._messageType} ${this._messageVisible}" data-content="${this._content}"></div>`;
    }
}