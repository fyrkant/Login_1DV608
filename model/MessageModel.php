<?php

namespace model;


class MessageModel
{

    private static $messageSessionLocation = "MessageModel::Message";

    /**
     * @param $message string
     */
    public function setSessionMessage($message)
    {
        $_SESSION[ self::$messageSessionLocation ] = $message;
    }

    /**
     * @return string|null
     */
    public function getSessionMessage()
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