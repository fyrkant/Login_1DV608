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

    public function __construct() {
        $_SESSION[self::$messageSessionLocation] = null;
    }

    public function setSessionMessage($message) {
        $_SESSION[self::$messageSessionLocation] = $message;
    }

    public function getSessionMessage() {
        if (isset($_SESSION[self::$messageSessionLocation]) && $_SESSION[self::$messageSessionLocation] != "") {
            return $_SESSION[self::$messageSessionLocation];
        } else {
            return "";
        }
    }


}