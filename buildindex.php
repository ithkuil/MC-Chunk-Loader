<?php

// I don't know what this file is for. -endenizen

ini_set('memory_limit', '128M');
require_once('readchunk.php');

function trimpath($p) {
  $pos = strpos($p, 'world/');
  return substr($p, $pos+6);
}

function process_dir($dir,$recursive = FALSE) {
  if (is_dir($dir)) {
    for ($list = array(),$handle = opendir($dir); (FALSE !== ($file = readdir($handle)));) {
      if (($file != '.' && $file != '..' && $file != 'level.dat.json' && $file != 'level.dat.json.gz') && (file_exists($path = $dir.'/'.$file))) {
        if (is_dir($path) && ($recursive)) {
          $list = array_merge($list, process_dir($path, TRUE));
        } else {
          $entry = array('filename' => $file);
          
          do if (!is_dir($path)) {
            $pos = strpos($path, '.b6z');
            $pos2 = strpos($path, '.gz');
            if ($pos >0 | $pos2>0) {
              unlink($path);
              continue;
            } 

            $pos3 = strpos($file, 'evel.dat');
            if ($pos3>0) continue;

            // Won't work with new maps
            // $entry['dat'] = readchunk($path);
            $entry['filename'] = trimpath($path);
 
            break;
          } else {
            break;
          } while (FALSE);

          $list[] = $entry;
        }
      }
    }
    closedir($handle);
    return $list;
  } else return FALSE;
}
 
$wf = $_SERVER['SCRIPT_FILENAME'];
$pos = strrpos($wf, '/');
$wd = substr($wf, 0, $pos);  

if (file_exists($wd.'/chunks.json')) {
  $result = file_get_contents($wd.'/chunks.json');
} else {
  $result = json_encode(process_dir($wd . '/world', TRUE));
  file_put_contents($wd.'/chunks.json', $result);
}

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');  
echo $result; 

?>
