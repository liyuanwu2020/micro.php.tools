<?php

namespace Mszlu\Tools;

use Exception;

class Entity implements \ArrayAccess
{
    use ArrayAccessTrait;

    public function encode()
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @throws Exception
     */
    public static function decode($jsonData)
    {
        $decodeData = json_decode($jsonData, true);
        if (json_last_error()) {
            throw new Exception("decode error : " . json_last_error_msg());
        }
        return new self($decodeData);
    }
}