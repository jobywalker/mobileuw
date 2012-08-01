<?php include 'header.php'; ?>

<?php
$addterm = '';
if (($_GET['year']) and ($_GET['quarter']))
    $addterm = 'year='.$_GET['year'].'&quarter='.$_GET['quarter'].'&';

$colleges = $courses_client->search('course',$addterm.'curriculum_abbreviation',$_GET["s"]);
$decoded_colleges = json_decode($colleges);
$courses = $decoded_colleges->{'Courses'};
?>

<div class="page-header">
  <h1><a title="Courses Home" href="/cheiland/courses">Courses</a> - Curriculum: <?php echo $_GET["s"] ?></h1> 
</div>
  <div id="result"></div>

<?php foreach ( $courses as $course ) { ?>
    <div class="item">
      <a title="<?php echo $course->{'CourseTitle'}; ?> - <?php echo $course->{'CurriculumAbbreviation'}." ".$course->{'CourseNumber'} ?>" class="course" href="<?php echo $course->{'Href'}; ?>">
       <span class="smallprint"><?php echo $course->{'CourseTitle'}; ?></span><br />
       <?php echo $course->{'CurriculumAbbreviation'}." ".$course->{'CourseNumber'} ?></a>
    </div>
<?php } ?>

<?php include 'footer.php'; ?>
