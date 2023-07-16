<?php

namespace Utils;

class ArrayAdvanced{

    /**
     * Searches element by key-value in array.
     *
     * @param array $array Array to search
     * @param string $key Key of pair
     * @param string $value Value of pair
     * @return mixed element if key-value pair exist, otherwise 'false'
     */
    public static function searchInArrayByKeyValue($array, $key, $value)
    {
        foreach($array as $el)
        {
            if($el[$key] == $value)
            {
                return $el;
            }
        }

        return false;
    }
}