<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-11-19
 * Time: 12:09
 */

namespace commons;


class DatabaseConnection
{
    private $mysqli;
    /**
     * @return \mysqli
     * @throws \Exception
     */
    public function DbConnection(){
        $this->mysqli = new \mysqli(\Settings::HOST, \Settings::USERNAME, \Settings::PASSWORD,
            \Settings::DATABASENAME);
        if (mysqli_connect_errno()) {
            throw new \mysqli_sql_exception("Det gick inte att ansluta till databasen. Försök igen.");
        }
        return $this->mysqli;
    }
}