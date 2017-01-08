<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

require 'functions/utils.php';
require 'functions/f.php';
require 'functions/logic.php';
require 'functions/list.php';
require 'functions/associative-array.php';
require 'objects/Identity.php';
require 'objects/Maybe.php';
require 'objects/Constant.php';
require 'functions/functions.php';
require 'functions/function.php';

//f::define('setTax', curry(function($tax, $product) {
//  $price = $product['price'];
//  $temp = f::compose(
//    f::set('gst', f::tax($tax, $price)),
//    f::set('exTax', f::price($tax, $price))
//  );
//  return $temp($product);
//}));

f::define('inc', f::add(1));
f::define('dec', f::subtract(1));

f::define('setPrice', function($tax, $product) {
  $product['test'] = $product['price'] * $tax;
  return $product;
});

f::define('doStuff', f::compose(
  f::trace('stuff'),
  f::over(f::lensProp('user'), f::over(f::lensProp('email'), f::upperCase())),
  f::over(f::lensProp('products'), f::map(
    f::compose(
      f::over(f::lensProp('price'), f::inc()),
      f::over(f::lensProp('name'), f::upperCase()),
      f::setPrice(0.11)
    )
  ))
  // f::over(
  //  :lensProp('id'), f::inc()
  // ),
  // f::over:lensProp('id'), f::multiply(0.11)),
  // f::over:lensProp('products'), f::map(
  //   f::compose(
  //     f::over:lensProp('name'), f::capitalize())
  //   )
  // ))
));

//f::define('decrementQuantity', f::over(
//  f::lensProp('products'),
//  f::map(f::inc())
//));
//
//f::define('incrementQuantity', f::over(
//  f::lensProp('products'),
//  f::map(f::dec())
//));

$cart = [
  'id' => 1,
  'user' => [
    'name' => 'Andrew',
    'email' => 'founts24@gmail.com',
  ],
  'products' => [
    [
      'id' => 1,
      'name' => 'The first item',
      'price' => 69
    ],
    [
      'id' => 2,
      'name' => 'The second item',
      'price' => 79
    ],
    [
      'id' => 3,
      'name' => 'The third item',
      'price' => 99
    ],
  ],
];

f::doStuff($cart);

$people = [
  ['name' => 'simo', 'age' => 33],
  ['name' => 'chris', 'age' => 30],
  ['name' => 'foonta', 'age' => 32],
  ['name' => 'jimbo', 'age' => 33],
];

f::define('byAge', f::descend(f::prop('age')));

var_dump(
  f::sort(f::descend(f::prop('age')), $people)
);

var_dump(f::prop('name', ['name' => 'andrew']));
var_dump(f::assoc('test', 'test', ['name' => 'andrew']));

f::define('upsydownsy', f::compose(
  f::over(f::lensPath(['one', 'two']), f::upperCase()),
  f::over(f::lensPath(['one', 'three']), f::lowerCase())
));

var_dump(
  f::upsydownsy([
    'one' => [
      'two' => 'lowercase',
      'three' => 'UPPERCASE'
    ],
    'two' => 'three'
  ])
);

var_dump(
  f::view(f::lensProp('one'), ['one' => ['two' => 2]])
);

var_dump(
  f::dropWhile(f::lessThan(3), [ 1, 2, 3, 4, 3, 2, 1 ])
);

f::define('toObject', function($arr) {
  return (object) $arr;
});

f::define('toArray', function($arr) {
  return (array) $arr;
});

f::define('toString', function($x) {
  return (string) $x;
});

f::define('toFloat', function($x) {
  return (float) $x;
});

f::define('toInt', function($x) {
  return (float) $x;
});

f::define('convertNumberToWords', function($number) {

  $hyphen      = '-';
  $conjunction = ' and ';
  $separator   = ', ';
  $negative    = 'negative ';
  $decimal     = ' point ';
  $dictionary  = array(
    0                   => 'zero',
    1                   => 'one',
    2                   => 'two',
    3                   => 'three',
    4                   => 'four',
    5                   => 'five',
    6                   => 'six',
    7                   => 'seven',
    8                   => 'eight',
    9                   => 'nine',
    10                  => 'ten',
    11                  => 'eleven',
    12                  => 'twelve',
    13                  => 'thirteen',
    14                  => 'fourteen',
    15                  => 'fifteen',
    16                  => 'sixteen',
    17                  => 'seventeen',
    18                  => 'eighteen',
    19                  => 'nineteen',
    20                  => 'twenty',
    30                  => 'thirty',
    40                  => 'fourty',
    50                  => 'fifty',
    60                  => 'sixty',
    70                  => 'seventy',
    80                  => 'eighty',
    90                  => 'ninety',
    100                 => 'hundred',
    1000                => 'thousand',
    1000000             => 'million',
    1000000000          => 'billion',
    1000000000000       => 'trillion',
    1000000000000000    => 'quadrillion',
    1000000000000000000 => 'quintillion'
  );

  if (!is_numeric($number)) {
    return false;
  }

  if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
    // overflow
    trigger_error(
      'f::convertNumberToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
      E_USER_WARNING
    );
    return false;
  }

  if ($number < 0) {
    return $negative . f::convertNumberToWords(abs($number));
  }

  $string = $fraction = null;

  if (strpos($number, '.') !== false) {
    list($number, $fraction) = explode('.', $number);
  }

  switch (true) {
    case $number < 21:
      $string = $dictionary[$number];
      break;
    case $number < 100:
      $tens   = ((int) ($number / 10)) * 10;
      $units  = $number % 10;
      $string = $dictionary[$tens];
      if ($units) {
        $string .= $hyphen . $dictionary[$units];
      }
      break;
    case $number < 1000:
      $hundreds  = $number / 100;
      $remainder = $number % 100;
      $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
      if ($remainder) {
        $string .= $conjunction . f::convertNumberToWords($remainder);
      }
      break;
    default:
      $baseUnit = pow(1000, floor(log($number, 1000)));
      $numBaseUnits = (int) ($number / $baseUnit);
      $remainder = $number % $baseUnit;
      $string = f::convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
      if ($remainder) {
        $string .= $remainder < 100 ? $conjunction : $separator;
        $string .= f::convertNumberToWords($remainder);
      }
      break;
  }

  if (null !== $fraction && is_numeric($fraction)) {
    $string .= $decimal;
    $words = array();
    foreach (str_split((string) $fraction) as $number) {
      $words[] = $dictionary[$number];
    }
    $string .= implode(' ', $words);
  }

  return $string;
});

$digits = ['1', '2', '3', '4'];
$appender = function($a, $b) {
  return [ $a . $b, $a . $b ];
};

f::define('madd3', f::liftN(3, function() {
  return f::sum(func_get_args());
}));

$doStuff = f::over(f::lensPath(['two', 'three']), f::always(5));

var_dump(
  $doStuff(
    [
      'one' => 1,
      'two' => [
        'three' => 3
      ],
    ]
  )
);

$obj = f::Identity((object) [
  'one' => (object) [
    'two' => 2,
    'three' => (object) [
      'four' => 4
    ]
  ]
]);

$modified = f::over(
  f::lensPath(['one', 'three', 'four']), f::compose(
    f::convertNumberToWords(),
    f::multiply(rand(0, 25000))
  )
);

//f::route('/projects/{$id}', function($id) {
//  return f::pipe(
//    Project::get($id),
//    f::json()
//  );
//});

/**
 * Class Project
 *
 * @method static of()
 */
class Project extends Identity {
  public $value = null;
  public function __construct($params = []) {
    $this->value = (object) $params;
  }

  public static function of($params) {
    return new Project($params);
  }

  private function create($params) {
    return db::insert('projects', $params);
  }

  private function save() {

  }

  private function find($id) {
    $this->value = (object) [
      'id' => 69,
      'name' => 'fnphp.com'
    ];
  }

  public function over($lens, $fn) {
    $this->value = f::over($lens, $fn, $this->value);
    return $this;
  }

  public function maybeOver($lens, $fn) {
    $this->value = f::maybeOver($lens, $fn, $this->value);
    return $this;
  }

  public function __get($name) {
    return f::prop($name, $this->value);
  }

  public function map($fn) {
    $this->value = $fn($this->value);
    return $this;
  }

  public function __call($name, $arguments) {
    $class = isset($this) && $this instanceof Project ? $this : new Project();
    $result = call_user_func_array([$class, $name], $arguments);
    return !is_null($result)
      ? $result
      : $class;
  }
  public static function __callStatic($name, $arguments) {
    $class = new Project();
    $result = call_user_func_array([$class, $name], $arguments);
    return !is_null($result)
      ? $result
      : $class;
  }
}

$capitalizeName = f::compose(
  f::over(f::lensProp('test'), f::upperCase()),
  f::over(f::lensProp('id'), f::multiply(3))
);

$stuff = f::map(
  f::compose(
    f::save(),
    f::evolve([
      'test' => f::upperCase(),
      'id' => f::multiply(4),
      'name' => f::reverse()
    ]),
    f::assoc('test', 'test')
  )
);

$actions = f::compose(
  // $capitalizeName,
  $stuff
);

var_dump(
  $actions(Project::find(69))
);


//f::route('/projects/{$id}/task/create', function($id, $post) {
//  return f::pipe(
//    Project::find($id),
//    f::createTask($post),
//    f::map(f::over(f::lensProp('seen'), f::inc())),
//    f::save(),
//    f::json()
//  );
//});

var_dump(
  f::map($modified, $obj)->value->one->three
);
