<?php

namespace App\Enums;

enum ProductAttributeType: string
{
    case TEXT = 'text';
    case COLOR = 'color';

    public function label()
    {
        return match ($this) {
            self::TEXT => 'Text',
            self::COLOR => 'Color',
        };
    }
}
