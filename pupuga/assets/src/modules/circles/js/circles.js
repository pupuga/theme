let $ = jQuery;

class Circles {

    constructor() {
        this.pi = 3.1415926535;
        this.circlesSelector = '.circle-layer';
        this.time = 1000;
        this.timeInterval = 10;
    }

    progress(load = false) {
        let self = this;
        self.$circles = $(self.circlesSelector);
        $.each(self.$circles, function (i, val) {
            let $this = $(this);
            let $progressCircle = $this.find('circle:nth-child(2)');
            let progress = parseInt($this.attr('data-progress'));
            let scores = parseInt($this.attr('data-score'));
            if ($progressCircle.length) {
                let $progressCircle = $this.find('circle:nth-child(2)');
                let dataCircleWidth = ($this.attr('data-width') === undefined) ? 0 : parseInt($this.attr('data-width'));
                let circleStroke = parseInt($progressCircle.css('stroke-width'));
                let circleWidth = Math.round(($this.width() - circleStroke) * self.pi);
                let progressWidth = Math.round(circleWidth * progress / 100);
                if (dataCircleWidth !== circleWidth) {
                    $this.attr('data-width', circleWidth);
                    $progressCircle.attr('stroke-dasharray', `${progressWidth}, ${circleWidth}`);
                }
            }
            if (load) {
                let $progressNumber = $this.find('span:nth-child(1)');
                let timeIntervalCount = self.time / self.timeInterval;
                let scoresInterval = Math.round(scores / timeIntervalCount);
                let progressNumber = scoresInterval;
                let timer = setInterval(function () {
                    progressNumber = progressNumber + scoresInterval;
                    if (progressNumber >= scores) {
                        $progressNumber.text(scores);
                        clearInterval(timer);
                    } else {
                        $progressNumber.text(progressNumber);
                    }
                }, self.timeInterval);
            }
        });
    }
}

$(document).ready(function () {
    let $steps = $('.steps');
    if ($steps.length > 0) {
        let circles = new Circles();
        jQuery(window).on('load', function () {
            circles.progress(true);
        });
        jQuery(window).on('resize', function () {
            circles.progress();
        });
        $( document ).ajaxComplete(function() {
            circles.progress(true);
        });
    }
});