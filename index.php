<?php

require_once('includes/Color.php');
require_once('includes/ColorCollection.php');

session_start();

if (isset($_GET['clear'])) {
  $_SESSION['colours'] = array();
}

if (!isset($_SESSION['colours'])) {
  $_SESSION['colours'] = array();
}

if (isset($_GET['color'])) {
  $color = $_GET['color'];
} else {
  $color = '777777';
}
$_SESSION['count']++;
$_SESSION['colours'][] = $color;

?><html>
<style>
  a {
    height: 50px;
    width: 50px;
    display: block;
    float: left;
  }

  div {
    height:10px;
    width:10px;
    float:left;
  }

</style>
</html>
  <body>
  <?php

  ?>
  <a href="?clear=1">Clear</a>

  <br><br>

  <a href="?color=<?php print $color; ?>" style="background-color:#<?php echo $color; ?>;"></a>
  <br><br><br><br><br><br>
  <?php

  $colors = new ColorCollection();
  for ($i = 0; $i < 15; ++$i) {
    $obj_color = Color::generateFromHex($color);
    $obj_color->mutateColor(5);
    $colors->add($obj_color);
  }

  $colors->sort();

  foreach ($colors->getColors() as $obj_color) {
    ?><a href="?color=<?php echo $obj_color->getHex(); ?>" style="background-color:#<?php echo $obj_color->getHex(); ?>;"></a><?php
  }
  ?>
  <br><br><br><br><br><br>
  <?php

  //echo '<pre>'.print_r($_SESSION, true).'</pre>';

  foreach ($_SESSION['colours'] as $older_colors) {
    ?><div style="background-color:#<?php echo $older_colors; ?>;"></div><?php
  }
print '<br><br>';
include('Tests/evolve_test.html');
?>
</body></html>