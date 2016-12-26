<?php

// f::define('ap', function($applicitive, $fn) {
//   if (method_exists('ap', $applicitive)) {
//     return $applicitive->ap($fn);
//   }
//   else if (is_function($applicitive)) {
//     return function($x) use ($applicitive, $fn) {
//       $temp = $applicitive($x);
//       return $temp($fn($x));
//     }
//   }
//   return f::reduce(function($acc, $f) {
//     return f::concat($acc, f::map($f, $fn));
//   })
// });
