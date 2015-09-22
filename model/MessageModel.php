<?php

namespace model;


class MessageModel
{

    private static $messageSessionLocation = "MessageModel::Message";

    /**
     * @param $message string
     */
    public function setMessageKey($key)
    {
        $_SESSION[ self::$messageSessionLocation ] = $key;
    }

    /**
     * @return string|null
     */
    public function getMessageKey()
    {
        $message = isset($_SESSION[ self::$messageSessionLocation ]) ? $_SESSION[ self::$messageSessionLocation ] : null;

        $this->emptySessionMessage();

        return $message;
    }

    public function emptySessionMessage()
    {
        unset($_SESSION[ self::$messageSessionLocation ]);
    }
}