import Forms from "./Forms";
import Points from "./Points";
import FieldImage from "./FieldImage";
import Tabs from "./Tabs";

class User {
    constructor() {
        if (typeof(popUpConfig) !== 'undefined' && popUpConfig.page === window.location.href.split('#')[0]) {
            new Forms();
            new Points();
            new FieldImage();
            new Tabs();
        }
    }
}

document.addEventListener("DOMContentLoaded", function () {
    new User();
});