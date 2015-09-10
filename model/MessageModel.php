<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-09-09
 * Time: 13:14
 */

namespace model;


class MessageModel
{
    private static $messageSessionLocation = "MessageModel::Message";

    private $message;

    public function __construct() {
        $this->message = null;
    }

    public function setSessionMessage($message) {
        $this->message = $message;
        $_SESSION[self::$messageSessionLocation] = $message;
    }

    public function getSessionMessage() {
        $message = isset($_SESSION[self::$messageSessionLocation]) ? $_SESSION[self::$messageSessionLocation] : null;
        if (!empty($message))
            $this->emptySessionMessage();
        return $message;
    }

    public function emptySessionMessage() {
        unset($_SESSION[self::$messageSessionLocation]);
    }

    public function messageExists() {
        if (isset($_SESSION[self::$messageSessionLocation])) {
            return true;
        } else {
            return false;
        }
    }
}