<?php

f::define('assoc', function($prop, $val, $obj) {
  if (is_object($obj)) {
    $obj->$prop = $val;
  }
  else {
    $obj[$prop] = $val;
  }
  return $obj;
});
