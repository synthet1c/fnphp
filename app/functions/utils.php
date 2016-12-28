<?php 

function curry($_fn) {
    $ref = new ReflectionFunction($_fn);
    $length = $ref->getNumberOfParameters();
    return curryN($length, $_fn);
}

function curryN($length, $_fn) {
  $_curry = function($allArgs) use ($length, &$_fn, &$_curry) {
    return function(/*...$args*/) use ($length, &$_fn, &$allArgs, &$_curry) {
      $args = array_merge($allArgs, func_get_args());
      if (count($args) < $length) {
        return $_curry($args);
      }
      return call_user_func_array($_fn, $args);
    };
  };
  return $_curry([]);
}

function lens($prop) {
  return function(&$obj) use ($prop) {
    return function($fn) use ($prop, &$obj) {
      if (is_object($obj)) {
        $obj->$prop = $fn($obj->$prop);
      }
      else {
        $obj[$prop] = $fn($obj[$prop]);
      }
      return $obj;
    };
  };
};
