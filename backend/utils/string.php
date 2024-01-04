<?php

/**
 * @param $str string
 * @return bool {true} if a {string} contains noting, or only whitespace
 */
function is_string_empty(string $str): bool
{
    return strlen(trim($str)) == 0;
}
