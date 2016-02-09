<?php

$root = filter_input(INPUT_SERVER, "Root", FILTER_SANITIZE_URL);
require_once $root . 'model/database.php';

class Database
{

    private $con = "";
    private $objServer = "";

    protected function __construct()
    {
        $this->con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      
    }

    private function close_connection()
    {
        return mysqli_close($this->con);
    }

    protected function exec($statement)
    {
        $sub = explode(" ", $statement);
        $final_result = "";
        switch ($sub[0])
        {
            case 'insert':
            case 'update':
            case 'delete':
                $final_result = $this->exec_DML($statement);
                break;
            case 'select':
            case 'show':
                $final_result = $this->retrieve($statement);
                break;
        }
        return $final_result;
    }

    private function exec_DML($statement)
    {
        $result = mysqli_query($this->con, $statement);
        if ($result == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    private function retrieve($statement)
    {
        $result = mysqli_query($this->con, $statement);
        if (!$result)
        {
            return NULL;
        }
        else
        {
            if ($this->num_rows($result) > 0)
            {
                return $result;
            }
            else
            {
                return NULL;
            }
        }
    }

    protected function query($statement)
    {
        $result = mysqli_query($this->con, $statement);
        $this->close_connection();
        if ($this->num_rows($result) > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    protected function num_rows($result)
    {
        return mysqli_num_rows($result);
    }

    public function fetch($statement, $pointer)
    {
        if (is_array($pointer))
        {
            $columns = $pointer;
        }
        else
        {
            $columns = $this->get_columns($pointer);
        }
        $result = $this->exec($statement);
        if (!is_null($result))
        {
            return $this->fetch_array($result, $columns);
        }
        else
        {
            return NULL;
        }
    }

    private function fetch_array($statement, $columns)
    {
        $result = "";
        $final = "";
        $i = 0;
        while ($data = mysqli_fetch_array($statement))
        {
            for ($index = 0; $index < count($columns); $index++)
            {
                $result[$i][$columns[$index]] = $data[$columns[$index]];
                $final[$i][$index] = $result[$i][$columns[$index]];
            }
            $i++;
        }
        return $final;
    }

    private function get_columns($pointer)
    {
        $result = $this->exec("show columns from $pointer");
        $i = 0;
        while ($data = mysqli_fetch_array($result))
        {
            $columns[$i++] = $data[0];
        }
        return $columns;
    }

    /*
     * These methods are used to merging all stuff in a joined query statement.
     */

    protected function get_statement($columns, $columns_alias, $tables, $joined_columns)
    {
        $statement = "select ";
        $statement .= $this->set_columns($columns, $columns_alias);
        $statement .= $this->set_tables($tables);
        $statement .= $joined_columns;
        return $statement;
    }

    private function set_columns($columns, $columns_alias)
    {
        $sub = "";
        for ($i = 0; $i < count($columns); $i++)
        {
            $sub .= $columns[$i];
            if (!is_null($columns_alias))
            {
                $sub.= " as " . $columns_alias[$i];
            }
            if ($i == (count($columns) - 1))
            {
                $sub .= " from ";
            } else
            {
                $sub .= ", ";
            }
        }
        return $sub;
    }

    private function set_tables($tables)
    {
        $sub = "";
        for ($i = 0; $i < count($tables); $i++)
        {
            $sub .= $tables[$i];
            if ($i == (count($tables) - 1))
            {
                $sub .= " where ";
            }
            else
            {
                $sub .= ", ";
            }
        }
        return $sub;
    }

    /*
     * 
     */
}
