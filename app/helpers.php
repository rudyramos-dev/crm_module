<?php

if (! function_exists('money')) {
    function money(float|int|string $amount): string
    {
        return '$'.number_format((float) $amount, 2, '.', ',');
    }
}
