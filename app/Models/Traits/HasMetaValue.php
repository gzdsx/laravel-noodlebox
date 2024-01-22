<?php

namespace App\Models\Traits;

trait HasMetaValue
{
    /**
     * @param $value
     * @return mixed
     */
    public function getMetaValueAttribute($value)
    {
        $decode_value = json_decode($value);
        if (is_null($decode_value)) {
            return $value;
        }

        return $decode_value;
    }

    /**
     * @param $value
     * @return void
     */
    public function setMetaValueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['meta_value'] = json_encode($value);
        }else{
            $this->attributes['meta_value'] = $value;
        }
    }
}