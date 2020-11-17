class _Config {

    constructor() {
        this.server = (typeof(popUpConfig) === 'undefined')
            ? ''
            : ((popUpConfig.server.charAt(popUpConfig.server.length - 1) === '/') ? popUpConfig.server.slice(0, -1) : popUpConfig.server);
        this.mainSelector = '.exit-popup-config';
        this.saveSelector = `${this.mainSelector}__button-save`;
        this.downloadSelector = `${this.mainSelector}__button-download`;
        this.copySelector = `${this.mainSelector}__button-copy`;
        this.generateSelector = `${this.mainSelector}__button-generate`;
        this.resetSelector = `${this.mainSelector}__button-reset`;
        this.generatedSelector = `${this.mainSelector}__generated-data`;
        this.fieldSelector = `${this.mainSelector}__field`;
        this.action = 'account_config';
        this.dataFileName = 'data.js';
    }
}

const Config = new _Config();
export default Config;