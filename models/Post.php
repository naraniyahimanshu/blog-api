<?php

require_once '../config/config.php';
require_once '../utils/Database.php';

class Post {
    private $conn;
    private $table = 'posts';

    public $id;
    public $title;
    public $content;
    public $author;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (title, content, author) VALUES ('" . 
                 $this->conn->real_escape_string($this->title) . "', '" . 
                 $this->conn->real_escape_string($this->content) . "', '" . 
                 $this->conn->real_escape_string($this->author) . "')";

        if ($this->conn->query($query)) {
            $this->id = $this->conn->insert_id;
            return true;
        }
        return false;
    }

    public function read($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM " . $this->table . " LIMIT " . 
                 $this->conn->real_escape_string($limit) . " OFFSET " . 
                 $this->conn->real_escape_string($offset);

        $result = $this->conn->query($query);
        if ($result) {
            $posts = $result->fetch_all(MYSQLI_ASSOC);

            $totalQuery = "SELECT COUNT(*) as total FROM " . $this->table;
            $totalResult = $this->conn->query($totalQuery);
            $total = $totalResult->fetch_assoc()['total'];

            return [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'total_pages' => ceil($total / $limit),
                'posts' => $posts
            ];
        }

        return [];
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = " . $this->conn->real_escape_string($this->id) . " LIMIT 1";

        $result = $this->conn->query($query);

        return $result->fetch_assoc();
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET title = '" . 
                 $this->conn->real_escape_string($this->title) . "', content = '" . 
                 $this->conn->real_escape_string($this->content) . "', author = '" . 
                 $this->conn->real_escape_string($this->author) . "' WHERE id = " . 
                 $this->conn->real_escape_string($this->id);

        return $this->conn->query($query);
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = " . 
                 $this->conn->real_escape_string($this->id);

        return $this->conn->query($query);
    }
}

?>
