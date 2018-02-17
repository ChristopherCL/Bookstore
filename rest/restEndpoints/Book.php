<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $books = Book::loadAll($conn, isset($pathId) ? $pathId : null);
   // var_dump($books);
    $jsonBooks = [];
    foreach ($books as $book) {
        $jsonBooks[] = json_decode(json_encode($book), true);
    }
   // var_dump($jsonBooks);
    $response = ['success' => $jsonBooks];
    //var_dump($response);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book = new Book($conn);
    $book->setTitle($_POST['title']);
    $book->setDescription($_POST['description']);
    $book->setAuthorId($_POST['author_id']);
    $book->save();
    $response = ['success' => [json_decode(json_encode($book), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $bookToEdit = Book::loadAll($conn, $pathId)[0];
    $bookToEdit->setTitle($patchVars['title']);
    $bookToEdit->setDescription($patchVars['description']);
    $bookToEdit->setAuthorId($patchVars['author_id']);
    $bookToEdit->save();
    $response = ['success' => [json_decode(json_encode($bookToEdit), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $bookToDelete = Book::loadAll($conn, $pathId)[0];
    $bookToDelete->delete();
    $response = ['success' => 'deleted'];
} else {
    $response = ['error' => 'Wrong request method'];
}