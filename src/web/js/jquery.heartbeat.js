/*
 * JHeartbeat 0.1.2 Custom
 * By Jason Levine (http://www.jasons-toolbox.com)
 * A heartbeat plugin for the jquery library to help keep sessions alive.
 
 * This plugin is copied from the plugin made by Jason Levine but it allows you to specify the div id where the heatbeat will update.
 */
 
 $.jheartbeat = {

    options: {
		url: "heartbeat_default.asp",
		delay: 10000,
		div_id: "test_div"
    },
	
	beatfunction:  function(){
	
	},
	
	timeoutobj:  {
		id: -1
	},

    set: function(options, onbeatfunction) {
		if (this.timeoutobj.id > -1) {
			clearTimeout(this.timeoutobj);
		}
        if (options) {
            $.extend(this.options, options);
        }
        if (onbeatfunction) {
            this.beatfunction = onbeatfunction;
        }

		// Add the HeartBeatDIV to the page
		$("body").append("<div id=\"" + this.options.div_id + "\" style=\"display: none;\"></div>");
		this.timeoutobj.id = setTimeout("$.jheartbeat.beat();", this.options.delay);
    },

    beat: function() {
		$("#" + this.options.div_id).load(this.options.url);
		this.timeoutobj.id = setTimeout("$.jheartbeat.beat();", this.options.delay);
        this.beatfunction();
    }
};