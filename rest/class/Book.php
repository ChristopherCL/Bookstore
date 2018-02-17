<?php
/**
 * Class Book
 */
class Book implements JsonSerializable
{
    private $id, $title, $description, $author_id, $author;
    public static $db;
    public function __construct(PDO $db)
    {
        self::$db = $db;
        $this->id = -1;
        $this->title = '';
        $this->description = '';
        $this->author_id = 0;
    }
    public function save()
    {
        if ($this->id > 0) {
            //update
            $sql = "UPDATE books SET title=:title, description=:description, author_id=:author_id WHERE id=:id";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(
                [
                    'id'          => $this->id,
                    'title'       => $this->title,
                    'description' => $this->description,
                    'author_id'   => $this->author_id,
                ]
            );
        } else {
            //insert
            $sql = "INSERT INTO books SET title=:title, description=:description, author_id=:author_id";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(
                [
                    'title'       => $this->title,
                    'description' => $this->description,
                    'author_id'   => $this->author_id,
                ]
            );
            $this->id = self::$db->lastInsertId();
        }
        //get autor
        $sql = "SELECT * FROM authors WHERE id=:id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(
            [
                'id' => $this->author_id,
            ]
        );
        $author = $stmt->fetch(PDO::FETCH_OBJ);
        $this->setAuthor(['id' => $author->id, 'name' => $author->name, 'surname' => $author->surname]);
        return $this;
    }
    public function delete()
    {
        $sql = "DELETE FROM books WHERE id=:id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(
            [
                'id' => $this->id,
            ]
        );
        return $stmt->rowCount() > 0;
    }
    /**
     * Load all books or one book if id provided
     *
     * @param PDO $db
     * @param null $id
     *
     * @return array
     */
    public static function loadAll(PDO $db, $id = null)
    {
        $params = [];
        if (!$id) {
            $sql = "SELECT b.*, a.name, a.surname FROM books b LEFT JOIN authors a ON b.author_id=a.id";
        } else {
            $sql = "SELECT b.*, a.name, a.surname FROM books b LEFT JOIN authors a ON b.author_id=a.id WHERE b.id=:id";
            $params = ['id' => $id];
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $books = $stmt->fetchAll(PDO::FETCH_OBJ);
        $booksList = [];
        foreach ($books as $dbBook) {
            $book = new Book($db);
            $book->id = $dbBook->id;
            $book->title = $dbBook->title;
            $book->description = $dbBook->description;
            $book->author_id = $dbBook->author_id;
            $book->author = ['id' => $dbBook->author_id, 'name' => $dbBook->name, 'surname' => $dbBook->surname];
            $booksList[] = $book;
        }
        return $booksList;
    }
    public static function loadAllByAuthor(PDO $db, $author_id)
    {
        $sql = "SELECT b.*, a.name, a.surname FROM books b LEFT JOIN authors a ON b.author_id=a.id WHERE b.author_id=:author_id";
        $params = ['author_id' => $author_id];
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $books = $stmt->fetchAll(PDO::FETCH_OBJ);
        $booksList = [];
        foreach ($books as $dbBook) {
            $book = new Book($db);
            $book->id = $dbBook->id;
            $book->title = $dbBook->title;
            $book->description = $dbBook->description;
            $book->author_id = $dbBook->author_id;
            $book->author = ['id' => $dbBook->author_id, 'name' => $dbBook->name, 'surname' => $dbBook->surname];
            $booksList[] = $book;
        }
        return $booksList;
    }
    public function jsonSerialize()
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'author_id'   => $this->author_id,
            'author'      => isset($this->author) ? $this->author : '',
        ];
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * @param mixed $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @param mixed $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }
    /**
     * @param mixed $author_id
     *
     * @return $this
     */
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * @param mixed $author
     *
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }
}