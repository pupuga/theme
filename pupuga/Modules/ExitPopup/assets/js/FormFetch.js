export default class FormFetch {

    constructor(params) {
        this._params = params;
        this._formData = new FormData();
        this.appendToFormData('action', this._params.action)
            .appendToFormData('wpnonce', typeof this._params.nonce === 'undefined' ? globalVars.nonce : this._params.nonce);
    }

    appendToFormData(key, value) {
        this._formData.append(key, value);

        return this;
    }

    fetch() {
        fetch(typeof this._params.url === 'undefined' ? globalVars.url : this._params.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
            },
            body: new URLSearchParams(this._formData),
            credentials: 'same-origin'
        })
          .then(response => response.json())
          .then(response => {
              this._params.callback(response);
          })
          .catch(err => console.log(err));
    }
}