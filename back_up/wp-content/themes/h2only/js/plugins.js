/*
WebFontConfig = { fontdeck: { id: '43943' } };

(function() {
  var wf = document.createElement('script');
  wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
  '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
  wf.type = 'text/javascript';
  wf.async = 'true';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(wf, s);
})();
*/
// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Place any jQuery/helper plugins in here.

/* Get real dimensions ----------- */
(function($) {
    $.fn.getRealDimensions = function (outer) {
        var $this = $(this);
        if ($this.length == 0) {
            return false;
        }
        var $clone = $this.clone()
            .removeClass()
            .attr('id', '')
            .css('visibility','hidden')
            .css('position','relative')
            .css('display','block')
            .css('float', 'left')
            .css('background', '#000')
            .appendTo('body');     
        var result = {
            width:      (outer) ? $clone.outerWidth() : $clone.innerWidth(), 
            height:     (outer) ? $clone.outerHeight() : $clone.innerHeight(),
            scrollWidth: $clone[0].scrollWidth, 
            scrollHeight: $clone[0].scrollHeight, 
            offsetTop:  $clone.offset().top, 
            offsetLeft: $clone.offset().left,
            docWidth: $(document).width(),
            docHeight: $(document).height()
        };
        $clone.remove();
        return result;
    }
})(jQuery);
