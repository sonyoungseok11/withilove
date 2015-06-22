(function($){
	$.fn.extend({ 
		EXeditor: function(option) {
			var EX_id = 'EX_'+$(this).attr('name');
			if (typeof(option) == 'string') {
				switch (option) {
					case 'getData' :
						console.log($('#'+EX_id).find('.EX_Editor')[0].contentWindow.document.body.textContent);
						var text=  $('#'+EX_id).find('.EX_Editor')[0].contentWindow.document.body.innerHTML;
						return text
						break;
					default :
						return this;
						break;
				}
			}
			// 기본설정값
			var defaults = {
				userLevel: 10,
				upPath : 'http://'+ window.location.hostname + '/data/upload/',
				thumbPath : 'http://'+ window.location.hostname +'/data/upload/thumb/',
				imageUrl : '/editor/EXeditor/image.php',
				imgCount : 8,
				menu : [
						'fontFamily','fontSize','fontColor','backColor','*',
						'bold','italic','subscript','superscript','underline','-',
						'JustifyLeft','JustifyCenter', 'JustifyRight','*',
						'InsertUnorderedList','insertOrderedList', 'insertTable','*',
						'createLink','unlink','*',
						'InsertImg','InsertYoutube'
						],
				menuTitle : [
						'글꼴선택','글씨크기','전경색','배경색','*',
						'굵게','이탤릭','아랫첨자','윗첨자','밑줄','-',
						'왼쪽정렬','가운데정렬','오른쪽정렬','*',
						'목록','번호목록','Table 삽입','*',
						'링크생성', '링크해제','*',
						'이미지삽입','유투브동영상연결'
						],
				fontFamily : {'굴림':'Gulim', '돋움':'Dotum', '바탕':'Batang','궁서':'Gungsuh'},
				fontSize : ['10', '11', '12', '14', '16', '20' , '24', '30', '36', '48']
			};
			
			var opt = $.extend(defaults, option);
			//console.log(opt);
			// 유저 에이전트
			var agent = new Object();
			agent.getAgent = function() {
				var ua = window.navigator.userAgent;
				var RegEx_msie = /MSIE/i;
				var RegEx_Trident = /Trident/i;
				if (RegEx_msie.exec(ua)) {
					agent.browser = "MSIE";
					agent.reg = /MSIE ([\d]+)./i
				} else if (RegEx_Trident.exec(ua)) {
					agent.browser = "MSIE";
					agent.reg = /rv:([\d]+)./i
				} else {
					agent.browser = 'nonIE';
					agent.reg = false;
				}
				if (agent.reg) {
					var v = agent.reg.exec(ua);
					agent.version = v[1];
				}
			}
			agent.getAgent();
			
			
			// 크로스 브라우징
			var insertHtmlCross = function(result, selection) {
					if(agent.browser == 'MSIE') {
						//console.log(selection);
						var editRange = selection.range;
						editRange.deleteContents();
						if (agent.version > 9) {
							editRange.insertNode(editRange.createContextualFragment(result));
						} else {
							var frag =doc.createDocumentFragment();
							var div  = document.createElement("div");
							div.innerHTML = result;
							while(div.firstChild) {
								frag.appendChild(div.firstChild);
							}
							editRange.insertNode(frag);
						}
					} else {
						doc.execCommand("inserthtml",false,result);
					}
			}
			
			/* wigywig div 생성 및 iframe 생성 */
			opt.frame = new Object();
			opt.frame.textarea = $(this);
			opt.frame.div = $('<div></div>').attr('id', EX_id).addClass('wigywig');
			$(this).before(opt.frame.div);
			opt.frame.menu = $('<ul></ul>').addClass('eMenu').appendTo(opt.frame.div);
			//opt.frame.editor = $('<div></div>').attr({'contenteditable':'true'}).addClass('EX_Editor').addClass('cssReset').css({'height': $(this).height()}).appendTo(opt.frame.div);
			var ed_height = $(this).height() < 300 ? 600 : $(this).height();
			opt.frame.editor = $('<iframe></iframe>').attr({'id':'eWindow'}).css({'display':'block','height': ed_height, border:'none','width':'100%'}).appendTo(opt.frame.div).addClass('EX_Editor');
			opt.frame.editor.append('<body></body>').attr('id','ebody');
			var win , doc;
			var ENTER = 13, SHIFT=16, BACKSPACE=8, DELETE=46;
			var SHIFT_ON = false;
			
			if (agent.browser == 'nonIE' || agent.version >= 11) {
				$(document).ready(function(e) {
					win = opt.frame.editor[0].contentWindow;
					doc = win.document;
					$(doc).find('body').attr('contenteditable','true');
					docEvent($(doc).find('body')[0]);
					SourceToFrame();
				});
			} else {
				window.addEventListener('load',function(){
					win = opt.frame.editor[0].contentWindow;
					doc = win.document;
					doc.designMode='on';
					win.addEventListener('load', function(){
						var bodyel = doc.querySelector('body');
						docEvent(bodyel);
						SourceToFrame();	
					},false);
					
				},false);
			}
			var docEvent = function(el) {
				$(el).css(
					{'margin':'0px','padding':'0px'}
				).on('mouseup', function(e) {
					opt.frame.div.find('.EX_popup').hide();
					opt.frame.div.find('.EX_context').remove();
					getPosition();
				}).on('keypress', function(e){
					if ($(this).find('*').length == 0) {
						$(this).html('<div><br></div>');
					}
					getPosition();
				}).on('focus',function(e){
					getPosition();
				}).on('contextmenu', function(e) {
					Context.open(e,e.target);
				})
				opt.frame.div.resizable({
					alsoResize: opt.frame.editor,
					minHeight: 300,
					maxWidth : opt.frame.div.width(),
					minWidth : opt.frame.div.width(),
				});
			}
			
			opt.frame.editor.after(opt.frame.textarea);
			opt.frame.textarea.css({'border':'none','display':'block'}).hide();
			opt.frame.bottom = $('<div></div>').addClass('wigywig_bottom').appendTo(opt.frame.div);
			opt.frame.viewSource = $('<a></a>').attr('href','#').text('소스보기').appendTo(opt.frame.bottom).click(function(e){
				e.preventDefault();
				opt.frame.textarea.css('height', opt.frame.editor.height());
				if ($(this).hasClass('selected')) {
					SourceToFrame();
					opt.frame.editor.show();
					opt.frame.textarea.hide();
					$(this).removeClass('selected');					
				} else {
					FrameToSource();
					opt.frame.editor.hide();
					opt.frame.textarea.show();
					$(this).addClass('selected');

				}
			});
			opt.frame.info = $('<span></span>').css({'padding':'0px 5px'}).appendTo(opt.frame.bottom);
			//resize = new Object();
			//var resizeHandler = $('<div></div>').addClass('resizeHandler').appendTo(opt.frame.bottom);
			
			//소스정보를 프레임으로 옴긴다.
			function SourceToFrame() {
				if(opt.frame.textarea.val() != '') {
					$(doc).find('body').html(opt.frame.textarea.val())
				} else {
					$(doc).find('body').html("<div><br></div>");
				}
			}
			
			function FrameToSource() {
				opt.frame.textarea.val($(doc).find('body').html());
			}
			
			/* 메뉴 생성 */
			var createMenu = function(menu, menuTitle, target) {
				var menu_length = menu.length;
				for (var i=0; i<menu_length; i++) {
					if (i==0 || menu[i] == '*') {
						var li = $('<li></li>').appendTo(target);
						if (menu[i] == '*') {
							continue;
						}
					}
					if (menu[i] == '-') {
						var span = $('<span></span>').addClass('space').appendTo(li);
					} else {
						switch (menu[i]) {
							case 'fontFamily' :
								var divition = menu[i];
								var sel1 = $('<select></select>').attr('data-command',menu[i]).appendTo(li);
								var op = $('<option></option>').val('').text('글꼴').appendTo(sel1);
								for (var key in opt[divition]) {
									var op2 = $('<option></option>').val(opt[divition][key]).text(key).appendTo(sel1);
								}
								break;
								
							case 'fontSize' :
								var sel2 = $('<select></select>').attr('data-command',menu[i]).appendTo(li);
								var len = opt.fontSize.length
								var op = $('<option></option>').val('').text('크기').appendTo(sel2);
								for (var j=0; j<len; j++ ) {
									var op2 = $('<option></option>').val(opt.fontSize[j]).text(opt.fontSize[j]+'px').appendTo(sel2);
								}
								break;
								
							default :
								var a = $('<button></button>').attr({'data-command':menu[i], 'title':menuTitle[i]}).appendTo(li);
								var text = $('<span></span>').appendTo(a);
								break;
						}
					}
				}
			}
			createMenu(opt.menu, opt.menuTitle, opt.frame.menu);
			
			var popup = new Object();

			popup.create = function(target) {
				var cmd = $(target).attr('data-command');
				popup[cmd] = {name : cmd+'_popup'};
				var popupel = $('<div></div>').css({
					'left' : $(target).context.offsetLeft,
					'top' : $(target).context.offsetHeight + $(target).context.offsetTop,
				}).addClass('EX_popup').attr('id', popup[cmd].name);
				return popupel;
			}
			popup.toggle = function(target) {
				var cmd = $(target).attr('data-command');
				$('.EX_popup:not(#'+popup[cmd].name+')').hide();
				$('#'+popup[cmd].name).toggle();
			}
			
			// 컬러피커 생성
			var ColorPicker = new Object();
			ColorPicker.preset = [
				"#000000", "#000033", "#000066", "#000099", "#0000CC", "#0000FF",
				"#003300", "#003333", "#003366", "#003399", "#0033CC", "#0033FF",
				"#006600", "#006633", "#006666", "#006699", "#0066CC", "#0066FF",
				"#009900", "#009933", "#009966", "#009999", "#0099CC", "#0099FF",
				"#00CC00", "#00CC33", "#00CC66", "#00CC99", "#00CCCC", "#00CCFF",
				"#00FF00", "#00FF33", "#00FF66", "#00FF99", "#00FFCC", "#00FFFF",
				"#330000", "#330033", "#330066", "#330099", "#3300CC", "#3300FF",
				"#333300", "#333333", "#333366", "#333399", "#3333CC", "#3333FF",
				"#336600", "#336633", "#336666", "#336699", "#3366CC", "#3366FF",
				"#339900", "#339933", "#339966", "#339999", "#3399CC", "#3399FF",
				"#33CC00", "#33CC33", "#33CC66", "#33CC99", "#33CCCC", "#33CCFF",
				"#33FF00", "#33FF33", "#33FF66", "#33FF99", "#33FFCC", "#33FFFF",
				"#660000", "#660033", "#660066", "#660099", "#6600CC", "#6600FF",
				"#663300", "#663333", "#663366", "#663399", "#6633CC", "#6633FF",
				"#666600", "#666633", "#666666", "#666699", "#6666CC", "#6666FF",
				"#669900", "#669933", "#669966", "#669999", "#6699CC", "#6699FF",
				"#66CC00", "#66CC33", "#66CC66", "#66CC99", "#66CCCC", "#66CCFF",
				"#66FF00", "#66FF33", "#66FF66", "#66FF99", "#66FFCC", "#66FFFF",
				"#990000", "#990033", "#990066", "#990099", "#9900CC", "#9900FF",
				"#993300", "#993333", "#993366", "#993399", "#9933CC", "#9933FF",
				"#996600", "#996633", "#996666", "#996699", "#9966CC", "#9966FF",
				"#999900", "#999933", "#999966", "#999999", "#9999CC", "#9999FF",
				"#99CC00", "#99CC33", "#99CC66", "#99CC99", "#99CCCC", "#99CCFF",
				"#99FF00", "#99FF33", "#99FF66", "#99FF99", "#99FFCC", "#99FFFF",
				"#CC0000", "#CC0033", "#CC0066", "#CC0099", "#CC00CC", "#CC00FF",
				"#CC3300", "#CC3333", "#CC3366", "#CC3399", "#CC33CC", "#CC33FF",
				"#CC6600", "#CC6633", "#CC6666", "#CC6699", "#CC66CC", "#CC66FF",
				"#CC9900", "#CC9933", "#CC9966", "#CC9999", "#CC99CC", "#CC99FF",
				"#CCCC00", "#CCCC33", "#CCCC66", "#CCCC99", "#CCCCCC", "#CCCCFF",
				"#CCFF00", "#CCFF33", "#CCFF66", "#CCFF99", "#CCFFCC", "#CCFFFF",
				"#FF0000", "#FF0033", "#FF0066", "#FF0099", "#FF00CC", "#FF00FF",
				"#FF3300", "#FF3333", "#FF3366", "#FF3399", "#FF33CC", "#FF33FF",
				"#FF6600", "#FF6633", "#FF6666", "#FF6699", "#FF66CC", "#FF66FF",
				"#FF9900", "#FF9933", "#FF9966", "#FF9999", "#FF99CC", "#FF99FF",
				"#FFCC00", "#FFCC33", "#FFCC66", "#FFCC99", "#FFCCCC", "#FFCCFF",
				"#FFFF00", "#FFFF33", "#FFFF66", "#FFFF99", "#FFFFCC", "#FFFFFF"
			];
			
			ColorPicker.create = function(target) {
				var picker = popup.create(target)
				picker.css('width','200');
				$(target).after(picker);
				var preset_length = ColorPicker.preset.length;
				var childName = $(target).attr('data-command') + '_child';
				for (var i=0; i< preset_length; i++) {
					var color  = '#' + ColorPicker.preset[i];
					var a = $('<button></button>').css({
						'width' : '9', 
						'height' : '9', 
						'display' : 'block', 
						'border' : '1px solid #000',
						'float' : 'left',
						'margin' : '1px',
						'background-color' : color,
						'cursor' : 'pointer'
					}).attr({'data-command':childName,'data-value': ColorPicker.preset[i]}).appendTo(picker);
				}
				
				var inset = $('<div></div>').css({
					'clear' : 'both',
					'font-size' : '11px',
					'font-family' : 'Dotum'
				}).addClass('inputColorDiv').appendTo(picker);
				var finish = $(target).attr('data-command') + '_finish';
				var inset_span = $('<span></span>').text('직접입력 : #').appendTo(inset);
				var inset_input = $('<input>').attr({'type':'text'}).css({'font-size':'11px', 'border': '1px solid #ddd', 'padding':'1px', 'width':'50px', 'height':'13px;'}).appendTo(inset).keyup(function(e) {
					var val = $(this).val();
					val = val.replace(/[^0-9^a-f]/i,'');
					val = val.match(/([0-9a-f]{0,6})/i)
					$(this).val(val[1]);
				});;
				var inset_a = $('<button></button>').attr({'data-command': finish}).css({'background-color':'#f0f0f0','border': '1px solid #ddd', 'margin-left':'4px','padding':'1px 4px', 'cursor' : 'pointer'}).text('완료').appendTo(inset);
				$('.EX_popup').hide();
				picker.show();
			}
						
			// 테이블 폼 생성
			var TableForm = new Object();
			TableForm.create = function(target) {
				var table = popup.create(target)
				var left = table.css('left').replace('px','');
				table.css({'width':'280', 'left': (left-140)+'px'});
				$(target).after(table);
				var div1 = $('<div></div>').html('폭: <input id="EXedit_table_width" value="100" style="font-size:11px; border:1px solid #ddd, padding:1px; width:40px;" />%').css('float','left').appendTo(table);
				var div2 = $('<div></div>').html('가로: <input id="EXedit_table_col" value="4" style="font-size:11px; border:1px solid #ddd, padding:1px; width:40px;" />').css({'float':'left', 'margin-left':'10px'}).appendTo(table);
				var div3 = $('<div></div>').html('세로: <input id="EXedit_table_row" value="3" style="font-size:11px; border:1px solid #ddd, padding:1px; width:40px;" />').css({'float':'left', 'margin-left':'10px'}).appendTo(table);
				var finish = $(target).attr('data-command') + '_finish';
				var button = $('<button></button>').attr({'data-command': finish}).css({'background-color':'#f0f0f0','border': '1px solid #ddd', 'margin-left':'4px','padding':'1px 4px', 'cursor' : 'pointer'}).text('완료').appendTo(table);
				$('#EXedit_table_width').keyup(function(e){
					var val = $(this).val();
					val = val.replace(/[^\d]/,'');
					val = val.match(/(^100|[1-9]?[0-9])/);
					$(this).val(val[0]);
				});
				$('.EX_popup').hide();
				table.show();
			}
			// 모달레이어 생성
			var Modal = new Object();
			Modal.obj = null;
			// 모달 닫기 버튼 클릭
			$('body').delegate('.exdialog_close', 'click' , function(e) {
				e.preventDefault();
				$(this).closest('.ui-dialog-content').dialog('close');
			});
			Modal.Table = {
				dialog : function() {
					var wrap = $('<div></div>').attr({'title':'테이블 설정','id':'EXeditor_dialog_table'}).appendTo('body');
					var div = $('<div></div>').addClass('exdialog_form').appendTo(wrap);
					var ul = $('<ul></ul>').appendTo(div);
					var li1 = $('<li></li>').appendTo(ul);
					var lable1 = $('<div></div>').addClass('lh').text('Width : ').appendTo(li1);
					var input1 = $('<input>').attr({'type': 'text','name' : 'width','size' : '6'}).appendTo(li1);
					var span1 = $('<span></span>').text('%').appendTo(li1);
					var li2 = $('<li></li>').appendTo(ul);
					var lable2 = $('<div></div>').addClass('lh').text('Align : ').appendTo(li2);
					//var input2 = $('<input>').attr({'type': 'text','name' : 'align','size' : '6'}).appendTo(li2);
					var select2 = $('<select></select>').attr({'name' : 'align'}).appendTo(li2)
					var op1 = $('<option></option>').appendTo(select2).val('left').text('left');
					var op2 = $('<option></option>').appendTo(select2).val('center').text('center');
					var op2 = $('<option></option>').appendTo(select2).val('right').text('right');
					
					var div2 = $('<div></div>').appendTo(div);
					var a = $('<a></a>').attr('href','#').text('변경').addClass('exdialog_set_table').appendTo(div2).button();
					var a2 = $('<a></a>').attr('href','#').addClass('exdialog_close').text('취소').appendTo(div2).button();
					wrap.dialog({
						autoOpen : false,
						modal : true
					});
					
				},
				show : function() {
					var width = $(Modal.obj)[0].style.width;
					var align = $(Modal.obj).attr('align');
					$('#EXeditor_dialog_table').find('input[name="width"]').val(width.replace('%',''));
					$('#EXeditor_dialog_table').find('select[name="align"]').find('option').each(function(idx, el){
						if (el.value == align) {
							$(el).attr('selected','selected');
						} else {
							$(el).removeAttr('selected');
						}
					});
					$('#EXeditor_dialog_table').dialog('open');
				}
			}
			Modal.Table.dialog();
			// 모달 테이블 변경버튼 클릭
			$('body').delegate('.exdialog_set_table', 'click', function(e) {
				e.preventDefault();
				var form = $(this).closest('.exdialog_form');
				$(Modal.obj).css('width', form.find('input[name="width"]').val() + '%');
				$(Modal.obj).attr('align', form.find('select[name="align"]').val());
				$(this).closest('.ui-dialog-content').dialog('close');
			});
			// 이미지 업로드 및 선택/ 수정
			Modal.Images = {
				container : null,
				imgWrap : null,
				page : null,
				mode : null,
				setImgPage : function() {
					var target = Modal.Images.imgWrap;
					var page = Modal.Images.page;
					//console.log(page);
					var div = $('<div></div>').appendTo(target).addClass('exImgPage');
					if (page.page_list > 0) {
						var prev_page = page.page_list * 10
						var input1 = $('<input>').attr({'type':'radio','name':'page', 'id' : 'prev_page'}).val(prev_page).appendTo(div);
						var label1 = $('<label></label>').attr('for','prev_page').text('◀').appendTo(div);
					}
					var page_end = (page.page_list+1) * 10
					var last_page = page.total_page;
					if (page_end > page.total_page) {
						page_end = page.total_page
					}
					for (var setpage=page.page_list*10+1 ; setpage<=page_end; setpage++) {
						var input = $('<input>').attr({'type':'radio','name':'page', 'id' : 'page'+setpage}).val(setpage).appendTo(div);
						var label = $('<label></label>').attr('for','page'+setpage).text(setpage).appendTo(div);
						if (setpage == page.current_page) {
							input.prop('checked', true);
						}
					}
					if (page_end < page.total_page) {
						var next_page = (page.page_list+1) * 10+1;
						var input1 = $('<input>').attr({'type':'radio','name':'page', 'id' : 'next_page'}).val(next_page).appendTo(div);
						var label1 = $('<label></label>').attr('for','next_page').text('▶').appendTo(div);
					}
					div.buttonset().find('input').change(function(){
						Modal.Images.getImg($(this).val());
					});
				},
				setImgList : function(data) {
					var len = data.length;
					var target = Modal.Images.imgWrap;
					var ul = $("<ul></ul>").appendTo(target);
					for (var i=0; i<len ; i++) {
						var li = $('<li></li>').appendTo(ul);
						var div = $('<div></div>').appendTo(li).css({'background-image': 'url('+opt.thumbPath+data[i]+')'}).addClass('img');
						var a1 = $('<a></a>').attr({'href' : '#', 'data-file' : data[i]}).text('선택').button().appendTo(li).click(function(e) {
							e.preventDefault();
							$(this).closest('.ui-dialog-content').dialog('close');
							var img = $('<img>').attr({'src': opt.upPath + $(this).attr('data-file'), 'alt':'업로드 이미지'});
							if (!activeSel) {
								win.focus()
								getPosition();
							}
							insertHtmlCross(img[0].outerHTML,activeSel);
						});
						if (opt.userLevel == 1) {
							var a2 = $('<a></a>').attr({'href' : '#', 'data-file' : data[i]}).text('삭제').button().appendTo(li).click(function(e) {
								e.preventDefault();
								var cmd = confirm('이미지를 삭제 하시겠습니까?');
								if (cmd) {
									$.ajax({
										url : opt.imageUrl,
										type: 'post',
										data : {
											mode : 'deleteImg',
											file : $(this).attr('data-file')
										},
										success: function(data) {
											Modal.Images.getImg(Modal.Images.page.current_page);
										}
									});
								}
							});
						}
					}
				},
				getImg : function(page) {
					var count = opt.imgCount; // 불러올 이미지 수
					var target = Modal.Images.imgWrap;
					target.html('');
					target.addClass('loading');
					$.ajax({
						url : opt.imageUrl,
						type : 'POST',
						dataType : 'json',
						data : {
							'mode' : 'getImg',
							'page' : page,
							'count' : count
						},success: function(data) {
							target.removeClass('loading');
							Modal.Images.page = data.page;
							Modal.Images.setImgList(data.files);
							Modal.Images.setImgPage();
							//console.log(data);
						}
					});
				},
				dialogOpen :function() {
					Modal.Images.container.dialog('open');
					Modal.Images.getImg(1);
				},
				dialog : function() {
					var wrap = $('<div></div>').attr({'title':'이미지 올리기 및 선택','id':'EXeditor_dialog_images'}).appendTo('body');
					Modal.Images.container = wrap;
					var form1 = $('<form></form>').attr({
						'action' : opt.imageUrl,
						'method' : 'post',
						'enctype' : 'multipart/formdata'
						}).addClass('exUploadImg').appendTo(wrap);
					var div1 = $('<div></div>').addClass('imgUpload').appendTo(form1);
					var label1 = $('<label></label>').text('Upload Img :').appendTo(div1);
					var input1 = $('<input>').attr({'type':'file', 'name' :'upload'}).appendTo(div1);
					var input2 = $('<input>').attr({'type':'hidden','name' : 'mode','value' : 'upload'}).appendTo(div1);
					var a1 = $('<input>').attr({'type':'submit','value':'이미지 올리기'}).addClass('exdialog_uploadimg').button().appendTo(div1);
					var div2 = $('<div></div>').addClass('imgList').appendTo(wrap);
					Modal.Images.imgWrap = div2;
					wrap.dialog({
						autoOpen : false,
						modal : true,
						width : 826,
						height: 550
					});
				},
				modify_dialog : function() {
					var mode = Modal.Images.mode;
					//console.log(Modal.obj);
					
					var wrap = $('<div></div>').attr({'title':'이미지 설정','id':'EXeditor_dialog_imgModify'}).appendTo('body');
					var div = $('<div></div>').addClass('exdialog_form').appendTo(wrap);
					var ul = $('<ul></ul>').appendTo(div);
					var li1 = $('<li></li>').appendTo(ul);
					var lh1 = $('<div></div>').addClass('lh').text('alt :').appendTo(li1);
					var input1 = $('<input>').attr({'type': 'text','name' : 'alt','size' : '26'}).appendTo(li1);
					
					var li2 = $('<li></li>').appendTo(ul);
					var lh2 = $('<div></div>').addClass('lh').text('float :').appendTo(li2);
					var select2 = $('<select></select>').attr({'name' : 'float'}).appendTo(li2)
					var op1 = $('<option></option>').appendTo(select2).val('none').text('정렬안함');
					var op2 = $('<option></option>').appendTo(select2).val('left').text('left');
					var op2 = $('<option></option>').appendTo(select2).val('right').text('right');
					
					var li3 = $('<li></li>').appendTo(ul);
					var lh3 = $('<div></div>').addClass('lh').text('width :').appendTo(li3);
					var input3 = $('<input>').attr({'type': 'text','name' : 'width','size' : '6'}).appendTo(li3);
					var span3_1 = $('<span></span>').text('px ').appendTo(li3);
					var span3_2 = $('<span></span>').addClass('s_width').appendTo(li3);
					
					var li4 = $('<li></li>').appendTo(ul);
					var lh4 = $('<div></div>').addClass('lh').text('height :').appendTo(li4);
					var input4 = $('<input>').attr({'type': 'text','name' : 'height','size' : '6'}).appendTo(li4);
					var span4_1 = $('<span></span>').text('px ').appendTo(li4);
					var span4_2 = $('<span></span>').addClass('s_height').appendTo(li4);
					
					var li5 = $('<li></li>').appendTo(ul).css({'position':'relative','height':'85px'});
					var lh5 = $('<div></div>').addClass('lh').text('margin :').appendTo(li5).css('top','36px');
					
					var label5_1 = $('<label></label>').text('').css({'position' : 'absolute','left':'165px','top':'6px'}).appendTo(li5)
					var input5_1 = $('<input>').attr({'type': 'text','name' : 'm_top','size' : '5'}).appendTo(label5_1);
					var span5_1 = $('<span></span>').text('px ').appendTo(label5_1);
					
					var label5_2 = $('<label></label>').text('').css({'position' : 'absolute','left':'232px','top':'36px'}).appendTo(li5)
					var input5_2 = $('<input>').attr({'type': 'text','name' : 'm_right','size' : '5'}).appendTo(label5_2);
					var span5_2 = $('<span></span>').text('px ').appendTo(label5_2);
					
					var label5_3 = $('<label></label>').text('').css({'position' : 'absolute','left':'165px','top':'66px'}).appendTo(li5)
					var input5_3 = $('<input>').attr({'type': 'text','name' : 'm_bottom','size' : '5'}).appendTo(label5_3);
					var span5_3 = $('<span></span>').text('px ').appendTo(label5_3);
					
					var label5_4 = $('<label></label>').text('').css({'position' : 'absolute','left':'100px','top':'36px'}).appendTo(li5)
					var input5_4 = $('<input>').attr({'type': 'text','name' : 'm_left','size' : '5'}).appendTo(label5_4);
					var span5_4 = $('<span></span>').text('px ').appendTo(label5_4);
					
					var li6 = $('<li></li>').appendTo(ul);
					var lh6 = $('<div></div>').addClass('lh').text('style :').appendTo(li6);
					var input6 = $('<textarea></textarea>').attr({'name' :'style'}).css({'display':'block', 'height':'60px', 'width':'100%'}).appendTo(li6);
					
					
					var div2 = $('<div></div>').appendTo(div);
					var a = $('<a></a>').attr('href','#').text('변경').addClass('exdialog_set_image').appendTo(div2).button();
					var a2 = $('<a></a>').attr('href','#').addClass('exdialog_close').text('취소').appendTo(div2).button();
					wrap.dialog({
						autoOpen : false,
						modal : true,
						width : 400
					});
				},
				modify : function(mode) {
					//console.log($(Modal.obj));
					Modal.Images.mode = mode;
					var wrap = $('#EXeditor_dialog_imgModify');
					
					if (mode == 'img') {
						wrap.closest('.ui-dialog').find('.ui-dialog-title').text('이미지 설정');
					} else {
						wrap.closest('.ui-dialog').find('.ui-dialog-title').text('YouTube 설정');
					}
					var alt = $(Modal.obj).attr('alt');
					var float = $(Modal.obj).css('float');
					var width = $(Modal.obj).context.clientWidth;
					var s_width = $(Modal.obj).context.naturalWidth;
					var height = $(Modal.obj).context.clientHeight;
					var s_height = $(Modal.obj).context.naturalHeight;
					var m_top = $(Modal.obj).css('margin-top');
					var m_right = $(Modal.obj).css('margin-right');
					var m_bottom = $(Modal.obj).css('margin-bottom');
					var m_left = $(Modal.obj).css('margin-left');
					var style = $(Modal.obj)[0].style.cssText;
					
					wrap.find('input[name="alt"]').val(alt);
					wrap.find('select[name="float"]').find('option').each(function(idx, el){
						if (el.value == float) {
							$(el).attr('selected','selected');
						} else {
							$(el).removeAttr('selected');
						}
					});
					wrap.find('input[name="width"]').val(width);
					wrap.find('input[name="height"]').val(height);
					if (mode == 'img') {
						wrap.find('.s_width').text('원본 넓이 : '+ s_width + 'px');
						wrap.find('.s_height').text('원본 높이 : '+ s_height + 'px');
					} else {
						wrap.find('.s_width').text('');
						wrap.find('.s_height').text('');
					}
					wrap.find('input[name="m_top"]').val(m_top.replace('px',''));
					wrap.find('input[name="m_right"]').val(m_right.replace('px',''));
					wrap.find('input[name="m_bottom"]').val(m_bottom.replace('px',''));
					wrap.find('input[name="m_left"]').val(m_left.replace('px',''));
					
					wrap.find('textarea[name="style"]').val(style);
					
					wrap.dialog('open');
				}
				
			}
			Modal.Images.dialog();
			Modal.Images.modify_dialog();
			
			$('body').delegate('.exdialog_set_image', 'click', function(e){
				e.preventDefault();
				var form = $(this).closest('.exdialog_form');
				$(Modal.obj).attr('alt', form.find('input[name="alt"]').val());
				
				$(Modal.obj).attr('width', form.find('input[name="width"]').val());
				$(Modal.obj).attr('height', form.find('input[name="height"]').val());
				var m_top = form.find('input[name="m_top"]').val() + 'px ';
				var m_right = form.find('input[name="m_right"]').val() + 'px ';
				var m_bottom = form.find('input[name="m_bottom"]').val() + 'px ';
				var m_left = form.find('input[name="m_left"]').val() + 'px ';
				var margin = m_top + m_right + m_bottom + m_left;
				$(Modal.obj)[0].style.cssText = form.find('textarea[name="style"]').val();
				$(Modal.obj).css('margin', margin);
				$(Modal.obj).css('float', form.find('select[name="float"]').val());
				$(this).closest('.ui-dialog-content').dialog('close');
			});
			
			
			// 이미지 업로드 전송
			$('body').delegate('.exUploadImg', 'submit', function(e) {
				e.preventDefault();
				var me = this;
				if(this.upload.value.length > 0) {
					//console.log(this.upload.value.length)
					$(this).ajaxForm({
						success: function(text, s){
							//console.log(text);
							var data = text.split("|");
							if (data[0] == 'Y') {
								$(me).closest('.ui-dialog-content').dialog('close');
								var img = $('<img>').attr('src', 'http://'+ data[2]);
								insertHtmlCross(img[0].outerHTML,activeSel);
							} else {
								alert(data[1]);
							}
						}
					});
				}
			});
			
			// 컨텍스트 메뉴 생성
			var Context = new Object()
			Context.Table = function(e, el) {
				Modal.obj = $(el).closest('table')[0];
				var ul = $('<ul></ul>').addClass('EX_context').css({
					'position':'absolute',
					'left': e.clientX , 
					'top': e.clientY +40,
					'width':'150px'
				});
				var li3 = $('<li></li>').appendTo(ul);
				var a3 = $('<a></a>').text('행 추가').attr('href','#').appendTo(li3).click(function(e) {
					e.preventDefault();
					var table = $(el).closest('table');
					var tr = table.find('tr:first').clone();
					tr.find('td').html('');
					table.append(tr);
					ul.remove();
				});
				var li4 = $('<li></li>').appendTo(ul);
				var a4 = $('<a></a>').text('열 추가').attr('href','#').appendTo(li4).click(function(e) {
					e.preventDefault();
					var tr = $(el).closest('table').find('tr');
					tr.each(function(idx, el) {
						var td = $(el).find('td:first').clone();
						td.html('');
						$(el).append(td)
					});
					ul.remove();
				});
				var li5 = $('<li></li>').appendTo(ul);
				var a5 = $('<a></a>').text('행 삭제').attr('href','#').appendTo(li5).click(function(e) {
					e.preventDefault();
					var tr = $(el).closest('tr');
					tr.remove();
					ul.remove();
				});
				var li6 = $('<li></li>').appendTo(ul);
				var a6 = $('<a></a>').text('열 삭제').attr('href','#').appendTo(li6).click(function(e) {
					e.preventDefault();
					var idx = $(el).context.cellIndex;
					var tr = $(el).closest('table').find('tr');
					tr.each(function(i, t) {
						$(t).find('td').eq(idx).remove();
					});
					ul.remove();
				});
				
				var li1 = $('<li></li>').appendTo(ul);
				var a1 = $('<a></a>').text('테이블 설정').attr('href','#').appendTo(li1).click(function(e) {
					e.preventDefault();
					Modal.Table.show($(el).closest('table')[0]);
					ul.remove();
				});
				var li2 = $('<li></li>').appendTo(ul);
				var a2 = $('<a></a>').text('테이블 삭제').attr('href','#').appendTo(li2).click(function(e) {
					e.preventDefault();
					$(el).closest('table').remove();
					ul.remove();
				});
				ul.menu().appendTo(opt.frame.div);
			}
			Context.Img = function(e, el) {
				Modal.obj = el;
				var ul = $('<ul></ul>').addClass('EX_context').css({
					'position':'absolute',
					'left': e.clientX , 
					'top': e.clientY +40,
					'width':'150px'
				});
				var li1 = $('<li></li>').appendTo(ul);
				var a1 = $('<a></a>').text('이미지 설정').attr('href','#').appendTo(li1).click(function(e) {
					e.preventDefault();
					Modal.Images.modify('img');
					ul.remove();
				});
				var li2 = $('<li></li>').appendTo(ul);
				var a2 = $('<a></a>').text('이미지 삭제').attr('href','#').appendTo(li2).click(function(e) {
					e.preventDefault();
					$(el).remove();
					ul.remove();
				});
				ul.menu().appendTo(opt.frame.div);
			}
			Context.Embed = function(e, el) {
				Modal.obj = el;
				var ul = $('<ul></ul>').addClass('EX_context').css({
					'position':'absolute',
					'left': e.clientX , 
					'top': e.clientY +40,
					'width':'150px'
				});
				var li1 = $('<li></li>').appendTo(ul);
				var a1 = $('<a></a>').text('YouTube 설정').attr('href','#').appendTo(li1).click(function(e) {
					e.preventDefault();
					Modal.Images.modify('embed');
					ul.remove();
				});
				var li2 = $('<li></li>').appendTo(ul);
				var a2 = $('<a></a>').text('YouTube 삭제').attr('href','#').appendTo(li2).click(function(e) {
					e.preventDefault();
					$(el).remove();
					ul.remove();
				});
				ul.menu().appendTo(opt.frame.div);
			}
			Context.open = function(e,el) {
				//console.log(el);
				switch ($(el)[0].nodeName) {
					case 'TD' :
						e.preventDefault();
						Context.Table(e,el);
						break;
					case 'IMG':
						e.preventDefault();
						Context.Img(e,el);
						break;
					case 'EMBED':
						e.preventDefault();
						Context.Embed(e,el);
						break;
				}
			}
			
			// 링크폼 생성
			var LinkForm = new Object();
			LinkForm.create = function(target) {
				var table = popup.create(target);
				var left = table.css('left').replace('px','');
				table.css({'width':'280', 'left': (left-140)+'px'});
				$(target).after(table);
				var label = $('<label></label>').text('url :').appendTo(table);
				var input = $('<input>').attr({'type':'text', 'value':'http://'}).css({'font-size':'11px', 'border': '1px solid #ddd', 'padding':'1px', 'width':'213px', 'height':'13px;'}).appendTo(label);
				var finish = $(target).attr('data-command') + '_finish';
				var button = $('<button></button>').attr({'data-command': finish}).css({'background-color':'#f0f0f0','border': '1px solid #ddd', 'margin-left':'4px','padding':'1px 4px', 'cursor' : 'pointer'}).text('완료').appendTo(table);
				LinkForm.define = true;
				$('.EX_popup').hide();
				table.show();
			}
			
			// 플래쉬 폼 생성
			var SwfForm = new Object();

			SwfForm.create = function(target) {
				var parent_name = $(target).attr('data-command');
				var table = popup.create(target);
				var left = table.css('left').replace('px','');
				table.css({'width':'254', 'left': (left-127)+'px'});
				$(target).after(table);
				
				input_id = [
					'ExEdit_SwfForm_'+parent_name+'_url',
					'ExEdit_SwfForm_'+parent_name+'_width',
					'ExEdit_SwfForm_'+parent_name+'_height',
				];
				var title_idx = opt.menu.indexOf(parent_name);
				var div1 = $('<div></div>').text(opt.menuTitle[title_idx]).css('margin-bottom','4px').appendTo(table);
				var label1 = $('<label></label>').css({'float':'left'}).text('url :').appendTo(table);
				var input1 = $('<input>').attr({'id':input_id[0],'type':'text', 'value':'http://'}).css({'font-size':'11px', 'border': '1px solid #ddd', 'padding':'1px', 'width':'223px', 'height':'13px;'}).appendTo(label1);
				var div_clear = $('<div></div>').css({'clear':'both','height':'4px'}).appendTo(table);
				var label2 = $('<label></label>').css('float','left').text('Width :').appendTo(table);
				var input2 = $('<input>').attr({'id':input_id[1],'type':'text'}).css({'font-size':'11px', 'border': '1px solid #ddd', 'padding':'1px', 'width':'40px', 'height':'13px;'}).appendTo(label2);
				var span_px = $('<span></span>').text('px').css('margin-right','8px').appendTo(label2);
				var label3 = $('<label></label>').css('float','left').text('Height :').appendTo(table);
				var input3 = $('<input>').attr({'id':input_id[2],'type':'text'}).css({'font-size':'11px', 'border': '1px solid #ddd', 'padding':'1px', 'width':'40px', 'height':'13px;'}).appendTo(label3);
				span_px.clone().appendTo(label3);
				var finish = parent_name + '_finish';
				var button = $('<button></button>').attr({'data-command': finish}).css({'background-color':'#f0f0f0','border': '1px solid #ddd', 'margin-left':'4px','padding':'1px 4px', 'cursor' : 'pointer'}).text('완료').appendTo(table);
				SwfForm.define = true;
				$('.EX_popup').hide();
				table.show();
			}
			
		// 현제 선택 노드의 부모노드
			var getSelect = function () {
				var sel;
				sel = win.getSelection();
				sel.types = sel.type;
				if (sel.types != "None") {
					sel.node = sel.anchorNode;
					sel.range = sel.getRangeAt(0);
					sel.text = sel.range.cloneContents().textContent;
				}
				return sel;
			}
			
			var getParent = function(node) {
				return $(node).parent();
			}
			var isActive = function(node) {
				var node_name = node.nodeName;
				//console.log(node_name);
				var cmd;
				switch (node_name) {
					case 'HTML':
					case 'BODY':
						return;
						break;
					case 'DIV' :
						if ($(node).css('text-align') == 'left') {
							opt.frame.menu.find('button[data-command="JustifyLeft"]').addClass('active');
						} 
						if($(node).css('text-align') == 'center') {
							opt.frame.menu.find('button[data-command="JustifyCenter"]').addClass('active');
						} 
						if($(node).css('text-align') == 'right') {
							opt.frame.menu.find('button[data-command="JustifyRight"]').addClass('active');
						} 
						if ($(node).css('font-size')) {
							if (!opt.frame.menu.find('select[data-command="fontSize"]').hasClass('active')) {
								var fs = $(node).css('font-size');
								fs = fs.replace('px','');
								opt.frame.menu.find('select[data-command="fontSize"]').val(fs).addClass('active');
							}
						} 
						if ($(node).css('font-family')) {
							if(!opt.frame.menu.find('select[data-command="fontFamily"]').hasClass('active')) {
								var ff = $(node).css('font-family');
								opt.frame.menu.find('select[data-command="fontFamily"]').val(ff).addClass('active');
							}
						}
						return ;
						break;
					case 'STRONG':
					case 'B':	cmd = 'bold';			break;
					case 'EM':
					case 'I':	cmd = 'italic';			break;
					case 'SUB':	cmd = 'subscript';		break;
					case 'SUP':	cmd = 'superscript';	break;
					case 'U':	cmd = 'underline';		break;
					case 'OL':	cmd = 'insertOrderedList';		break;
					case 'UL':	cmd = 'InsertUnorderedList';	break;
					case 'SPAN':
						if ($(node).css('text-decoration') == 'underline') {
							opt.frame.menu.find('button[data-command="underline"]').addClass('active');
						}
						if ($(node).css('font-weight') == 'bold') {
							opt.frame.menu.find('button[data-command="bold"]').addClass('active');
						} 
						if ($(node).css('font-size')) {
							if (!opt.frame.menu.find('select[data-command="fontSize"]').hasClass('active')) {
								var fs = $(node).css('font-size');
								fs = fs.replace('px','');
								opt.frame.menu.find('select[data-command="fontSize"]').val(fs).addClass('active');
							}
						} 
						if ($(node).css('font-family')) {
							if(!opt.frame.menu.find('select[data-command="fontFamily"]').hasClass('active')) {
								var ff = $(node).css('font-family');
								opt.frame.menu.find('select[data-command="fontSize"]').val(ff).addClass('active');
							}
						}
						break;
				}
				
				if (cmd) {
					opt.frame.menu.find('button[data-command="'+cmd+'"]').addClass('active')
				}
				var parent = $(node).parent();
				isActive(parent[0]);
			}
			
			
			var activeObj = null;
			var activeSel = null;
			var getPosition = function() {
				var selection = getSelect();
				activeSel = selection;
				try {
					var pnode_name = selection.node.parentNode.nodeName;
					opt.frame.info.html('');
					if (pnode_name == 'BODY' || pnode_name == 'HTML') {
						activeObj = selection.node;	
					} else {
						activeObj = selection.node.parentNode;
					}
					var node_name = activeObj.nodeName;
					//console.log(activeSel)
					
					//console.log(activeObj);
					var span = $('<span></span>').appendTo(opt.frame.info);
					var label = $('<label></label>').text(node_name+' style : ').appendTo(span);
					var width = opt.frame.bottom.width()-opt.frame.bottom.find('a:first').width() - span.width() - 40;
					var input = $('<input>').attr({'type':'text','value': activeObj.style.cssText}).css({
						'width' : width,
						'border' :'none',
						'height' : '14px',
						'padding' : '3px',
						'font-size' : '11px',
						'position' : 'absolute',
						'background' : 'transparent'
					}).appendTo(label).keypress(function(e){
						if(e.keyCode == ENTER) {
							e.preventDefault();
							//$(this).closest('span').find('button').click();
							activeObj.style.cssText = $(this).val();
							getPosition();
						}
					});
					//console.log(span.width());
					//console.log(span);
					opt.frame.menu.find('.active').removeClass('active');
					opt.frame.menu.find('select[data-command="fontSize"] option').removeAttr('selected','selected').removeClass('active');
					isActive(activeObj.node);
					return activeObj.node;
				} catch(e) {}
			}
			var is_enabled = function(cmd) {
				var supported = true;
				try {
					supported = doc.queryCommandEnabled(cmd);
				} catch(e) {
					supported = false;
				}
				return supported;
			}
			/* 메뉴클릭에 따른 동작함수 정의*/
			var exec = function(e) {
				if (activeSel != null) {
					var selection = activeSel;
				} else {
					win.focus();
					getPosition();
					var selection = activeSel;
				}
				var node = activeObj;
				//console.log(selection);
				var cmd = $(e).attr('data-command');
				switch (cmd) {
					case 'backColor_finish':
					case 'fontColor_finish' :
					case 'fontSize':
					case 'fontFamily' :
						var popupClose = false;
						switch (cmd) {
							case 'fontSize' :
								if ($(e).val().length == 0) {
									return;
								}
								var value = $(e).val()+'px';
								var cssType = 'font-size';
								break;
							case 'fontFamily':
								if ($(e).val().length == 0) {
									return;
								}
								var value = $(e).val();
								var cssType = 'font-family';
								break;
							case 'fontColor_finish':
								var value = '#' + $(e).attr('data-value');
								var cssType = 'color';
								popupClose = true;
								break;
							case 'backColor_finish':
								var value = '#' + $(e).attr('data-value');
								var cssType = 'background-color';
								popupClose = true;
								break;
						}
						if (selection.isCollapsed) {
							$(node).css(cssType,value);
						} else {
							var text = selection.toString();
							if (node.nodeName == 'SPAN' && text == node.textContent) {
								$(node).css(cssType,value);
							} else {
								var span = $('<span></span>').css(cssType,value).text(text);
								//selection.newHtml(span);
								//doc.execCommand('InsertHTML',null , span[0].outerHTML);
								insertHtmlCross(span[0].outerHTML, selection);
							}
						}
						if (popupClose) {
							$('.EX_popup').hide();
						}
						win.focus();
						getPosition();
						break;
					
					case 'insertTable_finish' :
						var width = $('#EXedit_table_width').val();
						var col = $('#EXedit_table_col').val();
						var row = $('#EXedit_table_row').val();
						width = width > 0 ? width : 100;
						width = width+'%';
						col = col > 0 ? col : 4;
						row = row > 0 ? row : 3;
						var table = $('<table></table>').css({'border-collapse':'collapse','width': width}).attr('align','left');
						for (var r=0; r<row; r++) {
							var tr = $('<tr></tr>').appendTo(table);
							for (var c=0; c<col; c++) {
								var td = $('<td>&nbsp;</td>').css({'border':'1px solid #cdcdcd', 'height' : '24px'}).text(' ').appendTo(tr);
							}
						}
						
						insertHtmlCross(table[0].outerHTML, activeSel);
						$('.EX_popup').hide();
						win.focus();
						break;

					case 'createLink_finish':
						if (!selection.isCollapsed) {
							var val = $(e).closest('div').find('input').val();
							if (val.match(/^http:\/\/(www.)?.+\..*/i)) {
								doc.execCommand('createLink', false, val);
							}
							$('.EX_popup').hide();
						}
						win.focus();
						getPosition();
						break;
					case 'unlink':
						if (!selection.isCollapsed) {
							doc.execCommand(cmd, false, null);
						} else {
							if(node.nodeName.match(/a/i)) {
								var html = $(node).html();
								$(node).replaceWith(html);
							}
						}
						win.focus();
						getPosition();
						break;
						
					case 'JustifyLeft':
					case 'JustifyCenter':
					case 'JustifyRight':
						if (is_enabled(cmd)) {
							//console.log(cmd);
							doc.execCommand(cmd,false , null);
						} else {
							var temp_parent = node;
							var action = true;
							switch (cmd) {
								case 'JustifyLeft':	var cs = 'left'; break;
								case 'JustifyCenter': var cs = 'center'; break;
								case 'JustifyRight': var cs = 'right'; break;
							}
							do {
								//console.log(temp_parent);
								if (temp_parent.nodeName.match(/(DIV|TD|LI)/i)) {
									action = false;
									$(temp_parent).css('text-align', cs);
								} else {
									temp_parent = temp_parent.parentNode;
								}
							} while(action)
						}
						win.focus();
						getPosition();
						break;
						
					case 'InsertYoutube_finish' :
					case 'InsertFlash_finish' :
						var parent_name = cmd.split('_')[0];
						var url = $('#ExEdit_SwfForm_'+parent_name+'_url').val();
						var width = $('#ExEdit_SwfForm_'+parent_name+'_width').val();
						var height = $('#ExEdit_SwfForm_'+parent_name+'_height').val();
						
						switch (parent_name) {
							case 'InsertFlash':
								var RegEx = /^http:\/\/(www.)?.+\..*\.swf$/i;
								break;
							case 'InsertYoutube':
								var RegEx = /(^http:\/\/youtu.be\/(.+)$|^http:\/\/www.youtube.com\/watch\?v\=(.+)$|^http:\/\/www.youtube.com\/v\/.+$)/i;
								break;
						}
						var reg_match;
						if (reg_match = url.match(RegEx)) {
							switch (parent_name) {
								case 'InsertFlash' :
									var code = $('<embed></embed>').attr({
										'pluginspage':'http://www.macromedia.com/go/getflashplayer',
										'quality': 'high',
										'src' : url,
										'type' : 'application/x-shockwave-flash'
									});
									break;
								case 'InsertYoutube':
									pattern = "http://www.youtube.com/v/";
									if (reg_match[2]) {
										url = pattern + reg_match[2];
									} else if (reg_match[3]) {
										url = pattern + reg_match[3];
									}
									var code = $('<embed></embed>').attr({
										'src' : url,
										'type' : 'application/x-shockwave-flash',
										'allowscriptaccess' : 'always',
										'allowfullscreen' :'true'
									});
									break;
							}
							if (width > 0) {
								code.attr('width',width);
							} 
							if (height > 0) {
								code.attr('height', height);
							}
							//var img = embed_to_img(code);

							insertHtmlCross(code[0].outerHTML, selection);
							$('.EX_popup').hide();
							win.focus();
						}
						break;

					case 'insertOrderedList':
					case 'InsertUnorderedList':
					case 'underline' :
					case 'superscript':
					case 'subscript':
					case 'italic':
					case 'bold':
						doc.execCommand(cmd,false , null);
						win.focus();
						getPosition();
						break;
					default :
						//console.log('ERROR : 미등록 명령 ('+ cmd +')');
						break;
				}
				
			}

			return this.each(function() {
				//console.log(this);
				// 폼서밋시 textarea 에 폼값을 넘겨준다
				var form = $(this).closest('form');
				form.submit(function(e) {
					FrameToSource();
				});
	
				/* 멘뉴 클릭 핸들러 */
				opt.frame.menu.delegate('button','click', function(e) {
					e.preventDefault();
					var cmd = $(this).attr('data-command'); 
					switch (cmd) {
						case 'backColor' :
						case 'fontColor' :
							if (popup[cmd] == undefined) {
								ColorPicker.create(this);
							} else {
								popup.toggle(this);
							}
							break;
						case 'fontColor_child':
						case 'backColor_child':
							$(this).closest('div').find('input').val($(this).attr('data-value'));
							$(this).closest('div').find('.inputColorDiv button').click();
							break;
						case 'backColor_finish':
						case 'fontColor_finish' :
							var value = $(this).prev('input').val();
							$(this).attr('data-value' ,value);
							exec(this);
							break;
						case 'insertTable' :
							if (popup[cmd] == undefined) {
								TableForm.create(this);
							} else {
								popup.toggle(this);
							}
							break;
						case 'createLink' :
							if (popup[cmd] == undefined) {
								LinkForm.create(this);
							} else {
								popup.toggle(this);
							}
							break;
						case 'InsertYoutube' :
							if (popup[cmd] == undefined) {
								SwfForm.create(this);
							} else {
								popup.toggle(this);
							}
							break;
						case 'InsertImg':
							Modal.Images.dialogOpen();
							break;
						default :
							$(this).toggleClass('active');
							exec(this);
							break;
					}
				});
				// 셀렉트 선택 핸들러
				opt.frame.menu.find('select').change(function(e) {
					exec(this);
				});
				/*
				$('body').delegate('select', 'change', function(e){
					var me = $(this);
					var value = $(this).val();
					$(this).find('option').removeAttr('selected');
					$(this).find('option').each(function(idx, el) {
						if (el.value == value) {
							$(el).attr('selected','selected');
							me.val(value);
						}
					});
					
				});
				*/
			});
		}
	});
})(jQuery);