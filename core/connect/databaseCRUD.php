<?php
class databaseCRUD {
    private $conn;

    function __construct($dbCon) {
        $this->conn = $dbCon;
    }

    //**** Retrive any data from any table ****//
    public function selectAll($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null) {
        $query = 'SELECT ' . $rows . ' FROM ' . $table;
        if ($join != null) {
            $query .= ' JOIN ' . $join;
        }
        if ($where != null) {
            $query .= ' WHERE ' . $where;
        }
        if ($order != null) {
            $query .= ' ORDER BY ' . $order;
        }
        if ($limit != null) {
            $query .= ' LIMIT ' . $limit;
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
     public function selectHaving($table, $rows, $groupby = null, $having = null) {
        $query = 'SELECT ' . $rows . ' FROM ' . $table;
        if ($groupby != null) {
            $query .= ' GROUP BY ' . $groupby;
        }
        if ($having != null) {
            $query .= ' HAVING ' . $having;
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    // Function to insert into the database
    public function insertData($table, $params = array()) {
        $fieldlist = implode('`, `', array_keys($params));
        $values = implode('", "', $params);
        $query = 'INSERT INTO `' . $table . '` (`' . $fieldlist . '`) VALUES ("' . $values . '")';
        echo $query;
        // Make the query to insert to the database
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->execute();
            if ($stmt->rowCount()) {
                return true; // Update successful
            } else {
                return false; // Update unsuccessful
            }
        } else {
            return false; // Not inserted
        }
    }

    // Function to update row in database
    public function updateData($table, $params = array(), $where) {
        // Create Array to hold all the columns to update
        $args = array();
        foreach ($params as $field => $value) {
            // Seperate each column out with it's corresponding value
            $args[] = $field . '="' . $value . '"';
        }
        // Create the query
        $query = 'UPDATE ' . $table . ' SET ' . implode(',', $args) . ' WHERE ' . $where;
        // Make query to database
        print_r($query);
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->execute();
            if ($stmt->rowCount()) {
                return true; // Update successful
            } else {
                return false; // Update unsuccessful
            }
        } else {
            return false; // Update unsuccessful
        }
    }

    //Function to delete table or row(s) from database
    public function deleteRow($table, $where = null) {
        if ($where != null) {
            $query = 'DELETE FROM ' . $table . ' WHERE ' . $where; // Create query to delete rows
        }
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                return true; // Update successful
            } else {
                return false; // Update unsuccessful
            }
        } else {
            return false; // Update unsuccessful
        }
    }

    public function countAll($table, $rows = '*', $where = null) {
        $query = 'SELECT ' . $rows . ' FROM ' . $table;
        if ($where != null) {
            $query .= ' WHERE ' . $where;
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
        return $rowCount;
    }

    public function ddlDataLoad($query) {
        $query1 = $this->conn->prepare($query);
        try {
            $query1->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $query1->fetchAll();
    }
}
