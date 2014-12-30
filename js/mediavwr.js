// Media Viewer box.  © Province of Nova Scotia.  @author David Nordlund

/* */(function(media_viewer_tags) {/* */

function MediaViewer(tag) { this.init(tag); }
MediaViewer.prototype = {
	init: function(tag) {
		this.tag = tag;
		this.viewport = tag.querySelector(".media-viewport");
		if (this.index.init(tag.querySelector(".media-index"), this)) {
			tag.setAttribute("tabindex", "0");
			this.initEvents(this);
			ClassList(tag).add("active");
			this.templates = {
				photo: this.viewport.removeChild(this.viewport.querySelector(".media-view-photo")),
				video: this.viewport.removeChild(this.viewport.querySelector(".media-view-video"))
			};
			console.log(this.index.photos.length + " photo(s)");
			if (this.index.photos.length) {
				var a = this.index.photos[0];
				this.index.cursor = this.index.idx(a);
				this.view(a);
			}
		}
	},
	current: null,
	focused: function() {
		this.index.reset(this);
	},
	blurred: function() {
		this.index.reset(this);
	},
	view: function(a) {
		if (this.current != a) {
			this.index.focusOn(a);
			this.viewport.innerHTML = "";
			var cl = ClassList(a.parentNode), t=0;
			for (var m in this.templates)
				if (cl.contains(m)) { t = m; break; }
			this.current = a;
			this.index.setCursor(a);
			if (t) {
				var view = this.templates[t].cloneNode(true);
				this["view"+t](a, view);
				this.viewport.appendChild(view);
			}
		}
	},
	viewphoto: function(a, div) {
		var img = div.querySelector("img"), thumb = a.querySelector("img");
		var alt = thumb.getAttribute("alt");
		var details = div.querySelector("details"), cap = details.querySelector("p");
		var dl = div.querySelector(".media-download"), p = a.parentNode;
		img.setAttribute("alt", alt);
		img.setAttribute("title", alt);
		img.src = a.href;
		details.querySelector("summary").onclick = this.toggleCaption;
		if (cap) {
			cap.innerHTML = "";
			cap.appendChild(document.createTextNode(alt));
		}
		dl.setAttribute("href", a.href);
		dl.setAttribute("download", a.href.substring(a.href.lastIndexOf('/')+1));
		var s = p.getAttribute("data-filesize") - 0, units = 'B';
		if (s > 999) { s = (s / 1000); units = 'kB'; }
		if (s > 999) { s = (s / 1000); units = 'MB'; }
		s = s < 10 ? Math.round(s*10)/10 : Math.round(s);
		dl.setAttribute("title", p.getAttribute("data-filetype") + ", " + p.getAttribute("data-photosize") + "px, "+Math.round(s*10)/10+' '+units);
	},
	viewvideo: function(a, div) {
		var new_player = null;
		for (var player in this.videoPlayers) {
			var vp = this.videoPlayers[player];
			if (vp.hostmatch.test(a.hostname)) {
				new_player = vp.makePlayer(a);
				break;
			} else console.log(a.hostname + " doesn't match "+player+".hostmatch");
		}
		if (!new_player)
			new_player = document.createTextNode("Video source not recognized");
		console.log("new_player = " + typeof(new_player));
		div.appendChild(new_player).className = "media-view-video-player";
	},
	videoPlayers: {
		youtube: {
			hostmatch: /^(www\.)?youtu(\.be|be(-nocookie)?\.com)$/i,
			makePlayer: function(a) {
				var player = null;
				var id = /\/\/[-b-y.]+\/(?:watch)?(?:\?v=)?([^&?]+)/;
				var url_prefix = "//www.youtube-nocookie.com/embed/";
				var url_suffix = "?autoplay=1&rel=0&autohide=1"; 
				if ((id = id.exec(a.href))) {
					player = document.createElement("iframe");
					player.setAttribute("src", url_prefix + id[1] + url_suffix);
				} else
					player = document.createTextNode("Cannot find youtube video id from URL");
				console.log("player = " + typeof(player));
				return player;
			}
		}
	},
	toggleCaption: function() {
		var details_classList = ClassList(this.parentNode);
		details_classList.toggle("media-caption-open");
	},
	initEvents: function(viewer) {
		this.tag.onfocus = function() { viewer.focused(); };
		this.tag.onblur = function() { viewer.blurred(); };
		this.tag.onkeydown = function(e) {
			return viewer.keydown(e||window.event);
		};
		this.tag.onkeyup = function(e) {
			return viewer.keyup(e||window.event);
		};
	},
	keydown: function(e) {
		var i = this.index, n = i.links.length-1, v = -1, dodefault = false;
		switch(e.keyCode) {
		case KB.LEFT:  case KB.UP:   v = Math.max(0, i.cursor-1); break;
		case KB.RIGHT: case KB.DOWN: v = Math.min(i.cursor+1, n); break;
		case KB.HOME: v = 0; break;
		case KB.END:  v = n; break;
		case KB.PGUP: i.pgUp(); break;
		case KB.PGDN: i.pgDn(); break;
		default: dodefault = true;
		}
		(v > -1) && i.focusOn(i.links[v]);
		return dodefault;
	},
	keyup: function(e) {
		var i = this.index, dodefault = false;
		switch(e.keyCode) {
		case KB.LEFT: case KB.RIGHT: i.links[i.cursor].click(); break;
		default: dodefault = true;
		}
		return dodefault;
	},

	index: {
		init: function(tag, viewer) {
			function clicked() { viewer.view(this); return false; }
			function resized() { var i=viewer.index; (i.cursor>-1) && i.bringIntoView(i.cursor); }
			this.items = tag.querySelector(".media-index-items");
			for (var c=this.items.lastChild, p; c; c = p) { // delete all non-element children of items
				p = c.previousSibling;
				(c.nodeType != 1) && this.items.removeChild(c);
			}
			this.viewport = tag.querySelector(".media-index-viewport");
			this.items = tag.querySelector(".media-index-items");
			this.photos = this.items.querySelectorAll(".photo a");
			this.videos = this.items.querySelectorAll(".video a");
			this.links =  this.items.querySelectorAll("a");
			var i = this.links.length, a;
			while (i && (a=this.links[--i])) {
				a.parentNode.className += " media-item";
				a.className = "media-item-link";
				a.onclick = clicked;
				a.setAttribute("tabindex", "-1");
				a.querySelector("img").className = "media-item-thumb";
			}
			if ((this.photos.length > 1) || (this.videos.length > 0)) {
				window.addEventListener && window.addEventListener("resize", resized, false);
				tag.querySelector(".media-index-back").onclick = function() { viewer.index.pgUp(); };
				tag.querySelector(".media-index-next").onclick = function() { viewer.index.pgDn(); };
				return true;
			}
			return false;
		},
		reset: function(viewer) {
			for (var i=this.links.length; i--;)
				ClassList(this.links[i]).remove("media-item-link-cursor");
			if (viewer.current)
				this.focusOn(viewer.current);
		},
		cursor: -1,
		setCursor: function(a) {
			var hoverclass = "media-item-link-cursor";
			if (this.cursor > -1)
				ClassList(this.links[this.cursor]).remove(hoverclass);
			ClassList(a).add(hoverclass);
			this.cursor = this.idx(a);
		},
		focusOn: function(a) {
			var i = this.idx(a), d = i - this.cursor;
			var foreseeable = d ? i + Math.abs(d)/d : i;
			this.bringIntoView(foreseeable);
			this.setCursor(a);
		},
		idx: function(a) {
			for (var i=this.links.length; i--;)
				if (this.links[i] === a)
					break;
			return i;
		},
		pgUp: function() {
			var view = this.getViewBox(), edge = view.height > view.width ? 'top' : 'left';
			var a = null, first = 0;
			for (var i = this.cursor - 1; i >= first; i--) {
				var a = this.links[i], b = this.getItemBox(a);
				if (b[edge] < view[edge]) break;
			}
			if (a) {
				var peek = edge=='top' ? {x:0, y:8} : {x:8, y:0};
				this.focusOn(a);
				view.style.top  = Math.min(0, view.height - b.height - b.top - peek.y) + 'px';
				view.style.left = Math.min(0, view.width - b.width - b.left - peek.x) + 'px';
			}
		},
		pgDn: function() {
			var view = this.getViewBox(), edge = view.height > view.width ? 'bottom' : 'right';
			var a = null, last = this.links.length-1;
			for (var i = this.cursor + 1; i <= last; i++) {
				var a = this.links[i], b = this.getItemBox(a);
				if (b[edge] > view[edge]) break;
			}
			if (a) {
				var peek = edge=='bottom' ? {x:0, y:8} : {x:8, y:0};
				console.log("pgdn to item " + i);
				this.focusOn(a);
				view.style.top = Math.min(0, peek.y - b.top) + 'px';
				view.style.left = Math.min(0, peek.x - b.left) + 'px';
			}
		},
		bringIntoView: function(i) {
			var a = this.links[Math.max(0, Math.min(i, this.links.length-1))];
			var item = this.getItemBox(a), view = this.getViewBox();
			var peek = (view.height > view.width) ? {x:0, y:8} : {x:8, y:0};
			this.viewport.scrollTop = this.viewport.scrollLeft = 0;
			if (item.top < view.top)
				view.style.top  = Math.min(0, peek.y - item.top) + 'px';
			else if (item.bottom > view.bottom)
				view.style.top  = (view.height - item.height - item.top - peek.y) + 'px';
			if (item.left < view.left)
				view.style.left = Math.min(0, peek.x - item.left) + 'px';
			else if (item.right > view.right)
				view.style.left = (view.width - item.width - item.left - peek.x) + 'px';
		},
		getViewBox: function() {
			var box = {
				tag: this.items, style: this.items.style,
				top: 0 - parseInt(this.items.style.top||0),
				left: 0 - parseInt(this.items.style.left||0),
				width: this.viewport.offsetWidth,
				height: this.viewport.offsetHeight
			};
			box.right = box.left + box.width;
			box.bottom = box.top + box.height;
			return box;
		},
		getItemBox: function(a) {
			var d = a.parentNode;
			var box = {
				top: d.offsetTop,
				left: d.offsetLeft,
				width: d.offsetWidth,
				height: d.offsetHeight,
			};
			box.right = box.left + box.width;
			box.bottom = box.top + box.height;
			return box;
		}
	}
};


function ClassList(tag) {return tag.classList ? tag.classList : new _ClassList(tag);}
// Implement ClassList wrapper for browsers that don't support .classList
function _ClassList(tag) { this.tag = tag; }
_ClassList.prototype = {
	contains: function(c) { return RegExp("(^|\\s)"+c+"(\\s|$)").test(this.tag.className); },
	add:      function(c) { this.contains(c)||(this.tag.className += " " + c); },
	remove:   function(c) { this.tag.className = this.tag.className.replace(RegExp("(^|\\s+)"+c+"(\\s+|$)"), " "); },
	toggle:   function(c) { this.contains(c) ? this.remove(c) : this.add(c); }
}

var KB = {SPACE:32, PGUP:33, PGDN:34, END:35, HOME:36, LEFT:37, UP:38, RIGHT:39, DOWN:40};

var media_viewers = [];
for (var i=media_viewer_tags.length; i--; )
	media_viewers.push(new MediaViewer(media_viewer_tags[i]));
console.log("media_viewers: " + media_viewers.length);

/* */ })(document.querySelectorAll ? document.querySelectorAll(".media-viewer") : []) /* */;
