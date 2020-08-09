<div id="left_column">
  <a href="http://localhost:8080/"><img src="./assets/images/header_logo.gif" alt="mitchbarry.com" class="right_align" /></a>
  <div id="leftspacer"></div>
  <a href="http://localhost:8080/index.php" class="right_align">home</a><br />
  <!-- <a href="http://www.mitchbarry.com/about.php" class="right_align">about</a><br />
  <a href="http://www.mitchbarry.com/projects.php" class="right_align">projects</a><br />
  <a href="http://www.mitchbarry.com/android/" class="right_align">android dev</a><br />
  <a href="http://www.mitchbarry.com/fun.php" class="right_align">for fun</a><br />
  <a href="http://www.mitchbarry.com/src/" class="right_align">src</a><br /><br /> -->
  <?php
  if (!isset($_SESSION['username'])) {
  ?>
    <a href="http://localhost:8080/cms/" class="right_align">login/register</a>
  <?php
  } else {
  ?>
    <a href="http://localhost:8080/cms/" class="right_align">cpanel</a><br />
    <a href="http://localhost:8080/cms/logout.php" class="right_align">logout</a>
  <?php
  }
  ?><br /><br />
  <!-- <a href="rss.xml" class="right_align"><img src="http://www.mitchbarry.com/images/rss.jpg" alt="Subscribe to RSS" width="50px" /></a> -->
</div>