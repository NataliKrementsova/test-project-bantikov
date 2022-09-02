<?php

namespace NK\TestProjectBantikov\DB;

class ConnectionException extends \Exception
{
    public const NO_CONNECTION = 1;
    public const FAILED_QUERY = 2;

    public function __construct($code, $customMessage = '')
    {
        parent::__construct($this->getMessageByCode($code, $customMessage), $code);
    }

    private function getMessageByCode(int $code, string $customMessage): string
    {
        switch ($code) {
            case self::NO_CONNECTION:
                return 'Failed connection to db';
            case self::FAILED_QUERY:
                return 'Failure while making the query: ' . $customMessage;
            default:
                return 'Unknown error';
        }
    }
}
