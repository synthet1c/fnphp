<?php

f::define('and', function($a, $b) {
  return $a && $b;
});

f::define('not', function($val) {
  return !$val;
});

f::define('lessThan', function($a, $b) {
  return $b < $a;
});

f::define('greaterThan', function($a, $b) {
  return $b > $a;
});

f::define('lessThanEqual', function($a, $b) {
  return $b <= $a;
});

f::define('greaterThanEqual', function($a, $b) {
  return $b >= $a;
});