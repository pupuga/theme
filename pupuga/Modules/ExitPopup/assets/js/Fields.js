export default class Fields {

    constructor(messageObject) {
        this._messageObject = messageObject;
        this._errorFields = [];
        this._message = '';
    }

    checkRequiredFields(fields) {
        let self = this;
        this._errorFields = [];
        this._message = '';
        for(let field of fields) {
            if ( (!self._checkRequired(field) || (field.name === 'domain' && !self._checkDomain(field))) && field.type !== 'file') {
                this._errorFields.push(field);
            }
        }

        if(this._errorFields.length) {
            window.scrollTo(0, this._errorFields[0].parentNode.offsetTop);
        }

        return this._errorFields.length > 0;
    }

    setEvents(fields) {
        for(let field of fields) {
            let method = '_' + field.type;
            if(method in this) {
                this[method](field);
            }
        }
    }

    _error(object, set = true, message = '') {
        if (set) {
            object.classList.add('field-error');
            if (message) {
                this._messageObject
                    .setEnable()
                    .setError()
                    .setContent(message)
                    .add();
            }
        } else {
            object.classList.remove('field-error');
        }
    }

    _checkRequired(object) {
        return !(object.required && object.value === '');
    }

    _checkDomain(object) {
        return /(http(s?)):\/\//i.test(object.value);
    }

    _text(field) {
        let self = this;
        field.addEventListener('focusout', function(e) {
            let error = (field.name === 'domain') ? !self._checkDomain(field) : !self._checkRequired(field);
            let message = (error) ? field.getAttribute('data-message') : '';
            self._error(e.target, error, message);
        });
        field.addEventListener('focusin', function(e) {
            self._error(e.target, false);
        });
    }

    _number(field) {
        let self = this;
        field.addEventListener('keypress', function(e) {
            if (e.code === 'KeyE' || e.code === 'Period' || e.code === 'Comma') {
                e.preventDefault();
            }
        });
        field.addEventListener('change', function(e) {
            self._checkRequired(e.target)
            if (!self._checkRequired(e.target)) {
                e.target.value = 0;
                self._messageObject
                    .setEnable()
                    .setUrgent()
                    .setContent(e.target.getAttribute('data-message'))
                    .add();
            }
            self._checkRequired(e.target);
        });
    }
}