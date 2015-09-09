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

    public function setSessionMessage($message) {
        $_SESSION[self::$messageSessionLocation] = $message;
    }

    public function getSessionMessage() {
        if (isset($_SESSION[self::$messageSessionLocation])) {
            $message = $_SESSION[self::$messageSessionLocation];
            return $message;
        } else {
            return "";
        }
    }

    public function emptySessionMessage() {
        $_SESSION[self::$messageSessionLocation] = null;
    }

    public function messageExists() {
        if (isset($_SESSION[self::$messageSessionLocation])) {
            return true;
        } else {
            return false;
        }
    }
}