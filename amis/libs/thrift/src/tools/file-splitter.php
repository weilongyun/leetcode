<?php

$file = $argv[1];
$destination = rtrim($argv[2], '/');
$tokens = token_get_all(file_get_contents($file));
$buffer = false;

$namespace = null;
$use = null;
$name = null;
$braces = null;
$abstract_token = null;

while ($token = next($tokens)) {
    if ($token[0] == T_NAMESPACE) {
        do {
            $str = is_string($token) ? $token : $token[1];
            $namespace .= $str;
            $token[0] == T_STRING && $destination .= DIRECTORY_SEPARATOR . strtolower($str);
        } while (!(is_string($token) && $token == ';') && $token = next($tokens));
        @mkdir($destination, 0777, true);
        continue;
    }

    if ($token[0] == T_USE) {
        do {
            $use .= is_string($token) ? $token : $token[1];
        } while (!(is_string($token) && $token == ';') && $token = next($tokens));
        $use .= PHP_EOL;
        continue;
    }

    if ($buffer == false && $token[0] == T_ABSTRACT) {
        $abstract_token = $token;
    }

    if (in_array($token[0], array(T_CLASS, T_INTERFACE, ))) {
        $buffer = true;
        $name = null;
        $code = '';
        $braces = 1;

        if ($abstract_token) {$code .= "abstract ";}
        $abstract_token = null;

        do {
            $code .= is_string($token) ? $token : $token[1];
            if (is_array($token) 
                && $token[0] == T_STRING 
                && empty($name)) {
                $name = $token[1];
            }
        } while (!(is_string($token) && $token == '{') && $token = next($tokens));
    } elseif ($buffer) {
        if (is_string($token)) {
            $code .= $token;
            if ($token == '{') {
                $braces++;
            } elseif ($token == '}') {
                $braces--;
                if ($braces == 0) {
                    $buffer = false;
                    $file = $destination . '/' . $name . '.class.php';
                    $content = '<?php' . PHP_EOL;
                    $content .= $namespace . PHP_EOL . PHP_EOL;
                    $content .= $use . PHP_EOL . PHP_EOL;
                    $content .= $code;
                    file_put_contents($file, $content);
                }
            }
        } else {
            $code .= $token[1];
        }
    }
}
