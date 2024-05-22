<?php

namespace App\Models\Traits;

trait HasMetaValueAttribute
{
    public function setMetaValueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['meta_value'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['meta_value'] = $value;
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