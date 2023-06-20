<?php
require_once "Database.php";

class UserModel extends Database
{
    public function getUsers($table_name,$arg,$joins,$joinon,$where_case_col,$where_case_val,$limitstart,$limitend)
    {
        return $this->select($table_name,$arg,$joins,$joinon,$where_case_col,$where_case_val,$limitstart,$limitend);
    }

    public function addUsers($table_name,$colums_names,$column_values)
    {
        return $this->insert($table_name,$colums_names,$column_values);
    }
    
    public function updateUsers($table_name,$colums_names,$column_values,$whereColName,$whereColValue)
    {
        return $this->update($table_name,$colums_names,$column_values,$whereColName,$whereColValue);
    }

    public function deleteUsers($table_name,$colName,$colValue)
    {
        return $this->delete($table_name,$colName,$colValue);
    }
}