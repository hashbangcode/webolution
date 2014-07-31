<?php

$color1 = '111111';
$color2 = '222222';


function blend_colors($color1, $color2) {

  $rgb1 = str_split($color1, 1);
  $key1 = array_rand($rgb1);

  $rgb2 = str_split($color2, 1);
  $key2 = array_rand($rgb2);

  $rgb1[$key1] = $rgb2[$key2];

  return implode($rgb1);
}


?><html>
<style>
div {
  height:50px;
  width:50px;
  float:left;
}
</style>
</html>
<body>

<?php
for ($i = 0; $i < 50; ++$i) {
  print blend_colors($color1, $color2) . "<br>";
}
?>

</body>
