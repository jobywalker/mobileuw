<?php include 'header.php'; ?>

<div class="page-header">
  <h1><a title="Courses Home" href="/cheiland/courses">Courses</a> - Search: <?php echo $_GET["s"] ?></h1> 
</div>

  <div id="result"></div>

<?php
if ($_GET["s"])
{
    $cour = json_decode($courses_client->search('course','course_title_contains',$_GET["s"]));
    foreach ($cour->{'Courses'} as $course)
    {
?>
  <div class="item">
    <a class="course" href="<?php echo $course->{'Href'} ?>"><?php echo $course->{'CourseTitleLong'} ?> (<?php echo $course->{'CourseNumber'} ?>)</a>
  </div>
<?php
    }
}
?>

<?php include 'footer.php'; ?>
