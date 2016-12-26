<?php

f::define('prop', function($prop, $obj) {
  if (is_object($obj)) {
    return $obj->$prop;
  }
  return $obj[$prop];
});
