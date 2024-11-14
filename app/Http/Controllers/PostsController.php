<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\post\StoreRequest;
use App\Http\Requests\post\UpdateRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        return [
            [
                'id' => 1,
                'userId' => 1,
                'title' => 'Programing',
                'description' => 'This post about programming',
                'body' => 'In 2023 we have a lot of good programming languages, the mos popular are: JavaScript, Php, Golang, Python', 'Java', 'C#', 'C++'
            ],
            [
                'id' => 2,
                'userId' => 2,
                'title' => 'University in Almaty',
                'description' => 'This post about universities that located In Almaty',
                'body' => 'If you want to join to universities, firstful you have to think about Almaty'
            ],
            [
                'id' => 3,
                'userId' => 2,
                'title' => 'Computers',
                'description' => 'This post about computers',
                'body' => 'Nowadays in companies use DeLL, Lenovo and etc. computers'
            ],
        ];
    }

    public function getAll()
    {
//        SELECT * FROM POST
        return Post::all();
    }

    public function getPostById($id)
    {
//        SELECT * FROM POST WHERE ID = 1
        return Post::find($id);
    }

    public function create()
    {
        $postTags = ["Nurkhan", "Abylai", "Islambek"];
        $post = new Post();
        $post->title = 'Users';
        $post->body = 'This post about programmers';
        $post->userId = 2;
        $post->reactions = 20000;
        $post->tags = json_encode($postTags);
        if ($post->save()) {
            return 'good';
        } else {
            return 'bad';
        }
    }

    public function store(StoreRequest $request)
    {
        $post = $request->validated();
        if ($post) {

            $tagsAsString = json_encode($post['tags']);
            $post['tags'] = $tagsAsString;
            //INSERT INTO posts
            $postCreated = Post::create($post);
            if ($postCreated) {
                return 'good';
            } else {
                return $postCreated->getErrors()->all();
            }
        }
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $updatedPost = $request->validated();
        if ($updatedPost) {
            $tagsAsString = json_encode($updatedPost['tags']);
            $updatedPost['tags'] = $tagsAsString;
            $postUpdated = $post->update($updatedPost);
            if ($postUpdated) {
                return 'good';
            } else {
                return $postUpdated->getErrors()->all();
            }
        }
    }

    public function getPostByTitle(Request $request)
    {
        $title = $request->input('title');
        return Post::where('title', $title)->get();
    }

    public function deletePost($id){
        {
//            SELECT * FROM posts WHERE id = $id
            $post = Post::find($id);
            if (!$post) {
                return response()->json(['message' => 'Post not found'], 404);
            }
//            DELETE FROM post WHERE id = $id;
            $post->delete();
            return response()->json(['message' => 'Post deleted successfully'], 200);
        }
    }
}
