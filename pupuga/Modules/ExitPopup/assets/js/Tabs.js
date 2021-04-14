export default class Tabs {

    constructor() {
        this._selector = 'exit-popup-config';
        this._title = `${this._selector}__tab-title`;
        this._titles = `${this._selector}__tab-titles`;
        this._active = `${this._title}--active`;
        this._content = `${this._selector}__tab-content`;
        this._switch = `input-field--tab`;
        this._select = `${this._selector}__field--lang select`;
        this._$switches = document.querySelectorAll(`.${this._selector} .${this._switch}`);
        this._activate();
        this._disable();
        this._stick();
    }

    _activate() {
        let self = this;
        let $titles = document.querySelectorAll(`.${self._title}`);
        for (let $title of $titles) {
            $title.addEventListener('click', function(e) {
                let $current = this.parentNode.querySelector(`.${self._active}`);
                $current.classList.remove(self._active);
                this.classList.add(self._active);
                document.querySelector(`.${self._content}--${$current.dataset.slug}`).classList.add('display-none');
                document.querySelector(`.${self._content}--${this.dataset.slug}`).classList.remove('display-none');
            });
        }
    }

    _disable() {
        let self = this;
        if (self._$switches.length) {
            for (let $switch of self._$switches) {
                $switch.addEventListener('click', function(e) {
                    let $tabs;
                    if ($tabs === undefined) {
                        $tabs = this.closest(`.${self._content}`).parentNode.querySelector(`.${self._titles}`);
                    }
                    let $tab = $tabs.querySelector(`.${self._title}--${$switch.dataset.slug}`);
                    if ($switch.checked) {
                        $tab.classList.remove(`${self._title}--disable`);
                    } else {
                        $tab.classList.add(`${self._title}--disable`);
                    }
                });
            }
        }
    }

    _stick() {
        let self = this;
        let $select = document.querySelector(`.${self._select}`);
        if ($select !== undefined) {
            self._stickMethod($select);
            $select.addEventListener('change', function(e) {
                self._stickMethod(this);
            });
        }
    }

    _stickMethod(object) {
        let self = this;
        if (self._$switches.length) {
            for (let $switch of self._$switches) {
                if ($switch.dataset.slug === object.value) {
                    $switch.checked = false;
                    $switch.click();
                    $switch.disabled = true;
                } else {
                    $switch.disabled = false;
                }
            }
        }
    }

}