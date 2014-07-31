<?php

session_start();


if (isset($_GET['clear'])) {
  $_SESSION['colours'] = array();
}

if (isset($_GET['color'])) {
  $color = $_GET['color'];
} else {
  $color = '777777';
}

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

if (!isset($_SESSION['colours'])) {
  $_SESSION['colours'] = array();
}

$_SESSION['colours'][] = $color;

?>
<a href="?clear=1">Clear</a>

<br><br>

<a href="?color=<?php print $color; ?>" style="background-color:#<?php echo $color; ?>;"></a>
<br><br><br><br><br><br>
<?php

// Ensure the original color is still present?
$colors[] = $color;

for ($i = 0; $i < 15; ++$i) {
  $color = change_color($color, rand(1, 3));
  $colors[] = $color;
}

//echo '<pre>' . print_r($colors, true) . '</pre>';

$tmp_colors = array();

$hue[] = array();
$sat[] = array();
$val[] = array();

foreach ($colors as $id => $color) {

  $rgb = hex2rgb($color);

  //echo '<pre>' . print_r($hsv, true) . '</pre>';

  //$luminosity = $rgb['red'] * .3 + $rgb['green'] * .59 + $rgb['blue'] * .11;
  $hsl = rgbToHsl($rgb['red'], $rgb['green'], $rgb['blue']);
  $hsv = rgbtohsv($rgb['red'], $rgb['green'], $rgb['blue']);

  //$tmp_colors[($hsl['lightness']) * 100] = $color;
  //$rgb['red'] + $rgb['green'] + $rgb['blue']
  //Gimp $luminance http://gimp-savvy.com/BOOK/index.html?node54.html
  $luminance = ($rgb['red'] * 0.3) + ($rgb['green'] * 0.59) + ($rgb['blue'] * 0.11);
  $tmp_colors[$luminance] = $color;

  $hue[$id] = $hsv['hue'];
  $sat[$id] = $hsv['saturation'];
  $val[$id] = $hsv['value'];

}

//Sort in ascending order by H, then S, then V and recompile the array
//array_multisort($hue, SORT_ASC, $sat, SORT_ASC, $val, SORT_ASC, $colors);

$colors = $tmp_colors;
ksort($colors);

//print_r($colors);

/*usort($colors,function ($rgb1,$rgb2){
  $red1 = hexdec(substr($rgb1,0,2));
  $green1 = hexdec(substr($rgb1,2,2));
  $blue1 = hexdec(substr($rgb1,4,2));

  $red2 = hexdec(substr($rgb2,0,2));
  $green2 = hexdec(substr($rgb2,2,2));
  $blue2 = hexdec(substr($rgb2,4,2));

  return ($red1+$green1+$blue1) - ($red2+$green2+$blue2);
});*/

//echo '<pre>' . print_r($tmp_colors, true) . '</pre>';
//usort($colors, "color_compare");

foreach ($colors as $color) {
  ?><a href="?color=<?php print $color; ?>" style="background-color:#<?php echo $color; ?>;"></a><?php
}
?>
<br><br><br><br><br><br>
<?php

foreach ($_SESSION['colours'] as $older_colors) {
  ?><div style="background-color:#<?php echo $older_colors; ?>;"></div><?php
}


?>
</body></html><?php

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

function rgbtohsv($r,$g,$b) {
  //Convert RGB to HSV
  $r /= 255;
  $g /= 255;
  $b /= 255;
  $min = min($r,$g,$b);
  $max = max($r,$g,$b);

  switch($max) {
    case 0:
      $h = $s = $v = 0;
      break;
    case $min:
      $h = $s = 0;
      $v = $max;
      break;
    default:
      $delta = $max - $min;
      if($r == $max) {
        $h = 0 + ($g - $b) / $delta;
      } elseif($g == $max) {
        $h = 2 + ($b - $r) / $delta;
      } else {
        $h = 4 + ($r - $g) / $delta;
      }
      $h *= 60;
      if($h < 0 ) $h += 360;
      $s = $delta / $max;
      $v = $max;
  }
  return array('hue' => $h, 'saturation' => $s, 'value' => $v);
}

function hsvtorgb($h,$s,$v) {
  //Convert HSV to RGB
  if($s == 0) {
    $r = $g = $b = $v;
  } else {
    $h /= 60.0;
    $s = $s;
    $v = $v;

    $hi = floor($h);
    $f = $h - $hi;
    $p = ($v * (1.0 - $s));
    $q = ($v * (1.0 - ($f * $s)));
    $t = ($v * (1.0 - ((1.0 - $f) * $s)));

    switch($hi) {
      case 0: $r = $v; $g = $t; $b = $p; break;
      case 1: $r = $q; $g = $v; $b = $p; break;
      case 2: $r = $p; $g = $v; $b = $t; break;
      case 3: $r = $p; $g = $q; $b = $v; break;
      case 4: $r = $t; $g = $p; $b = $v; break;
      default: $r = $v; $g = $p; $b = $q; break;
    }
  }
  return array(
    (integer) ($r * 255 + 0.5),
    (integer) ($g * 255 + 0.5),
    (integer) ($b * 255 + 0.5)
  );
}

function hex2rgb($hex) {
  $hex = str_replace("#", "", $hex);

  if(strlen($hex) == 3) {
    $r = hexdec(substr($hex,0,1).substr($hex,0,1));
    $g = hexdec(substr($hex,1,1).substr($hex,1,1));
    $b = hexdec(substr($hex,2,1).substr($hex,2,1));
  } else {
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));
  }
  return array(
    'red' => $r,
    'green' => $g,
    'blue' => $b
  );
}

function rgbToHsl( $r, $g, $b ) {

  $r /= 255;
  $g /= 255;
  $b /= 255;

  $max = max( $r, $g, $b );
  $min = min( $r, $g, $b );

  $h;
  $s;
  $l = ( $max + $min ) / 2;
  $d = $max - $min;

  if( $d == 0 ){
    $h = $s = 0; // achromatic
  } else {
    $s = $d / ( 1 - abs( 2 * $l - 1 ) );

    switch( $max ){
      case $r:
        $h = 60 * fmod( ( ( $g - $b ) / $d ), 6 );
        if ($b > $g) {
          $h += 360;
        }
        break;

      case $g:
        $h = 60 * ( ( $b - $r ) / $d + 2 );
        break;

      case $b:
        $h = 60 * ( ( $r - $g ) / $d + 4 );
        break;
    }
  }

  return array( 'hue' => round( $h, 2 ), 'saturation' => round( $s, 2 ), 'lightness' => round( $l, 2 ) );
}

function hslToRgb( $h, $s, $l ){
  $r = 0;
  $g = 0;
  $b = 0;

  $c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
  $x = $c * ( 1 - abs( fmod( ( $h / 60 ), 2 ) - 1 ) );
  $m = $l - ( $c / 2 );

  if ( $h < 60 ) {
    $r = $c;
    $g = $x;
    $b = 0;
  } else if ( $h < 120 ) {
    $r = $x;
    $g = $c;
    $b = 0;
  } else if ( $h < 180 ) {
    $r = 0;
    $g = $c;
    $b = $x;
  } else if ( $h < 240 ) {
    $r = 0;
    $g = $x;
    $b = $c;
  } else if ( $h < 300 ) {
    $r = $x;
    $g = 0;
    $b = $c;
  } else {
    $r = $c;
    $g = 0;
    $b = $x;
  }

  $r = ( $r + $m ) * 255;
  $g = ( $g + $m ) * 255;
  $b = ( $b + $m  ) * 255;

  return array( 'red' => floor( $r ), 'green' => floor( $g ), 'blue' => floor( $b ) );
}


function randomcolor() {
  //Return an RGB array
  $r = ceil(rand(0,255));
  $g = ceil(rand(0,255));
  $b = ceil(rand(0,255));
  return array($r,$g,$b);
}