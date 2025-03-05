<?php

namespace App\Enums;

enum AttributesEnum
{
    public const TEXT_TYPE = 'text';
    public const SELECT_TYPE = 'select';
    public const DATE_TYPE = 'date';
    public const NUMBER_TYPE = 'number';

    public const ACCEPTED_SELECT_TYPES = [
        'High',
        'Medium',
        'Low'
    ];
}
