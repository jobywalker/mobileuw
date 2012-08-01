<?php include 'header.php'; ?>

<?php
$college = $courses_client->displayJson('college');
$college = json_decode($college);
?>

<div class="page-header">
  <h1><a title="Courses Home" href="/cheiland/courses">Courses</a> - Colleges</h1> 
</div>


<form class="well form-search" action="search.php">
  <label class="hidden" for="s">Search</label>
  <input type="text" class="input-medium search-query" id="s" name="s">
  <button type="submit" class="btn">Search</button>
</form>

<?php foreach ( $college->{'Colleges'} as $coll ) { ?>
    <div class="item">
      <a title="<?php echo urlencode($coll->{'CollegeFullName'}) ?>" href="curriculum.php?s=<?php echo urlencode($coll->{'CollegeAbbreviation'}) ?>" ><?php echo $coll->{'CollegeFullName'}; ?></a>
    </div>
<?php } ?>

<?php include 'footer.php'; ?>
