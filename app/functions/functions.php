<?php

f::define('identity', function($x) {
  return $x;
});

f::define('set', curry(function($prop, $value, $obj) {
  $obj[$prop] = $value;
  return $obj;
}));

f::define('tax', curry(function($percent, $price){
  return round($price * $percent / (100 + $percent), 2);
}));

f::define('price', curry(function($percent, $price) {
  return round($price * 100 / (100 + $percent), 2);
}));

f::define('capitalize', function($str) {
  return ucwords($str);
});

f::define('add', curry(function($first, $second) {
  if (is_string($first)) {
    return $first . $second;
  }
  if (is_array($first)) {
    return array_map(f::add($second), $first);
  }
  return $first + $second;
}));

f::define('subtract', curry(function($first, $second) {
  return $first - $second;
}));

f::define('multiply', curry(function($first, $second) {
  return $first * $second;
}));

f::define('concat', curry(function($first, $second) {
  if (is_string($first)) {
    return $first . $second;
  }
  if (is_array($first)) {
    return array_merge($first, $second);
  }
}));

f::define('map', curry(function($fn, $obj) {
  if (is_array($obj)) {
    return array_map($fn, $obj);
  }
  return $obj->map($fn);
}));

f::define('join', function($arr) {
  return implode(', ', $arr);
});

f::define('over', curry(function($lens, $fn, $arr) {
  $prop = $lens($arr);
  return $prop($fn);
}));

f::define('trace', curry(function($name, $arr) {
  echo '<pre>' . var_export($arr, true) . '</pre>';
  return $arr;
}));

// $_json = curry(function($name, $arr) {
//   echo '<pre>' . json_encode($arr, 128) . '</pre>';
//   return $arr;
// });

f::define('json', curry(function($name, $arr) {
  var_dump($arr);
  return $arr;
}));

$capital = function ($str) {
  return strtoupper($str);
};

$_reverse = function ($str) {
  return implode('', array_reverse(str_split($str)));
};

// f::define('lens', curry(function($prop, $obj, $fn) {
//   if (is_object($obj)) {
//     $obj->$prop = $fn($obj->$prop);
//   }
//   else {
//     $obj[$prop] = $fn($obj[$prop]);
//   }
//   return $obj;
// }));
