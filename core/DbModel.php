<?php
declare(strict_types=1);

namespace app\core;

use PDOStatement;

abstract class DbModel extends Model
{
    abstract public static function tableName() : string;

    abstract public function attributes() : array;

    abstract public static function primaryKey() : string;

    /**
     *  Take the model attributes and save in the database
     */
    public function save()
    {
        // Table to insert into
        $tableName = $this->tableName();

        // Attributes are the column names which are selected
        $attributes = $this->attributes();

        // Params are formated :placeholder, this placeholder is replaced
        // with the actual values when bindValue() is called below.
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $sql = "INSERT INTO $tableName (". implode(',', $attributes) .") 
                VALUES (". implode(',', $params) .")";

        $statement = self::prepare($sql);

        // echo '<pre>';
        // var_dump($statement, $params, $attributes);
        // echo '</pre>';
        // exit;

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();

        return true;
    }

    /**
     *  Find a database record
     * 
     *  @param array $where
     *  @return mixed
     */
    public static function findOne(array $where) : mixed
    {
        $tableName = static::tableName();

        // Get just the keys ['email' => test@test.comm, 'firstName' => 'fred'] etc...
        $attributes = array_keys($where);

        // Need an SQL statement... SELECT * FROM $tablename WHERE email = :email AND firstName = :firstName
        // Use this to prepare the statement
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();

        // By passing in static::class fetchObject will return an instance of the object on which it
        // is called. When we call it on LoginForm.php from the User model it will return an instance of that.
        return $statement->fetchObject(static::class);
    }

    /**
     *  Prepare a SQL statement
     * 
     *  @param string
     *  @return PDOStatement
     */
    public static function prepare(string $sql) : PDOStatement
    {
        return Application::$app->database->pdo->prepare($sql);
    }
}