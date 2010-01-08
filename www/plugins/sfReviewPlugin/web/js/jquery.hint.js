/**
* @author Remy Sharp
* @url http://remysharp.com/2007/01/25/jquery-tutorial-text-box-hints/
*/
function removeHint(f, blurClass){
	var $input = $(f),
    title = $input.attr('title'),
    $form = $(f+":form"),
    $win = $(window);
	
    if ($input.val() === title && $input.hasClass(blurClass)) {
    	$input.val('').removeClass(blurClass);
    }	
    
    return false;
}

function subscribeHint(f, blurClass){
    // get jQuery version of 'this'
    var $input = $(f),
    
    // capture the rest of the variable to allow for reuse
      title = $input.attr('title'),
      $form = $(f+":form"),
      $win = $(window);

    function remove() {
    	removeHint(f, blurClass);
    }

    // only apply logic if the element has the attribute
    if (title) { 
      // on blur, set value to title attr if text is blank
      $input.blur(function () {
        if ($input.val() === '') {
            $input.val('tal');
          $input.val(title).addClass(blurClass);
        }
      }).focus(remove).blur(); // now change all inputs to title
      
      // clear the pre-defined text when form is submitted
      $form.submit(remove);
      $win.unload(remove); // handles Firefox's autocomplete
    }
}

(function ($) {
	$.fn.hint = function (blurClass) {
	  if (!blurClass) { 
	    blurClass = 'blur';
	  }
	    
	  return this.each(function () {
		  subscribeHint(this, blurClass);
	  });
	};
})(jQuery);