<?php

if (!function_exists('getAHPDescription')) {
    function getAHPDescription($value)
    {
        $descriptions = [
            1 => 'Sama penting',
            2 => 'Antara sama penting dan sedikit lebih penting',
            3 => 'Sedikit lebih penting',
            4 => 'Antara sedikit dan jelas lebih penting',
            5 => 'Jelas lebih penting',
            6 => 'Antara jelas dan sangat penting',
            7 => 'Sangat penting',
            8 => 'Antara sangat penting dan mutlak',
            9 => 'Mutlak lebih penting',
        ];

        return $descriptions[$value] ?? '';
    }
}
