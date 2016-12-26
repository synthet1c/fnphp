<?php

f::define('any', function($fn, $list) {
  $ii = 0;
  $ll = count($list);
  while ($ii < $ll) {
    if ($fn($list[$ii])) {
      return true;
    }
  }
  return false;
});
