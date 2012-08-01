$(function () {
    'use strict';

    $.getJSON('//gdata.youtube.com/feeds/api/users/uwhuskies/uploads?v=2&alt=jsonc',
        function (json) {
            //console.log(json);
            $.each(json.data.items, function (i, items) {
                var j = 'row-' + Math.floor(i / 3);
                if (i % 3 === 0) {
                    if (i !== 0) {
                        $('#videos').append('</div>'); 
                    }
                    $('#videos').append('<div class="row-fluid" id="' + j + '">');
                }
                $('#' + j).append('<div class="span4" id="video-' + i + '"><a href="' + this.player.default + '">' + 
                
                    '<div class="youtube-thumbnail">' + 
                    '<img src="http://i.ytimg.com/vi/' + this.id  + 
                    '/hqdefault.jpg"/>' +                      
                    '<h2 class="overlay-title"> <span> <i class="icon-film" style="color:#CCCCCC;"></i>  ' + this.title + '</span></h2></div></a></div>');
            
            });
        });
});