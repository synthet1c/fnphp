<?php

f::define('ascend', function($fn, $a, $b) {
  $aa = $fn($a);
  $bb = $fn($b);
  return $aa < $bb ? 1 : -1;
});
