<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;

class PageController extends Controller {

    /**
     * Index
     *
     * @param int $page
     * @return Response
     */
    public function index()
    {
    }

    public function pagination($pagination)
    {
        $result = Post::pagination($pagination);
        return view('home', ['posts' => $result->posts, 'currentPage' => $result->currentPage, 'pageCount' => $result->pageCount]);
    }

    public function about() {
        $pagePath = config('my.about_path');
        $markdown = file_get_contents($pagePath);
        $parser = new \cebe\markdown\MarkdownExtra();
        $pageContent = $parser->parse($markdown);
        return view('pages.aboutme')->withPage($pageContent); 
    }

    public function archives() {
        $postsPath = config('my.posts_path');
        $indexPath = $postsPath . '/index.json';
        $contents = file_get_contents($indexPath);
        $posts = json_decode($contents);
        return view('pages.archives')->withPosts($posts);
    }

    public function tags($tagName) {
        error_log($tagName);
        $postsPath = config('my.posts_path');
        $indexPath = $postsPath . '/index.json';
        $contents = file_get_contents($indexPath);
        $posts = json_decode($contents);
        $return_posts = [];
        foreach($posts as $post) {
            $post_tags = explode(' ', $post->tags);
            foreach($post_tags as $tag) {
                error_log($tag);
                if($tagName == $tag) {
                    $return_posts[] = $post;
                    break;
                }
            } 
        }
        return view('pages.archives')->withPosts($return_posts);
    }

    public function search() {
        return view('pages.search');
    }
}
