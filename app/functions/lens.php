<?php

f::define('lens', function($getter, $setter) {
  return function ($toFunctorFn) use ($getter, $setter) {
    return function ($target) use ($getter, $setter, $toFunctorFn) {
      return f::map(
        function ($focus) use ($setter, $target) {
          return $setter($focus, $target);
        },
        $toFunctorFn($getter($target))
      );
    };
  };
}, false);

f::define('lensProp', function($key) {
  return f::lens(f::prop($key), f::assoc($key));
});

f::define('lensPath', function($path) {
  return f::lens(f::path($path), f::assocPath($path));
});

f::define('over', function($lens, $f, $x) {
  $temp = $lens(function ($y) use ($f) {
    return Identity::of($f($y));
  });
  return $temp($x)->value;
});

f::define('has', function($prop, $obj) {
  return isset($obj[$prop]);
});

f::define('assocPathold', function($path, $val, $obj) {
  function iter($path, $val, &$obj) {
    $key = array_shift($path);
    if (count($path) === 0) {
      $obj[$key] = $val;
      return $val;
    }
    return iter($path, $val, $obj[$key]);
  };
  iter($path, $val, $obj);
  return $obj;
});

f::define('assocPath', function($path, $val, $obj) {
  if (count($path) === 0) {
    return $val;
  }
  $idx = $path[0];
  if (count($path) > 1) {
    $nextObj = isset($obj[$idx]) ? $obj[$idx] : [];
    $val = f::assocPath($path, $val, $nextObj);
  }
  return f::assoc($idx, $val, $obj);
});

f::define('path', curry(function($paths, $obj) {
  $val = $obj;
  $idx = 0;
  while ($idx < count($paths)) {
    if ($val == null) {
      return null;
    }
    $val = $val[$paths[$idx]];
    $idx += 1;
  }
  return $val;
}));