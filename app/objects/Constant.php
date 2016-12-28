<?php

class Constant {
  public static $of = null;
  public static function of($val) {
    return new Constant($val);
  }
  public function __construct($val) {
    $this->value = $val;
  }
  public function map($fn) {
    return $this;
  }
  public static function init() {
    self::$of = function($val) {
      return Constant::of($val);
    };
  }
}

Constant::init();

$Constant = function($val) {
  return Constant::of($val);
};