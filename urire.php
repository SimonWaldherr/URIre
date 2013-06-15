<?php

//this is only an example, please use parse_url() instead

function urire ($string) {
  function countChars ($string, $split) {
    $string = explode($split,$string);
    if (gettype($string) === 'array') {
      return count($string) - 1;
    }
    return 0;
  }

  $regex = "/(([a-z]{3,}:\/\/\/?)?([\.:\/?&]+)?([^\.:\/?&]+)?)/";
  preg_match_all($regex, $string, $urlparts['regex'], PREG_SET_ORDER);
  $urlparts['clean'] = array(
    'protocol'      => '',
    'domain'        => '',
    'port'          => '',
    'path'          => '',
    'fileextension' => '',
    'query'         => '',
    'fragment'      => ''
  );

  for ($i = 0; $i < count($urlparts['regex']); $i++) {
    if (countChars($urlparts['regex'][$i][0], '://') === 1) {
      if ($urlparts['regex'][$i][0] == '') {
        $urlparts['clean']['protocol'] = false;
        $urlparts['clean']['domain'] = false;
      } else {
        $temp = explode('://', $urlparts['regex'][$i][0], 2);
        $urlparts['clean']['protocol'] = $temp[0];
        $urlparts['clean']['domain'] = $temp[1];
      }
    } else if ((countChars($urlparts['regex'][$i][0], '/') === 0) && (countChars($urlparts['regex'][$i][0], ':') === 0) && ($urlparts['clean']['path'] === '')) {
      if ($urlparts['regex'][$i][0] == '') {
        $urlparts['clean']['domain'] = false;
      } else {
        $urlparts['clean']['domain'] .= $urlparts['regex'][$i][0];
      }
    } else if ((countChars($urlparts['regex'][$i][0], ':') === 1) && ($urlparts['clean']['path'] === '') && (!is_nan(intval($urlparts['regex'][$i][0], 10)))) {
      if ($urlparts['regex'][$i][0] == '') {
        $urlparts['clean']['port'] = false;
      } else {
        $temp = explode(':', $urlparts['regex'][$i][0], 2);
        $urlparts['clean']['port'] = $temp[1];
      }
    } else if ((countChars($urlparts['regex'][$i][0], '?') === 0) && (countChars($urlparts['regex'][$i][0], '&') === 0) && ($urlparts['clean']['query'] === '')) {
      if (substr($urlparts['regex'][$i][0],0,1) === ':') {
        $urlparts['regex'][$i][0] = substr($urlparts['regex'][$i][0], 1);
      }
      if (countChars($urlparts['regex'][$i][0], '#') === 0) {
        if ($urlparts['regex'][$i][0] == '') {
          $urlparts['clean']['path'] = false;
        } else {
          $urlparts['clean']['path'] .= $urlparts['regex'][$i][0];
        }
      } else {
        if ($urlparts['regex'][$i][0] == '') {
          $urlparts['clean']['path'] = false;
          $urlparts['clean']['fragment'] = false;
        } else {
          $temp = explode('#', $urlparts['regex'][$i][0], 2);
          $urlparts['clean']['path'] .= $temp[0];
          $urlparts['clean']['fragment'] .= $temp[1];
        }
      }
    } else {
      if (countChars($urlparts['regex'][$i][0], '#') === 0) {
        if ($urlparts['regex'][$i][0] == '') {
          //$urlparts['clean']['query'] = false;
        } else {
          $urlparts['clean']['query'] .= $urlparts['regex'][$i][0];
        }
      } else {
        if ($urlparts['regex'][$i][0] == '') {
          //$urlparts['clean']['query'] = false;
          //$urlparts['clean']['fragment'] = false;
        } else {
          $temp = explode('#', $urlparts['regex'][$i][0], 2);
          $urlparts['clean']['query'] = $temp[0];
          $urlparts['clean']['fragment'] = $temp[1];
        }
      }
    }
  }
  if (strpos($urlparts['clean']['path'], '.') !== -1) {
    $temp = explode('.', $urlparts['clean']['path']);
    $urlparts['clean']['fileextension'] = $temp[count($temp)-1];
  }
  return $urlparts['clean'];
}

?>
