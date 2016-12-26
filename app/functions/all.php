<?php

f::define('all', function($fn, $list) {
  $ii = 0;
  $ll = count($list);
  while ($ii < $ll) {
    if (!$fn($list[$ii])) {
      return false;
    }
    $ii += 1;
  }
  return true;
});
