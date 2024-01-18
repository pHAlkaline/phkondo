/**
 * Plugin for using queue for multiple ajax requests.
 *
 * @autor Pavel Máca
 * @github https://github.com/PavelMaca
 * @license MIT
 */

(function($) {
    var AjaxQueue = function(options){
        this.options = options || {};
        
        var oldComplete = options.complete || function(){};
        var completeCallback = function(XMLHttpRequest, textStatus) {
       
            (function() {
                oldComplete(XMLHttpRequest, textStatus);
            })();
           
            $.ajaxQueue.currentRequest = null;
            $.ajaxQueue.startNextRequest();
        };
        this.options.complete = completeCallback;
    };

    AjaxQueue.prototype = {
        options: {},
        perform: function() {
            $.ajax(this.options);
        }
    }

    $.ajaxQueue = {
        queue: [],

        currentRequest: null,

        stopped: false,

        stop: function(){
            $.ajaxQueue.stopped = true;

        },

        run: function(){
            $.ajaxQueue.stopped = false;
            $.ajaxQueue.startNextRequest();
        },

        clear: function(){
            $.ajaxQueue.queue = [];
            $.ajaxQueue.currentRequest = null;
        },

        addRequest: function(options){
            var request = new AjaxQueue(options);
            
            $.ajaxQueue.queue.push(request);
            $.ajaxQueue.startNextRequest();
        },

        startNextRequest: function() {
            if ($.ajaxQueue.currentRequest) {
                return false;
            }
           
            var request = $.ajaxQueue.queue.shift();
            if (request) {
                $.ajaxQueue.currentRequest = request;
                request.perform();
            }
        }
    }
})(jQuery);