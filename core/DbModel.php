<?php
declare(strict_types=1);

namespace app\core;

use PDOStatement;

abstract class DbModel extends Model
{
    abstract public function tableName() : string;

    abstract public function attributes() : array;

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
     *  Prepare a SQL statement
     * 
     *  @return PDOStatement
     */
    public static function prepare($sql) : PDOStatement
    {
        return Application::$app->database->pdo->prepare($sql);
    }
}