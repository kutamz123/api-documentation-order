<?php


namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DefaultValueDateTimeCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        if ($value == '0000-00-00 00:00:00' || $value == null) {
            $dateTime = '-';
        } else {
            $dateTime = date('d-m-Y H:i', strtotime($value));
        }

        return $dateTime;
    }


    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}
