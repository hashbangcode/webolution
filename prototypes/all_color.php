<?php

function blend_colors($color1, $color2) {

  $rgb1 = str_split($color1, 1);

  //shuffle($rgb1);

  $key1 = array_rand($rgb1);

  $rgb2 = str_split($color2, 1);

  //shuffle($rgb2);

  $key2 = array_rand($rgb2);

  $rgb1[$key1] = $rgb2[$key2];

  return implode($rgb1);
}

function change_color($color, $amount = 1) {
  $rgb = str_split($color, 2);
  $key = array_rand($rgb);
  $operators = array('add', 'subtract');
  $value = call_user_func_array($operators[array_rand($operators)], array(hexdec($rgb[$key]), rand(0, $amount)));
  if (0 > $value) {
    $value = 0;
  } else if (255 < $value) {
    $value = 255;
  }

  $rgb[$key] = str_pad(dechex($value), 2, '0', STR_PAD_LEFT);

  return implode($rgb);
}

function add($x, $y) {
  return $x + $y;
}
function subtract($x, $y) {
  return $x - $y;
}


?><html>
<style>
div {
  height:10px;
  width:10px;
  float:left;
}
</style>
</html>
<body>

<?php
$color = array();
$color[0] = '123456';

for ($i = 1; $i < 10000; ++$i) {
  $changed_color = change_color($color[$i - 1], rand(1, 1));
  $color[$i] = $changed_color;

  $blended_color = blend_colors($color[$i], $color[$i - 1]);
  $color[$i] = $blended_color;

  ?><div style="background-color:#<?php echo $color[$i]; ?>;"></div><?php
  //echo $changed_color . ' ' . $blended_color . '<br>';
}
?>

</body>
