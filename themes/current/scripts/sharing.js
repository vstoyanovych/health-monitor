share = {
	fb: function(url) {
		link = 'https://www.facebook.com/sharer.php?u=' + encodeURIComponent(url);
		share.popup(link);
	},
    tw: function(title, url) {
		link = 'https://twitter.com/share?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(title);
        share.popup(link);
    },
    pin: function(title, media, url) {
		link = 'http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&media=' + encodeURIComponent(media) + '&description=' + encodeURIComponent(title);
        share.popup(link);
    },
	bsky: function(title, url) {
		link = 'https://bsky.app/intent/compose?text='+ encodeURIComponent(title) + '+' + encodeURIComponent(url);
		share.popup(link);
	},
	reddit: function(title, url) {
		link = 'http://reddit.com/submit?url=' + encodeURIComponent(url) + '&title=' + encodeURIComponent(title);
		share.popup(link);
	},

	popup: function(url) {
		var width = 600;
		var height = 400;
		var top = (screen.height/2)-(height/2);
		var left = (screen.width/2)-(width/2);
		window.open(url,'','toolbar=0,status=0,width='+width+',height='+height+',top='+top+',left='+left);
	}
};


function createCookie(name, value, days) {
	var expires;
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		expires = "; expires=" + date.toGMTString();
	}
	else {
		expires = "";
	}
	document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
	if (document.cookie.length > 0) {
		c_start = document.cookie.indexOf(c_name + "=");
		if (c_start != -1) {
			c_start = c_start + c_name.length + 1;
			c_end = document.cookie.indexOf(";", c_start);
			if (c_end == -1) {
				c_end = document.cookie.length;
			}
			return unescape(document.cookie.substring(c_start, c_end));
		}
	}
	return null;
}

