import Config from "./Config";
import FormFetch from "./FormFetch";
import Fields from "./Fields";
import Message from "./Message";
import BottomLineToCamelCase from "./BottomLineToCamelCase";
import ImageToBase64 from "./ImageToBase64";

export default class Forms {

    constructor() {
        this._error = false
        this._parent = 'exit-popup-config';
        this._parentObject = document.querySelector(`.${this._parent}`);
        this._messageObject = new Message(this._parentObject.querySelector(`.${this._parent}__message`));
        this._fieldsObject = new Fields(this._messageObject);
        this._data = {};
        this._setFields();
        this._setFieldsValues();
        this._save();
        this._generate();
        this._copy();
        this._download();
        this._reset();
    }

    _setFields(check = false) {
        this._fields = document.querySelectorAll(`${Config.fieldSelector} .input-field`);
        if (check) {
            this._error = this._fieldsObject.checkRequiredFields(this._fields);
        } else {
            this._fieldsObject.setEvents(this._fields);
        }
    }

    _setFieldsValues() {
        let self = this;
        let entityMap = {
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
            '`': '&#x60;',
            '\\': '&#92;',
        };
        self._fieldsValues = {};
        if (self._fields.length) {
            for (let field of self._fields) {
                let fieldImage;
                let value = String(field.value).replace(/[<>"'`\\]/g, function (s) {
                    return entityMap[s];
                });
                switch (field.type) {
                    case 'checkbox':
                        self._fieldsValues[field.name] = (field.checked) ? 1 : 0;
                        break;
                    case 'select-one':
                        self._fieldsValues[field.name] = field.options[field.selectedIndex].value;
                        break;
                    case 'file':
                        fieldImage = field.closest(`.${self._parent}__field`).querySelector('img');
                        self._fieldsValues[field.name] =
                            (typeof(field.files[0]) === 'object')
                                ? field.files[0]
                                : (field.dataset.default === fieldImage.src) ? '1' : ''
                        break;
                    default:
                        self._fieldsValues[field.name] = value;
                }
                if (field.dataset.type === 'languages' && field.type === 'text') {
                    if (self._data[field.dataset.type] === undefined) {
                        self._data[field.dataset.type] = {}
                    }
                    let camelCase = new BottomLineToCamelCase(field.name);
                    if (self._data[field.dataset.type][camelCase.get()] === undefined) {
                        self._data[field.dataset.type][camelCase.get()] = {};
                    }
                    self._data[field.dataset.type][camelCase.get()][camelCase.getLast()] = value;
                }
                if (field.type === 'file') {
                    let camelCase = new BottomLineToCamelCase(field.name, true);
                    this._data[camelCase.get()] = (new ImageToBase64(fieldImage)).getSplit();
                }
                if (field.name === 'domain') {
                    if (self._fieldsValues[field.name].charAt(self._fieldsValues[field.name].length - 1) === '/') {
                        self._fieldsValues[field.name] = self._fieldsValues[field.name].slice(0, -1);
                    }
                }
            }
        }
    }

    _save() {
        let self = this;
        document.querySelector(Config.saveSelector).addEventListener('click', function() {
            self._setFields(true);
            if (!self._error) {
                if (self._fields.length) {
                    self._parentObject.insertAdjacentHTML('beforeend', '<div class="wait-loading"></div>');
                    self._setFieldsValues();
                    self._formFetch = new FormFetch({
                        action: Config.action,
                        callback: self._after()
                    });
                    for (let key in self._fieldsValues) {
                        self._formFetch.appendToFormData(key, self._fieldsValues[key]);
                    }
                }
                self._formFetch.fetch();
            }
        });
    }

    _after() {
        let self = this;
        return function (response) {
            if(response.done) {
                self._parentObject.lastChild.remove();
                self._messageObject
                    .setEnable()
                    .setContent(response.message);
                (response.error !== 0) ? self._messageObject.setError() : self._messageObject.setInfo();
                self._messageObject.add();
            }
        }
    }

    _generate() {
        let self = this;
        document.querySelector(Config.generateSelector).addEventListener('click', function() {
            document.querySelector(Config.generatedSelector + ' textarea').innerHTML =
                `<script src="${self._fieldsValues.domain}/data.js"></script>&#013;<script src="${Config.server}/main.js"></script>`;
            document.querySelector(Config.generatedSelector).classList.add(`${Config.generatedSelector.substring(1)}--block`);
            self._copyAction();
        });
    }

    _copy() {
        let self = this;
        document.querySelector(Config.copySelector).addEventListener('click', function() {
            self._copyAction();
        });
    }

    _copyAction() {
        let self = this;
        let copyField = document.querySelector(Config.generatedSelector + ' textarea');
        copyField.select();
        copyField.setSelectionRange(0, 50000);
        document.execCommand('copy');
        self._messageObject
            .setEnable()
            .setInfo()
            .setContent('The Code is copied')
            .add();
    }

    _reset() {
        let self = this;
        document.querySelector(Config.resetSelector).addEventListener('click', function() {
            for (let field of self._fields) {
                if (typeof field.dataset.default !== undefined) {
                    if (field.type !== 'file') {
                        field.value = field.dataset.default;
                    } else if (field.type === 'file') {
                        field.closest(`.${self._parent}__field`).querySelector('img').src = field.dataset.default;
                        field.value = '';
                    }
                }
            }
        });
    }

    _download() {
        let self = this;
        document.querySelector(Config.downloadSelector).addEventListener('click', function() {

            //set languages fields
            let languages = '{';
            for (let field in self._data.languages) {
                languages += `"${field}": {`
                for (let lang in self._data.languages[field]) {
                    if (self._fieldsValues[`use_lang_${lang}`] === 1) {
                        languages += `"${lang}": "${self._data.languages[field][lang]}",`
                    }
                }
                languages = languages.slice(0, -1) + `},`;
            }
            languages = languages.slice(0, -1) + `}`;

            //set time field
            let time = parseInt(self._fieldsValues.time);
            let minInt = Math.floor(time/60);
            let secInt = time - minInt * 60;
            let min = minInt.toString();
            let sec = secInt.toString();
            min = (minInt <= 9) ? '0' + min : min;
            sec = (secInt <= 9) ? '0' + sec : sec;

            let code = `let dataExitPopup = {
                "code": "${self._fieldsValues.code}",
                "time": "${min}:${sec}",
                "memoryDays": "${self._fieldsValues.memory_days}",
                "memoryCloseDays": "${self._fieldsValues.memory_close_days}",
                "mobileLoadSec": "${self._fieldsValues.mobile_load_sec}",
                "desktopLoadSec": "${self._fieldsValues.desktop_load_sec}",
                "minimizeCount": "${self._fieldsValues.minimize_count}",
                "minimizeHide": "${self._fieldsValues.minimize_hide}",
                "style" : {
                    "borderRadius" : "${self._fieldsValues.border_radius}",
		            "backgroundColor" : "${self._fieldsValues.background_color}",
		            "getFontFamily" : "${(self._fieldsValues.get_font_family)}",
		            "timerTitleFontColor" : "${self._fieldsValues.timer_title_font_color}",
		            "timerFontColor" : "${self._fieldsValues.timer_font_color}",
		            "timerDigitColor" : "${self._fieldsValues.timer_digit_color}",
		            "timerDigitBackgroundColor" : "${self._fieldsValues.timer_digit_background_color}",
		            "timerAnalogPointColor" : "${self._fieldsValues.timer_analog_point_color}",
		            "codeTitleFontColor" : "${self._fieldsValues.code_title_font_color}",
		            "codeFontColor" : "${self._fieldsValues.code_font_color}",
		            "codeCodeFontColor" : "${self._fieldsValues.code_code_font_color}",
		            "helpFontColor" : "${self._fieldsValues.help_font_color}",
		            "closeButtonColor" : "${self._fieldsValues.close_button_color}",
		            "minimizeButtonColor" : "${self._fieldsValues.minimize_button_color}",
		            "minimizeButtonBackgroundColor" : "${self._fieldsValues.minimize_button_background_color}"
    		    },
    		    "timerImage": "${self._data.timerImage[1]}",
                "timerImageExt": "${self._data.timerImage[0]}",
                "codeImage": "${self._data.codeImage[1]}",
                "codeImageExt": "${self._data.codeImage[0]}",
    		    "lang": "${self._fieldsValues.lang}",
    		    "languages": ${languages}
            }`;

            let element = document.createElement('a');
            //element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(code.replace(/(\r\n|\n|\r|\s+)/gm,' ')));
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(code));
            element.setAttribute('download', Config.dataFileName);
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        });
    }
}