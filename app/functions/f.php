<?php

class f {
  public static $methods = [];

  public static function init($methods = []) {
    self::$methods = array_merge(self::$methods, $methods);
  }

  public static function define($name, $fn, $doCurry = true) {
    self::$methods[$name] = $doCurry ? curry($fn) : $fn;
  }
  public static function __callStatic($name, $args) {
    if (isset(self::$methods[$name])) {
      return call_user_func_array(self::$methods[$name], $args);
    }
    if (function_exists($name)) {
      return call_user_func_array($name, $args);
    }
    throw new Exception("no function f::{$name}");
  }
}

// f::init($methods);
f::define('pipe', function(/*...$args*/) {
  $fns = func_get_args();
  return function($val) use ($fns) {
    return array_reduce($fns, function($acc, $fn) {
      return $fn($acc);
    }, $val);
  };
});

// f::define('lens', function($prop, $obj, $fn) {
//   if (is_object($obj)) {
//     $obj->$prop = $fn($obj->$prop);
//   }
//   else {
//     $obj[$prop] = $fn($obj[$prop]);
//   }
//   return $obj;
// });

f::define('flip', function($fn) {
  return function(/* args */) use ($fn) {
    $args = array_reverse(func_get_args());
    return call_user_func_array($fn, $args);
  };
});

f::define('compose', function(/*...$args*/) {
  $fns = array_reverse(func_get_args());
  return function($val) use ($fns) {
    return array_reduce($fns, function($acc, $fn) {
      return $fn($acc);
    }, $val);
  };
});

f::define('map',function($fn, $functor) {
  return (is_array($functor))
    ? array_map($fn, $functor)
    : $functor->map($fn);
});

f::define('add', function($a, $b) {
  return $a + $b;
});

f::define('multiply', function($first, $second) {
  return $first * $second;
});

f::define('concat', function($b, $a) {
  if (is_string($b)) {
    return $a . $b;
  }
  else if (is_array($a)) {
    return array_merge($a, $b);
  }
  else if (is_object($b)) {
    return $a->concat($b);
  }
});

f::define('prepend', function($first, $second) {
  return f::concat($first, $second);
});

f::define('append', function($first, $second) {
  return f::concat($second, $first);
});
