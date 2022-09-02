<?php

namespace NK\TestProjectBantikov\DB;

define('MYSQL_HOST', 'localhost');
define('MYSQL_DATABASE', 'db_test');
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');

class MySQL
{
    /**
     * @return \mysqli
     * @throws ConnectionException
     */
    private function connect(): \mysqli
    {
        $connection = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
        if ($connection === FALSE) {
            throw new ConnectionException(ConnectionException::NO_CONNECTION);
        }
        mysqli_set_charset($connection, "utf8");
        return $connection;
    }

    public function escape(string $value): string
    {
        try {
            $connection = $this->connect();
        } catch (\Throwable $e) {
            echo $e->getMessage();
            die;
        }
        return mysqli_real_escape_string($connection, $value);
    }

    /**
     * @param string $query
     * @return \mysqli_result
     * @throws ConnectionException
     */
    public function makeQuery(string $query): \mysqli_result
    {
        $connection = $this->connect();
        $result = mysqli_query($connection, $query);
        if ($result === FALSE) {
            throw new ConnectionException(ConnectionException::FAILED_QUERY, mysqli_error($connection));
        }
        return $result;
    }

    public function execute(string $sql): \mysqli_result
    {
        try {
            $rtnVal = $this->makeQuery($sql);
        } catch (\Throwable $e) {
            echo $e->getMessage();
            die;
        }
        return $rtnVal;
    }

    /**
     * @param mysqli_result $res
     * @return array|null
     */
    public function fetchRow(\mysqli_result $res)
    {
        return mysqli_fetch_row($res);
    }

    /**
     * @param mysqli_result $res
     * @return array|null
     */
    public function fetchArray(\mysqli_result $res)
    {
        return mysqli_fetch_array($res);
    }

    /**
     * @param \mysqli_result $res
     * @return string[]|null
     */
    public function fetchAssoc(\mysqli_result $res)
    {
        return mysqli_fetch_assoc($res);
    }

    public function fetchAll(\mysqli_result $res): array
    {
        return mysqli_fetch_all($res);
    }

    /**
     * @param \mysqli_result $res
     * @return object|null
     */
    public function fetchObject(\mysqli_result $res)
    {
        return mysqli_fetch_object($res);
    }

    public function getCounts(\mysqli_result $res): int
    {
        return mysqli_num_rows($res);
    }
}
