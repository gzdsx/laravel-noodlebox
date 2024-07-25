<?php

namespace App\Models\Traits;

trait HasMetaValueAttribute
{
    public function setMetaValueAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['meta_value'] = $value;
        } else {
            $this->attributes['meta_value'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getMetaValueAttribute($value)
    {
        $newValue = json_decode($value, true);
        if (is_array($newValue)) {
            return $newValue;
        } else {
            return $value;
        }
    }
}