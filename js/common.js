$(window).load(function () {
	var alerty = $('#alertMessage').outerHeight();
	$("body").css("background-position", "0" + alerty + "px");
});

$(function () {

    $('[href=#]').removeAttr('href'); //prevent ios nav bar from popping down

    var lip = $('#lip'),
        linkRotator = $('#linkRotator'),
        ul = linkRotator.find('ul').first(),
        linkImage = $('#linkArrowIcon'),
        topnav = $('#top-nav'),
        search = $('#search form'),
        links = linkImage.attr('src'),
        closeImage = $('#menuClose'),
        searchbtn = $("#searchicon").wrap('<a id="searchicon-wrapper">').parent(),
        menubtn = $("#listicon").wrap('<a id="listicon-wrapper">').parent();

	ul.hide();
	linkImage.click(function () {
	    ul.show();
		var height = (linkRotator.height() !== 0) ? 0 : ul.outerHeight();
		linkImage.addClass('hideLinkAnchor').one('webkitTransitionEnd', function () {
    		linkRotator.toggleClass('rotateLip').css('height', height);
    		});
		return false;
	});

	closeImage.click(function () {
		if (linkRotator.height() !== 0) {
			linkRotator.css('height', 0).one('webkitTransitionEnd', function () {				
				ul.hide();
				linkImage.removeClass('hideLinkAnchor');
			});
		}
		return false;
	});

	// [TODO] clean up
	searchbtn.click(function (e) {
        e.preventDefault();
		search.toggleClass("activate");
		search.css('visibility', 'visible');
		if (topnav.hasClass('activate')) {
			topnav.toggleClass("activate");		
		}		
		return false;
	});
	
	menubtn.click(function (e) {
        e.preventDefault();
		topnav.toggleClass("activate");		 
		topnav.css('visibility', 'visible');
		if (search.hasClass('activate')) {
			search.toggleClass("activate");		
		}		
		return false;
	});
	
	/** Accessibility **/
	
	topnav.css('visibility', 'hidden').on('webkitTransitionEnd', function () {if (!topnav.hasClass('activate') && !search.hasClass('activate') || search.hasClass('activate')) {
       topnav.css('visibility', 'hidden');
    }   
    });
    
    search.css('visibility', 'hidden').on('webkitTransitionEnd', function () {
        if (!topnav.hasClass('activate') && !search.hasClass('activate') || topnav.hasClass('activate')) {
            search.css('visibility', 'hidden');
        }
    });
  
});




