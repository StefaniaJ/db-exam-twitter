<?php
// ini_set('display_errors', 0);
// CSS

$sCss = trim(file_get_contents('../css/main.css')).PHP_EOL;

foreach(glob('./*') as $filename){
  echo '<div>'.$filename.'</div>';
  if(stripos($filename, 'app.css')){ continue; }
  if(stripos($filename, '.css')){
    $sCss = trim($sCss.trim(file_get_contents($filename))).PHP_EOL;
  }
}
file_put_contents('./app.css', $sCss);


// JAVASCRIPT
$sJs = trim(file_get_contents('../js/main.js')).PHP_EOL;

foreach(glob('./*') as $filename){
  echo '<div>'.$filename.'</div>';
  if(stripos($filename, 'app.js')){ continue; }
  if(stripos($filename, '.js')){
    $sJs = trim($sJs.trim(file_get_contents($filename))).PHP_EOL;
  }
}
file_put_contents('./app.js', $sJs);
exit();