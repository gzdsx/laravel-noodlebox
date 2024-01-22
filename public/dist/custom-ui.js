function Toast() {
    var div = jQuery("<div/>").addClass('toast-message')
    this.show = function (message) {
        div.html(message).appendTo(document.body);
        div.css({opacity: 1});
        setTimeout(this.hide, 2000);
    }

    this.hide = function () {
        div.css({'opacity': 0});
        setTimeout(function () {
            div.remove();
        }, 300);
    }
}

var toast = new Toast();