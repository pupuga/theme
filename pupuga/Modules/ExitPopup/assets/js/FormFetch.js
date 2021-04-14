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
        let self = this;
        fetch(typeof self._params.url === 'undefined' ? globalVars.url : self._params.url, {
            method: 'POST',
            body: self._formData,
            credentials: 'same-origin'
        })
          .then(response => response.json())
          .then(response => {
              //console.log(response);
              return self._params.callback(response);
          })
          .catch(err => console.log(err));
    }
}