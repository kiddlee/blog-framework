<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;

class PostController extends Controller {

    /**
     * Index
     *
     * @param int $page
     * @return Response
     */
    public function index($slug)
    {
        $posts = Post::all();
        return view('home')->withPosts($posts);
    }

    public function post($slug) {
        $post = Post::get($slug);
        return view('posts.show')->withPost($post); 
    }
}
