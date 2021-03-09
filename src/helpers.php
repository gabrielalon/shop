<?php

// PRINTERS

// prints hidden html with name of file + line from which printer was called
// use only in printers ^^ vv

function printCallLine()
{
    $dbg = debug_backtrace();
    $callPlace = $dbg[1];
    $line = isset($callPlace['line']) ? $callPlace['line'] : '??';
    $file = isset($callPlace['file']) ? $callPlace['file'] : '??';

    printf('<span style="display:none">%s:%d</span>'."\n", $file, $line);
}

function __vd($thing)
{
    ini_set('xdebug.var_display_max_depth', '-1');
    ini_set('xdebug.var_display_max_children', '-1');
    ini_set('xdebug.var_display_max_data', '-1');

    echo '<pre>';
    var_dump($thing);
    printCallLine();
    echo '</pre>';
}

function x($txt)
{
    echo $txt."\n";
}

function kill($msg = '')
{
    x('KILL: '.$msg);
    dbg();
    exit();
}

function dbg()
{
    echo get_dbg();
}

function get_dbg()
{
    $str = '<pre>';
    foreach (debug_backtrace() as $debugLine) {
        if (isset($debugLine['file']) && isset($debugLine['line'])) {
            $str .= $debugLine['file'].':'.$debugLine['line']."\n";
        }
    }
    $str .= '</pre>';

    return $str;
}

// FIXES

/**
 * Handles deserialization of UTF-8 Data.
 *
 * @param string $serializedData
 *
 * @return mixed
 */
function unserialize_utf8($serializedData)
{
    // 5.2.2 Fixed wrong length calculation in unserialize S type (MOPB-29 by Stefan Esser) (Stas) - year 2007 - so wtf
    $retval = @unserialize($serializedData);
    if (false === $retval) {
        return unserialize(preg_replace_callback('!s:(\d+):"(.*?)";!s', 'unserialize_utf8_preg_callback', $serializedData));
    } else {
        return $retval;
    }
}

function unserialize_utf8_preg_callback($matches)
{
    $string = $matches[2];

    return 's:'.strlen($string).':"'.$string.'";'; // here must be strlen() not mb_strlen()!
}

function __microtime()
{
    list($usec, $sec) = explode(' ', microtime());

    return (float) $usec + (float) $sec;
}

function __memory_usage()
{
    $size = memory_get_usage(true);
    $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2).' '.$unit[$i];
}

function __statistic($message, $start)
{
    __(sprintf('%s [TIME:%s] [MEMORY_USAGE:%s]', $message, __microtime() - $start, __memory_usage()));
}

// LOCALES

/**
 * @return \App\System\Illuminate\Locale
 *
 * @throws \Illuminate\Contracts\Container\BindingResolutionException
 */
function locale(): App\System\Illuminate\Locale
{
    return app()->make(App\System\Illuminate\Locale::class);
}
