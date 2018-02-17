<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $authors = Author::loadAll($conn, isset($pathId) ? $pathId : null);
   // var_dump($authors);
    $jsonAuthors = [];
    foreach ($authors as $author) {
        $jsonAuthors[] = json_decode(json_encode($author), true);
    }
    $response = ['success' => $jsonAuthors];
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author = new Author($conn);
    $author->setName($_POST['name']);
    $author->setSurname($_POST['surname']);
    $author->save();
    $response = ['success' => [json_decode(json_encode($author), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $authorToEdit = Author::loadAll($conn, $pathId)[0];
    $authorToEdit->setName($patchVars['name']);
    $authorToEdit->setSurname($patchVars['surname']);
    $authorToEdit->save();
    $response = ['success' => [json_decode(json_encode($authorToEdit), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $authorToDelete = Author::loadAll($conn, $pathId)[0];
    $authorToDelete->delete();
    $response = ['success' => 'deleted'];
} else {
    $response = ['error' => 'Wrong request method'];
}