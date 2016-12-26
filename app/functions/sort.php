<?php

f::define('sort', function($comparitor, $list) {
  usort($list, $comparitor);
  return $list;
});
