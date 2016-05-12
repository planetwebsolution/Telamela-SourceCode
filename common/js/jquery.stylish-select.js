/*
Stylish Select 0.3 - $ plugin to replace a select drop down box with a stylable unordered list
http://scottdarby.com/

Copyright (c) 2009 Scott Darby

Requires: $ 1.3

Licensed under the GPL license:
http://www.gnu.org/licenses/gpl.html
*/

function removeWhiteSpace(str)
{
	if(str != '')
	{
		str = str.replace(/\s+/ig, ' ');
		//str = str.replace(/\-+/ig, '-');
		return str.replace(/[^a-z0-9A-Z\-]/ig, ' ');
	}
}

function trim (str, charlist) {
		str = removeWhiteSpace(str);
    var whitespace, l = 0, i = 0;
    str += '';
    
    if (!charlist) {
        // default list
        whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    } else {
        // preg_quote custom list
        charlist += '';
        whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
    }
    
    l = str.length;
    for (i = 0; i < l; i++) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(i);
            break;
        }
    }
    
    l = str.length;
    for (i = l - 1; i >= 0; i--) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(0, i + 1);
            break;
        }
    }
    
    return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}


(function($){

	//add class of js to html tag
	$('html').addClass('js');

	//create cross-browser indexOf
	Array.prototype.indexOf = function (obj, start) {
		for (var i = (start || 0); i < this.length; i++) {
			if (this[i] == obj) {
				return i;
			}
		}
	}
	
	//utility methods
	$.fn.extend({
		getSetSSValue: function(value){
						if (value){
							//set value and trigger change event
							$(this).val(value).change();
							return this;
						} else {
							return selText = $(this).find(':selected').text();
						}
					},
		resetSS: function(){
						$this = $(this);
						$this.next().remove();
						//unbind all events and redraw
						$this.unbind().sSelect();
					}
	});

	$.fn.sSelect = function(options) {
		
			return this.each(function(){
			
			var defaults = {
				defaultText: PLEASE_SELECT,
				animationSpeed: 0, //set speed of dropdown
				ddMaxHeight: '' //set css max-height value of dropdown
			};

			//initial variables
			var opts = $.extend(defaults, options),
			
				$input = $(this),
				$containerDivText = $('<div class="selectedTxt"></div>'),
				$containerDiv = $('<div class="newListSelected" tabindex="0"></div>'),
				$newUl = $('<ul class="newList"></ul>'),
				itemIndex = -1,
				currentIndex = -1,
				keys = [],
				prevKey = false,
				newListItems = '',
				prevented = false;
				
			//build new list
			$containerDiv.insertAfter($input);
			$containerDivText.prependTo($containerDiv);
			$newUl.appendTo($containerDiv);
			$input.hide();
		
			//test for optgroup
			if ($input.children('optgroup').length == 0){
				$input.children().each(function(i){
					//alert($(this).text());
					var option = $(this).text();
					var optionvalue = $(this).attr('value');
					//add first letter of each word to array
					keys.push(option.charAt(0).toLowerCase());
					if ($(this).attr('selected') == true){

						opts.defaultText = option;
						
						currentIndex = i;
						
					}
				
                        newListItems += '<li value='+optionvalue+' onclick="getvalue(\''+optionvalue+'\');">'+trim(option)+'</li>';
				});
				//add new list items to ul
				$newUl.html(newListItems);
				newListItems = '';
				//cache list items object
				var $newLi = $newUl.children();
								
			} else { //optgroup
				$input.children('optgroup').each(function(i){
				
					var optionTitle = $(this).attr('option'),
					
						$optGroup = $('<li class="newListOptionTitle">'+optionTitle+'</li>');
					
					$optGroup.appendTo($newUl);

					var $optGroupList = $('<ul></ul>');

					$optGroupList.appendTo($optGroup);

					$(this).children().each(function(){
						++itemIndex;
						var option = $(this).text();
						//add first letter of each word to array
						keys.push(option.charAt(0).toLowerCase());
						if ($(this).attr('selected') == true){
							opts.defaultText = option;
							currentIndex = itemIndex;
							
						}
						newListItems += '<li>'+trim(option)+'</li>';
					});
					//add new list items to ul
					$optGroupList.html(newListItems);
					
					newListItems = '';
				});
				//cache list items object
				var $newLi = $newUl.find('ul li');
			
			}
			
			//get heights of new elements for use later
			var newUlHeight = $newUl.height(),
				containerHeight = $containerDiv.height(),
				newLiLength = $newLi.length;
		
			//check if a value is selected
			if (currentIndex != -1){
				navigateList(currentIndex, true);
			} else {
				//set placeholder text
				$containerDivText.text(opts.defaultText);
			}

			//decide if to place the new list above or below the drop-down
			function newUlPos(){
				var containerPosY = $containerDiv.offset().top,
					docHeight = jQuery(window).height(),
					scrollTop = jQuery(window).scrollTop();

					//if height of list is greater then max height, set list height to max height value
					if (newUlHeight > parseInt(opts.ddMaxHeight)) {
						newUlHeight = parseInt(opts.ddMaxHeight);
					}	
					//	CHANGED CODE -- TO GET ddMaxHeight. ---------------
					newUlHeight = parseInt(opts.ddMaxHeight);
					//----------------------------------------------------
				containerPosY = containerPosY-scrollTop;

				if (containerPosY+newUlHeight >= docHeight){
					$newUl.css({top: '-'+newUlHeight+'px', height: newUlHeight});
					$input.onTop = true;
				} else {
					//alert('--->'+containerHeight+'<---\n--->'+newUlHeight+'<----');
					if(isNaN(newUlHeight))
					{
						//alert('hi');
						newUlHeight = 200+'px';
					}
					
					$newUl.css({top: containerHeight+'px', height: newUlHeight, display: 'none'});
					//$newUl.css({top: newUlHeight+'px', height: newUlHeight});
					$input.onTop = false;
				}
			}

			//run function on page load
			newUlPos();
			
			//run function on browser window resize
			$(window).resize(function(){
				newUlPos();
			});
			
			$(window).scroll(function(){
				newUlPos();
			});

			//positioning
			function positionFix(){
				$containerDiv.css('position','relative');
			}

			function positionHideFix(){
				$containerDiv.css('position','static');
			}
			
			$containerDivText.click(function(){
			
				if ($newUl.is(':visible')){
					$newUl.hide();
					positionHideFix()
					return false;
				}

				$containerDiv.focus();

				//show list
				$newUl.slideDown(opts.animationSpeed);
				positionFix();
				//scroll list to selected item
				$newUl.scrollTop($input.liOffsetTop);

			});
			
			$newLi.hover(
			  function (e) {
				var $hoveredLi = $(e.target);
				$hoveredLi.addClass('newListHover');
			  },
			  function (e) {
				var $hoveredLi = $(e.target);
				$hoveredLi.removeClass('newListHover');
			  }
			);

			$newLi.click(function(e){
				var $clickedLi = $(e.target);
				//update counter
				currentIndex = $newLi.index($clickedLi);
				//remove all hilites, then add hilite to selected item
				prevented = true;
				navigateList(currentIndex);
				$newUl.hide();
				$containerDiv.css('position','static');//ie
			});

			function navigateList(currentIndex, init){

				//get offsets
				var containerOffsetTop = $containerDiv.offset().top,
					liOffsetTop = $newLi.eq(currentIndex).offset().top,
					ulScrollTop = $newUl.scrollTop();
				
				//get distance of current li from top of list				
				if ($input.onTop == true){
					//if list is above select box, add max height value
					$input.liOffsetTop = (((liOffsetTop-containerOffsetTop)-containerHeight)+ulScrollTop)+parseInt(opts.ddMaxHeight);
				} else {
					$input.liOffsetTop = ((liOffsetTop-containerOffsetTop)-containerHeight)+ulScrollTop;
				}
				
				//scroll list to focus on current item
				$newUl.scrollTop($input.liOffsetTop);
				
				$newLi.removeClass('hiLite')
					.eq(currentIndex)
					.addClass('hiLite');
				var text = $newLi.eq(currentIndex).text();
				
				var text_length = text.length;
				
				text1 = text;
				
                                
				if (init == true){
					$input.val(text);
					$containerDivText.text(text1);
					return false;
				}
				
				$input.val(text).change();
				$containerDivText.text(text1);

			};

			$input.change(function(event){
					$targetInput = $(event.target);
					//stop change function from firing 
					if (prevented == true){
						prevented = false;
						return false;
					}
					$currentOpt = $targetInput.find(':selected');
					currentIndex = $targetInput.find('option').index($currentOpt);
					navigateList(currentIndex, true);
				}
			);
			
			//handle up and down keys
			function keyPress(element) {
				//when keys are pressed
				element.onkeydown = function(e){
					if (e == null) { //ie
						var keycode = event.keyCode;
					} else { //everything else
						var keycode = e.which;
					}
					
					//prevent change function from firing
					prevented = true;

					switch(keycode)
					{
					case 40: //down
					case 39: //right
						incrementList();
						return false;
						break;
					case 38: //up
					case 37: //left
						decrementList();
						return false;
						break;
					case 33: //page up
					case 36: //home
						gotoFirst();
						return false;
						break;
					case 34: //page down
					case 35: //end
						gotoLast();
						return false;
						break;
					case 13:
					case 27:
						$newUl.hide();
						positionHideFix();
						return false;
						break;
					}

					//check for keyboard shortcuts
					keyPressed = String.fromCharCode(keycode).toLowerCase();
					var currentKeyIndex = keys.indexOf(keyPressed);
					if (typeof currentKeyIndex != 'undefined') { //if key code found in array
						++currentIndex;
						currentIndex = keys.indexOf(keyPressed, currentIndex); //search array from current index
						if (currentIndex == -1 || currentIndex == null || prevKey != keyPressed) currentIndex = keys.indexOf(keyPressed); //if no entry was found or new key pressed search from start of array
						navigateList(currentIndex);
						//store last key pressed
						prevKey = keyPressed;
						return false;
					}
				}
			}

			function incrementList(){
				if (currentIndex < (newLiLength-1)) {
					++currentIndex;
					navigateList(currentIndex);
				}
			}

			function decrementList(){
				if (currentIndex > 0) {
					--currentIndex;
					navigateList(currentIndex);
				}
			}

			function gotoFirst(){
				currentIndex = 0;
				navigateList(currentIndex);
			}
			
			function gotoLast(){
				currentIndex = newLiLength-1;
				navigateList(currentIndex);
			}

			$containerDiv.click(function(){
				keyPress(this);
			});

			$containerDiv.focus(function(){
				$(this).addClass('newListSelFocus');
				keyPress(this);
			});
			
			//hide list on blur
			$containerDiv.blur(function(){
			   $(this).removeClass('newListSelFocus');
			   $newUl.hide();
			   positionHideFix();
			});

			//add classes on hover
			$containerDivText.hover(function(e) {
				var $hoveredTxt = $(e.target);
				$hoveredTxt.parent().addClass('newListSelHover');
			  }, 
			  function(e) {
				var $hoveredTxt = $(e.target);
				$hoveredTxt.parent().removeClass('newListSelHover');
			  }
			);

			//reset left property and hide
			$newUl.css('left','0').hide();
			
		});
	  
	};

})(jQuery);