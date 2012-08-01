<?php
include 'courseClient.php';

$courses_client = new courseClient(array(
 'service_url'              => 'https://ws.admin.washington.edu/student/v4/public/',
 'debug'                    => False,
 ));

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>UW Courses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="//www.washington.edu/common/bootstrap-2.0.4/css/bootstrap.min.css" type="text/css">
    <!-- Courses Custom -->
    <link rel="stylesheet" href="custom.css" type="text/css" />
    <!-- UW Header Custom -->
    <link rel="stylesheet" href="mobile-header.css" type="text/css" />
  </head>
<body>

<div id="mobileHeader">
  <div id="logo"><a data-analytics="/globa/hn/logo" href="/">
    <img class="headerImg1" src="http://www.washington.edu/static/mobile/image/logo-home-new.png" width="232" alt="UW Logo">
  </a><img id="searchicon" class="headerImg2" src="http://www.washington.edu/static/mobile/image/search.png" width="26" alt="Searchbox" data-analytics="search-trigger" /><img id="listicon" class="headerImg3" src="http://www.washington.edu/static/mobile/image/link-list.png" width="26" alt="Links Dropdown" data-analytics="dashboard-trigger" /></div>
  <div id="top-nav">
    <ul>
      <li><a href="http://www.washington.edu/" title="UW Homepage" data-analytics="/global/hn/home">Home</a></li>
      <li><a title="Information unique to you, all in one place" data-analytics="/global/hn/news" href="/news/">News</a></li>
      <li><a href="http://www.washington.edu/home/peopledir/" data-analytics="/global/hn/directory" title="Phone and postal directories for faculty, staff and students">Directories</a></li>
      <li><a href="http://www.washington.edu/mobile/calendar" title="What's going on around campus?  Find out here." data-analytics="/global/hn/calendar">Calendar</a></li>
      <li><a href="http://uwashington.worldcat.org/m/" title="A wealth of information at your fingertips" data-analytics="/global/hn/libraries">Libraries</a></li>
      <li><a href="http://www.washington.edu/maps/" title="Find your way with these map tools" data-analytics="/global/hn/maps">Maps</a></li>
      <li><a title="Athletics" data-analytics="/global/hn/sports" href="http://www.gohuskies.com">Athletics</a></li>
      <li><a href="http://depts.washington.edu/newscomm/photos/" title="Scenes from the campus community" data-analytics="/global/hn/commphotos">Photos</a></li>
      <li><a title="My UW" data-analytics="/global/hn/myuw" href="http://myuw.washington.edu">MyUW</a></li>
    </ul>
  </div>
  <div id="search">
    <form class="searchform" action="http://www.washington.edu/search" id="searchbox_008816504494047979142:bpbdkw8tbqc" name="form1">
      <div class="wfield">
        <input value="008816504494047979142:bpbdkw8tbqc" name="cx" type="hidden">
        <input value="FORID:0" name="cof" type="hidden">
        <input class="wTextInput" placeholder="Search the UW" title="Search the UW" name="q" type="text">
      </div>
      <input data-analytics="/global/hn/search-action" value="Go" name="sa" class="formbutton" type="submit">
    </form>
  </div>
</div>

<div class="container-fluid">
