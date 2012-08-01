<?php
include 'courseClient.php';

$courses_client = new courseClient(array(
 'service_url'              => 'https://ws.admin.washington.edu/student/v4/public/',
 'debug'                    => False,
 ));

// /student/v4/public/course/2012,spring,B%20ART,121.json
$strUrl = substr($_POST['url'], 25);

$course = $courses_client->readCourse($strUrl);
$decoded_course = json_decode($course);

$sectionA = $courses_client->readCourse(str_replace('.json','/A.json',$strUrl));
$decoded_sectionA = false;
if ($sectionA)
    $decoded_sectionA = json_decode($sectionA);

$sectionB = $courses_client->readCourse(str_replace('.json','/B.json',$strUrl));
$decoded_sectionB = false;
if ($sectionB)
    $decoded_sectionB = json_decode($sectionB);


// print_r($decoded_sectionA);
// print_r($decoded_course);
// $decoded_course->{'Current'};

?>
<div class="hidden" id="title"><?php echo $decoded_course->{'CourseTitleLong'} ?></div>

<div class="content-full content-padded">
  <div>
    <p><strong>Course Description:</strong> <?php echo $decoded_course->{'CourseDescription'} ?></p>
  </div>
  <div>
    <p><strong>Course:</strong> <?php echo $decoded_course->{'Curriculum'}->{'CurriculumAbbreviation'}.' '.$decoded_course->{'CourseNumber'} ?></p> 
    <p><strong>Credits:</strong> <?php echo $decoded_course->{'MinimumTermCredit'} ?></p> 
    <p><strong>Term:</strong> <?php echo ucfirst($decoded_course->{'Curriculum'}->{'Quarter'}).' '.$decoded_course->{'Curriculum'}->{'Year'} ?></p>
  </div>
<?php if ($decoded_sectionA) { ?>
  <div>
    <p>Section A</p>
    <?php foreach ($decoded_sectionA->{'Meetings'} as $meeting) { ?>
      <p><strong> <?php echo $meeting->{'DaysOfWeek'}->{'Text'}.' '.$meeting->{'StartTime'}.' - '.$meeting->{'EndTime'} ?></strong></p>
        <?php foreach ($meeting->{'Instructors'} as $instructor) { ?>
          <p><strong>Instructor:</strong> <?php echo $instructor->{'Person'}->{'Name'} ?></p>
          <p><strong>Location:</strong> <?php echo $meeting->{'Building'}.' '.$meeting->{'RoomNumber'} ?></p>
        <?php } ?> 
    <?php } ?> 
    <p><strong>Enrollment:</strong> <?php echo $decoded_sectionA->{'CurrentEnrollment'}.' out of '.$decoded_sectionA->{'LimitEstimateEnrollment'} ?></p>
  </div>
<?php } ?> 
<?php if ($decoded_sectionB) { ?>
  <div>
    <p>Section B</p>
    <?php foreach ($decoded_sectionB->{'Meetings'} as $meeting) { ?>
      <p><strong> <?php echo $meeting->{'DaysOfWeek'}->{'Text'}.' '.$meeting->{'StartTime'}.' - '.$meeting->{'EndTime'} ?></strong></p>
        <?php foreach ($meeting->{'Instructors'} as $instructor) { ?>
          <p><strong>Instructor:</strong> <?php echo $instructor->{'Person'}->{'Name'} ?></p>
          <p><strong>Location:</strong> <?php echo $meeting->{'Building'}.' '.$meeting->{'RoomNumber'} ?></p>
        <?php } ?> 
    <?php } ?> 
    <p class="content-last"><strong>Enrollment:</strong> <?php echo $decoded_sectionB->{'CurrentEnrollment'}.' out of '.$decoded_sectionB->{'LimitEstimateEnrollment'} ?></p>
  </div>
<?php } ?> 
</div>

<?php
// [CourseCampus] => Bothell [CourseCollege] => UW Bothell [CourseComment] => CLONED FROM ART 190 [CourseDescription] => Builds basic drawing skills, develops understanding of primary concepts which relate to drawing and develops an understanding of the grammar or syntax of two-dimensional language. Students move beyond their current knowledge and abilities and link new skills, concepts, and understandings to creative expressing [CourseNumber] => 121 [CourseTitle] => INTRO TO DRAWING [CourseTitleLong] => INTRODUCTION TO DRAWING [CreditControl] => fixed credit [Curriculum] => stdClass Object ( [Href] => /student/v4/public/curriculum/2012,spring,B%20ART.json [CurriculumAbbreviation] => B ART [Quarter] => spring [Year] => 2012 ) [FirstEffectiveTerm] => stdClass Object ( [Href] => /student/v4/public/term/2007,winter.json [Quarter] => winter [Year] => 2007 ) [GeneralEducationRequirements] => stdClass Object ( [EnglishComposition] => [IndividualsAndSocieties] => [NaturalWorld] => [QuantitativeAndSymbolicReasoning] => [VisualLiteraryAndPerformingArts] => 1 [Writing] => ) [GradingSystem] => credit/no credit or standard [LastEffectiveTerm] => stdClass Object ( [Href] => /student/v4/public/term/9999,autumn.json [Quarter] => autumn [Year] => 9999 ) [MaximumCredit] => 0 [MaximumTermCredit] => 0 [MinimumTermCredit] => 5 )
?>
