import Config from "./Config";
import FormFetch from "./FormFetch";
import Fields from "./Fields";
import Message from "./Message";

export default class Forms {

    constructor() {
        this._error = false
        this._parent = 'exit-popup-config';
        this._parentObject = document.querySelector(`.${this._parent}`);
        this._messageObject = new Message(this._parentObject.querySelector(`.${this._parent}__message`));
        this._fieldsObject = new Fields(this._messageObject);
        this._setFields();
        this._setFieldsValues();
        this._save();
        this._generate();
        this._copy();
        this._download();
        this._reset();
    }

    _setFields(check = false) {
        this._fields = document.querySelectorAll(`${Config.fieldSelector} input`);
        if (check) {
            this._error = this._fieldsObject.checkRequiredFields(this._fields);
        } else {
            this._fieldsObject.setEvents(this._fields);
        }
    }

    _setFieldsValues() {
        let entityMap = {
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
            '`': '&#x60;',
            '\\': '&#92;',
        };
        this._fieldsValues = {};
        if (this._fields.length) {
            for (let field of this._fields) {
                this._fieldsValues[field.name] = String(field.value).replace(/[<>"'`\\]/g, function (s) {
                    return entityMap[s];
                });
                if (field.name === 'domain') {
                    if (this._fieldsValues[field.name].charAt(this._fieldsValues[field.name].length - 1) === '/') {
                        this._fieldsValues[field.name] = this._fieldsValues[field.name].slice(0, -1);
                    }
                }
            }
        }
    }

    _timeToClockView(time) {
        time = parseInt(time);
        let minInt = Math.floor(time/60);
        let secInt = time - minInt * 60;
        let min = minInt.toString();
        let sec = secInt.toString();
        min = (minInt <= 9) ? '0' + min : min;
        sec = (secInt <= 9) ? '0' + sec : sec;

        return min + ':' + sec;
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
                (response.error === 1) ? self._messageObject.setError() : self._messageObject.setInfo();
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
                    field.value = field.dataset.default;
                }
            }
        });
    }

    _download() {
        let self = this;
        document.querySelector(Config.downloadSelector).addEventListener('click', function() {
            let element = document.createElement('a');
            let code = `let dataExitPopup = {
                "timerTitle": "${self._fieldsValues.timer_title}",
                "timerDescription": "${self._fieldsValues.timer_description}",
                "timerImage": "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",
                "timerImageExt": "png",
                "codeTitle": "${self._fieldsValues.code_title}",
                "codeDescription": "${self._fieldsValues.code_description}",
                "codeImage": "iVBORw0KGgoAAAANSUhEUgAAALoAAABkCAYAAAAxOiquAAAACXBIWXMAAAsTAAALEwEAmpwYAAAJT2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDIgNzkuMTYwOTI0LCAyMDE3LzA3LzEzLTAxOjA2OjM5ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06RG9jdW1lbnRJRD0iYWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOmU3YmZiZTQ2LTE3NmItODU0Yy1hYWRhLWQ1YWU1OTI5ZDY4NyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo5ZjYyMGU3ZS05NzE2LTlhNDYtYjk4Ny1jOTc4ZTZjY2IwMGYiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0iNjgzN0E0OTAyOTg0MDM1RjRCRDlENTM0MjFGMjhBOEMiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0iIiB0aWZmOkltYWdlV2lkdGg9IjE4NiIgdGlmZjpJbWFnZUxlbmd0aD0iMTAwIiB0aWZmOlBob3RvbWV0cmljSW50ZXJwcmV0YXRpb249IjIiIHRpZmY6U2FtcGxlc1BlclBpeGVsPSIzIiB0aWZmOlhSZXNvbHV0aW9uPSI3Mi8xIiB0aWZmOllSZXNvbHV0aW9uPSI3Mi8xIiB0aWZmOlJlc29sdXRpb25Vbml0PSIyIiBleGlmOkV4aWZWZXJzaW9uPSIwMjIxIiBleGlmOkNvbG9yU3BhY2U9IjY1NTM1IiBleGlmOlBpeGVsWERpbWVuc2lvbj0iMTg2IiBleGlmOlBpeGVsWURpbWVuc2lvbj0iMTAwIiB4bXA6Q3JlYXRlRGF0ZT0iMjAyMC0wOS0wM1QxNjoyMTo1NyswMzowMCIgeG1wOk1vZGlmeURhdGU9IjIwMjAtMDktMDNUMTY6Mjk6MjQrMDM6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMjAtMDktMDNUMTY6Mjk6MjQrMDM6MDAiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDpiM2NkNzM2MC1mNjhiLTBjNGYtOWY3My0zNzRkNmIwZjhiYTAiIHN0RXZ0OndoZW49IjIwMjAtMDktMDNUMTY6Mjk6MjQrMDM6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE4IChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGltYWdlL2pwZWcgdG8gaW1hZ2UvcG5nIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJkZXJpdmVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJjb252ZXJ0ZWQgZnJv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",
                "codeImageExt": "jpg",
                "headerText": "${self._fieldsValues.header_text}",
                "footerText": "${self._fieldsValues.footer_text}",
                "code": "${self._fieldsValues.code}",
                "time": "${self._timeToClockView(self._fieldsValues.time)}",
                "memoryDays": "${self._fieldsValues.memory_days}",
                "memoryCloseDays": "${self._fieldsValues.memory_close_days}",
                "mobileLoadSec": "${self._fieldsValues.mobile_load_sec}",
                "desktopLoadSec": "${self._fieldsValues.desktop_load_sec}",
                "style" : {
                    "borderRadius" : "${self._fieldsValues.border_radius}",
		            "backgroundColor" : "${self._fieldsValues.background_color}",
		            "getFontFamily" : "${(self._fieldsValues.get_font_family === 'on') ? '1' : ''}",
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
    		    }
            }`;
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(code.replace(/(\r\n|\n|\r|\s+)/gm,' ')));
            //element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(code));
            element.setAttribute('download', Config.dataFileName);
            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        });
    }
}