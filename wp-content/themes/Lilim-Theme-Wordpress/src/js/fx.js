if (0 < jQuery(".pivot-audio").length) {
		var q = "Microsoft Internet Explorer" == window.navigator.appName || "Netscape" == window.navigator.appName && /trident\/\d\.\d/i.test(window.navigator.userAgent) ? "flash, html": "html, flash",
		r = fx_ajax_url.swfurl;
		jQuery.getScript(fx_ajax_url.jplayerurl).done(function() {
			jQuery(".pivot-audio").each(function() {
				var a = jQuery(this),
				c = a.find(".xiami-cover"),
				d = a.attr("songid"),
				type = a.data("type");
				jQuery.ajax({
					type: "get",
					dataType: "json",
					jsonp: "callback",
					url: fx_ajax_url.ajax_url,
					data: {
						action: "fxjson",
						id: d,
						type : type
					},
					async: !1,
					beforeSend: function() {

					},
					success: function(b) {
						if (200 == b.msg) {
							b = b.song;
							c.attr("style","background-image:url(" + b.song_cover + ")");
							a.find(".audio-name").html(b.song_title);
							a.find(".audio-author").html(b.song_author);
							var d = a.children(".audio-jplayer");
							d.jPlayer({
								ready: function() {
									d.jPlayer("setMedia", {
										mp3: b.song_src
									})
									if(a.hasClass("auto")){
							d.jPlayer("play");
						}
								},
								timeupdate: function(c) {
									var b;
									b = c.jPlayer.status.currentTime;
									if (!isFinite(b) || 0 > b) b = "--:--";
									else {
										var d = Math.floor(b / 60);
										b = Math.floor(b) % 60;
										b = (10 > d ? "0" + d: d) + ":" + (10 > b ? "0" + b: b)
									}
									a.find(".play-timer").text(b);
									a.find(".play-prosess-bar").width(c.jPlayer.status.currentPercentAbsolute + "%")
								},
								play: function() {
									a.find(".play-button").addClass("playing")
								},
								pause: function() {
									a.find(".play-button").removeClass("playing")
								},
								ended: function() {
									a.find(".play-button").removeClass("playing")
								},
								swfPath: r,
								solution: q,
								volume: 1,
								supplied: "mp3",
								wmode: "window",
								preload: "none"
							})
							
						}
						
					}
				})
			});
			jQuery(".pivot-audio .play-button").click(function() {
				var a = jQuery(this).parent().parent().children(".audio-jplayer"),
				c = a.attr("id");
				jQuery(".pivot-audio").each(function() {
					var a = jQuery(this).children(".audio-jplayer");
					a.attr("id") != c && a.jPlayer("pause")
				});
				a.data().jPlayer.status.paused ? a.jPlayer("play") : a.jPlayer("pause")
			});
			jQuery(".pivot-audio .play-prosess").click(function(a) {
				var c = jQuery(this),
				d = c.parent().children(".audio-jplayer"),
				f = c.width(),
				c = c.offset().left;
				d.jPlayer("playHead", 100 * ((a.pageX - c) / f))
			});
		}).fail(function() {
			window.console && console.log("\u64ad\u653e\u5668\u521d\u59cb\u5316\u5931\u8d25")
		})
	}