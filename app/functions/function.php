<?php

f::define('ap', function($applicative, $fn) {
  if (method_exists($applicative, 'ap')) {
    return $applicative::ap($fn);
  }
  else if (is_callable($applicative)) {
    return function($x) use ($applicative, $fn) {
      $temp = $applicative($x);
      return $temp($fn($x));
    };
  }
  else {
    return f::reduce(function($acc, $f) use ($fn) {
      return f::concat($acc, f::map($f, $fn));
    }, [], $applicative);
  }
});

f::define('arity', function($n, $fn) {
  return curryN($n, function() use ($n, $fn) {
    return call_user_func_array($fn, array_slice(func_get_args(), 0, $n));
  });
});

f::define('lift', function($fn) {
  $ref = new ReflectionFunction($fn);
  $length = $ref->getNumberOfParameters();
  return f::liftN($length, $fn);
});


f::define('liftN', function($arity, $fn) {
  $lifted = curryN($arity, $fn);
  return curryN($arity, function() use ($lifted) {
    $args = func_get_args();
    return f::reduce(f::ap(), f::map($lifted, $args[0]), array_slice($args, 1));
  });
});