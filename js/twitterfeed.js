/**
 * DuckToller TwitterFeeds
 * @author David Nordlund, © 2013 Province of Nova Scotia
 */
window.DuckToller || (window.DuckToller={});
DuckToller.TwitterFeeds = {
	baseURL: '//ducktoller.cnsdev.ca/twitter/',
	feedURL: '',
	xsltURL: '',
	index: {xslt:{}, feed:{}, tag:{}, toll:0},
	canRun: document.querySelector && window.XMLHttpRequest && (window.XSLTProcessor || window.ActiveXObject),
	run: function() {
		var scotty = DuckToller.Retriever, idx = this.index, i, p, urls={},
		    tags = document.querySelectorAll("*[data-twitterfeed]"),
		    feedURL = this.feedURL || this.getURL("?feed={feed}"),
			xsltURL = this.xsltURL || this.getURL("?xslt=twitterfeed");
		for (i = tags.length; i--;)
			if ((p = this.getFeedParams(tags[i]))) {
				var feed = feedURL.replace('{feed}', escape(p.feed)),
					xslt = (p.xslt) ? p.xslt : this.getURL('?xslt=twitterfeed');
				tags[i].setAttribute("aria-busy", "true");
				idx.tag[i] = {feed:null, xslt:null, params:p, tag: tags[i]};
				(feed in idx.feed) ? idx.feed[feed].push(i) : idx.feed[feed] = [i];
				(xslt in idx.xslt) ? idx.xslt[xslt].push(i) : idx.xslt[xslt] = [i];
				idx.toll++;
				urls[feed] = "feed";
				urls[xslt] = "xslt";
			}
		for (i in urls)
			scotty.fetch(i, this.received, {type:urls[i], tf:this});
	},
	modes: [
		['@', /^@?(\w{1,15})$/, 1],
		['#', /^search\/(\?=)?(%23|#)(\w){1,139}$/, 3],
		[':', /^(\w{1,15}\/\w{1,32})$/, 1]
	],
	getFeedParams: function(tag) {
		var params={}, mode=0, match=0, a;
		if ((a = tag.querySelector("a[href^='https://twitter.com/']"))) {
			var href = a.getAttribute("href").substring(20);
			for (var m=this.modes.length; (m--) && (mode=this.modes[m]);)
				if ((match = mode[1].exec(href)))
					break;
			params.feed = match ? mode[0] + match[mode[2]] : 0;
		}
		var tf = tag.getAttribute("data-twitterfeed").split(/\s*;\s*/);
		for (var i = tf.length, p; i--;)
			(p = tf[i].match(/^(\w+)\s*=\s*(.*)$/)) && (params[p[1]] = p[2]);
		return params.feed ? params : false;
	},
	getURL: function(basename) {
		if (!this.baseURL) {
			var t = document.querySelector("script[src$='/twitterfeed.js']");
			if (t) {
				var src = t.getAttribute("src");
				this.baseURL = src.substring(0, src.lastIndexOf('/')+1);
			}
		}
		return basename ? this.baseURL + basename : this.baseURL;
	},
	received: {
		fetched: function(url, xml, data) {
			if (data.type == "xslt")
				xml = new DuckToller.XSLT(xml);
			var idx = data.tf.index, tags = idx[data.type][url], tag, i, tagId;
			for (i=tags.length; i--;) {
				tagId = tags[i];
				if ((tag=idx.tag[tagId])) {
					tag[data.type] = xml;
					tag.feed && tag.xslt && data.tf.transform(tags[i]);
				}
			}
		},
		failed: function(url, data) {
			var idx=data.tf.index, tags = idx[data.type][url], i;
			for (i=tags.length; i--;) if (idx.tag[tags[i]])
				data.tf.closeTag(tags[i]);
		}
	},
	transform: function(tagId) {
		var tag = this.index.tag[tagId];
		tag.xslt.transform(tag.feed, tag.params, tag.tag);
		this.setTimes(tag.tag);
		this.closeTag(tagId);
	},
	closeTag: function(tagId) {
		this.index.tag[tagId].tag.setAttribute("aria-busy", "false");
		for (var i in this.index.tag[tagId])
			delete this.index.tag[tagId][i];
		this.index.tag[tagId] = 0;
		--this.index.toll || this.fed();
	},
	setTimes: function(tag) {
		var now = new Date(), days_ago, times, i, t, d, h, m, ampm, time, wday,
			weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
		for (times=tag.querySelectorAll('time'), i=times.length; i-- && (t=times[i]);) {
			d = new Date(t.getAttribute("datetime"));
			days_ago = Math.floor((now.getTime() - d.getTime()) / (1000*60*60*24));
			if (days_ago < 5) {
				h = d.getHours(), ampm = (h > 11) ? 'p.m.' : 'a.m.';
				m = d.getMinutes();
				switch (h*100+m) {
					case 0: time = 'midnight'; break;
					case 1200: time = 'noon'; break;
					default:
						h %= 12;
						time =  (h?h:12) + ':' + (m<10?'0'+m:m) + ' ' + ampm;
				}
				wday = (now.toDateString()!=d.toDateString()) ? weekdays[d.getDay()] : '';
				t.innerHTML = (wday ? wday + ', ' : '') + time;
			} else if (days_ago < 300)
				t.innerHTML = months[d.getMonth()] + ' ' + d.getDate();
			t.setAttribute('title', d.toString());
		}
	},
	fed: function() {	// let garbage collector reclaim memory after feeds are done
		for (var i in this.index) delete this.index[i];
		for (i in this) delete this[i];
		delete DuckToller.TwitterFeeds;
	}
};
DuckToller.Retriever = {
	fetch: function(url, receiver, params) {
		var XHR = window.XDomainRequest && this.ieXDR(url) || XMLHttpRequest,
			xr = new XHR(), ieXML = this.ieXML;
		function fail() {
			window.console && console.log(url+": "+(xr.statusText||xr+"failed"));
			receiver.failed(url, params);
		}
		function fetched() { // umm… never trust responseXML from IE
			var dom = window.ActiveXObject ? ieXML(xr.responseText) : xr.responseXML;
			dom ? receiver.fetched(url, dom, params) : fail();
		}
		xr.open("GET", url);
		if (typeof(xr.onload)!='undefined') {
			xr.onabort = xr.onerror = xr.ontimeout = fail;
			xr.onload = fetched;
		} else xr.onreadystatechange = function() {
			if (xr.readyState==4)
				(xr.status==200) ? fetched() : fail();
		}
		xr.send();
	},
	ieXDR: function(url) { // return XDomainRequest if url is cross-domain
		var h = url.match(/^(https?:)?\/\/([-a-z0-9.:])+(\/|$)/i),
			x = h && (h[2].toLowerCase() != location.host.toLowerCase());
		return x && XDomainRequest;
	},
	ieXML: function(xmlstr) {
		var x = new ActiveXObject("MSXML2.FreeThreadedDOMDocument");
		x.async = x.validateOnParse = false;
		x.loadXML(xmlstr);
		return x;
	}
}
DuckToller.XSLT = function(dom) {
	if (window.XSLTProcessor) {
		this.xp = new XSLTProcessor();
		this.xp.importStylesheet(dom);
	} else if (window.ActiveXObject) {
		var x = new ActiveXObject("MSXML2.XSLTemplate");
		x.stylesheet = dom;
		this.xp = x.createProcessor();
		this.transform = this.transformIE;
	} else this.transform = function() {};
}
DuckToller.XSLT.prototype = {
	transform: function(dom, params, tag) {
		for (var p in params)
			if (typeof(params[p])=="string")
				this.xp.setParameter(null, p, params[p]);
		var t = this.xp.transformToFragment(dom, tag.ownerDocument);
		this.xp.clearParameters();
		tag.innerHTML = '';
		tag.appendChild(t, tag);
	},
	transformIE: function(xml, params, tag) {
		for (var p in params)
			if (typeof(params[p])=="string")
				this.xp.addParameter(p, params[p]);
		this.xp.input = xml;
		this.xp.transform();
		tag.innerHTML = this.xp.output;
		this.xp.reset();
	}
};
DuckToller.TwitterFeeds.canRun ? DuckToller.TwitterFeeds.run() : DuckToller.TwitterFeeds = null;
