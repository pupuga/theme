import Forms from "./Forms";
import Points from "./Points";

class User {
    constructor() {
        if (typeof(popUpConfig) !== 'undefined' && popUpConfig.page === window.location.href.split('#')[0]) {
            new Forms();
            new Points();
        }
    }
}

document.addEventListener("DOMContentLoaded", function () {
    new User();
});