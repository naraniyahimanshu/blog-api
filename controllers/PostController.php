<?php

require_once '../models/Post.php';
require_once '../utils/Response.php';

class PostController {

    public function create() {
		
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->title) && isset($data->content) && isset($data->author)) {
            $post = new Post();
            $post->title = $data->title;
            $post->content = $data->content;
            $post->author = $data->author;

            if ($post->create()) {
                Response::send([
                    'id' => $post->id,
                    'title' => $post->title,
                    'content' => $post->content,
                    'author' => $post->author,
                ], 201);
            } else {
                Response::send(['message' => 'Unable to create post.'], 500);
            }
        } else {
            Response::send(['message' => 'Incomplete data.'], 400);
        }
    }

	public function read() {
		
			$post = new Post();
			// Default pagination parameters
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

		
			// Ensure page and limit are positive integers
			$page = $page > 0 ? $page : 1;
			$limit = $limit > 0 ? $limit : 10;

			$data = $post->read($page, $limit);

			// Send the response
			Response::send($data);
		
		
		
    }

    public function readOne($id) {
        $post = new Post();
        $post->id = $id;
        $result = $post->readOne();

        if ($result) {
            Response::send($result);
        } else {
            Response::send(['message' => 'Post not found.'], 404);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->title) || isset($data->content) || isset($data->author)) {
            $post = new Post();
            $post->id = $id;
            $post->title = $data->title ?? $post->title;
            $post->content = $data->content ?? $post->content;
            $post->author = $data->author ?? $post->author;

            if ($post->update()) {
                Response::send($post->readOne());
            } else {
                Response::send(['message' => 'Unable to update post.'], 500);
            }
        } else {
            Response::send(['message' => 'No data to update.'], 400);
        }
    }

    public function delete($id) {
        $post = new Post();
        $post->id = $id;

        if ($post->delete()) {
            Response::send(['message' => 'Post deleted.']);
        } else {
            Response::send(['message' => 'Post not found.'], 404);
        }
    }
}

?>
