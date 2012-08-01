<?php include 'header.php'; ?>

<?php
$colleges = $courses_client->search('curriculum','college_abbreviation',$_GET["s"]);
$decoded_colleges = json_decode($colleges);
$curriculum = $decoded_colleges->{'Curricula'};
?>

<div class="page-header">
  <h1><a title="Courses Home" href="/cheiland/courses">Courses</a> - Curriculum: <?php echo $_GET["s"] ?></h1> 
</div>

<?php foreach ( $curriculum as $curr ) { ?>
    <div class="item">
      <a title="<?php echo $curr->{'CurriculumFullName'}; ?>" href="course.php?s=<?php echo urlencode($curr->{'CurriculumAbbreviation'}) ?>" ><?php echo $curr->{'CurriculumFullName'}; ?>
       <br /><span class="smallprint">
       <?php echo $curr->{'CurriculumAbbreviation'} ?></span></a>
    </div>
<?php } ?>

<?php include 'footer.php'; ?>
