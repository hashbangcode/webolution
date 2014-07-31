<?php

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


$color = '123456';

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
<div style="background-color:#<?php echo $color; ?>;"></div>

<?php
for ($i = 0; $i < 10000; ++$i) {
  $color = change_color($color, rand(1, 50));
  ?><div style="background-color:#<?php echo $color; ?>;"></div><?php
}
?>

</body>
