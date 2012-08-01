$(document).ready(function() {

  // https://ws.admin.washington.edu/student/v4/public/course/2012,spring,B%20ART,121.json
  $("a.course").click(function(e) {
    e.preventDefault();

    var url = $(this).attr('href');
    $.post('class.php', { url: url }, function(data) {
      // Make sure we hide both for now
      $('.item').hide();
      $('#result').html(data);
      var title = $('div#title').html();
      $('h1').html('Course: '+title);
       console.log(data);
    });

  });

});

