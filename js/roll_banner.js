(function($){
	$.fn.extend({
		roll_banner : function(opt) {
			// 기본값 설정
			var defaults = {
				direction : 'left',
				delay : 5000,
				pos : 0,
				navi : 'show'
			};
			var now,next,prev,total,obj, list, width,slideTimer,navi;
			var opt = $.extend(defaults, opt);
			var setPrev = function() {
				var n = now-1;
				prev = 0 > n ? total-1 : n;
				list.eq(prev).css('left', width * -1);
			}
			var setNext = function() {
				var n = now+1;
				next = total > n ? n : 0;
				list.eq(next).css('left', width);
			}
			var setPos = function(n) {
				now = n;
				list.eq(now).css('left', 0);
				setPrev();
				setNext();
			}
			var resetPosition = function(n) {
				setPos(n);
			}
			var slide = function() {
				list.removeClass('on');
				navi.removeClass('on');
				var dir = arguments.length == 0 ? opt.direction : arguments[0];
				switch (dir) {
					case 'right' :
						list.eq(now).animate({left : obj.width()},300);
						list.eq(prev).animate({left : 0},300,function(){resetPosition(prev)});
						list.eq(prev).addClass('on');
						navi.eq(prev).addClass('on');
						break;
					default:
						list.eq(now).animate({left : obj.width() * -1},300);
						list.eq(next).animate({left : 0},300,function(){resetPosition(next)});
						list.eq(next).addClass('on');
						navi.eq(next).addClass('on');
						break;
				}
			}
			
			return this.each(function() {
				obj = $(this);
				list = obj.find('.roll>li');
				navi = obj.find('.roll_navi a');
				width = obj.width();
				list.css('left', width);
				list.eq(opt.pos).css('left', 0);
				list.eq(opt.pos).addClass('on');
				navi.eq(opt.pos).addClass('on');
				total = list.length;
				setPos(opt.pos);
				if (opt.navi == 'hide') {
					obj.find('.roll_navi').css('display','none');
				}
				slideTimer = setInterval(slide,opt.delay);
				obj.find('a.next').click(function(e) {
					e.preventDefault();
					clearInterval(slideTimer);
					slide();
					slideTimer = setInterval(slide,opt.delay);
				});
				obj.find('a.prev').click(function(e) {
					e.preventDefault();
					clearInterval(slideTimer);
					slide('right');
					slideTimer = setInterval(slide,opt.delay);
				});
				navi.click(function(e){
					e.preventDefault();
					if($(this).hasClass('on')) {
						return;
					}
					var idx = $(this).parent('li').index('.roll_navi li');
					//console.log(idx);
					var dir;
					if (idx > now) {
						dir = 'left';
						next = idx;
						list.eq(idx).css('left', width);
					} else {
						dir = 'right';
						prev = idx;
						list.eq(idx).css('left', width * -1);
					}
					clearInterval(slideTimer);
					slide(dir);
					slideTimer = setInterval(slide,opt.delay);
				});
				
			});
		}
	});

	$.fn.extend({
		roll_partner : function(opt) {
			// 기본값 설정
			var defaults = {
				delay : 2000,
				width: '1000',
				showcount : '5',
				move : '',
				count : '',
				speed : 100
			};
			
			var opt = $.extend(defaults, opt);
			var wrap, cont , timer;
			var idx = 0;
			var action = function() {
				var move = opt.size *-1;
				cont.animate({left: move}, opt.speed, 'linear' , function() {
					cont.css('left','0px');
					action();
				});
				/*
				idx = idx % opt.count == 0? 1 : idx % opt.count+1;
				//console.log(idx);
				var move = opt.move * idx * -1;
				//console.log(move);
				cont.animate({left : move}, opt.speed , function() {
					if (idx == opt.count) {
						cont.css('left','0px');
					}
				});
				*/
			}
			
			return this.each(function() {
				obj = $(this);
				opt.move = opt.width/opt.showcount;
				opt.size = opt.move * obj.find('li').length;
				//console.log(opt.size);
				wrap = $('<div></div>').css({'width':opt.width, 'height' : '53px', 'margin' : '0px auto', 'overflow':'hidden','position' : 'relative'}).appendTo(obj);
				cont = $('<div></div>').appendTo(wrap).css({'position' : 'absolute', 'left':'0px', 'top':'0px', 'width' : opt.size*2});
				var ul1 = obj.find('ul');
				opt.count = ul1.find('li').length;
				ul1.appendTo(cont).css({'width' : opt.size, 'float':'left'});
				var ul2 = obj.find('ul').clone().appendTo(cont).css('left', ul1.width());
				obj.find('li').css({'display':'block','width': opt.move,'text-align':'center', 'float':'left'})
				action();
				cont.on('mouseenter', function(e){
					cont.stop();
				}).on('mouseleave', function(e){
					action();
				})
			});
		}
	});
})(jQuery);