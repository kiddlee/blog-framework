<?php namespace App\Models;

class Post extends Base
{
    public static function all() {
        $per_page = config('my.paginate');
        $postsPath = config('my.posts_path');
        $pageCount = 0;
        $currentPage = 1;
        $result = new \stdClass;
        $result->currentPage = $currentPage;
        if(file_exists($postsPath)) {
        	$indexPath = $postsPath . '/index.json';
        	$contents = file_get_contents($indexPath);
	        $posts = json_decode($contents);
            $result->posts = [];
            $recordCount = 0;
            $result->pageCount = ceil(count($posts)/$per_page);
	        foreach ($posts as $post) {
                if($recordCount < $per_page) {
                    if($post->slug) {
                        $result->posts[] = self::createPost($post);
                        $recordCount++;
                    }
                }
                else{
                    break; 
                }
	        }
        }
        return $result;
    }

    public static function pagination($currentPage) {
        $per_page = config('my.paginate');
        $start = ($currentPage - 1) * $per_page;
        $startCount = 0;
        $recordCount = 0;
        $postsPath = config('my.posts_path');
        $result = new \stdClass;
        $result->currentPage = $currentPage;
        $result->posts = [];
        if(file_exists($postsPath)) {
        	$indexPath = $postsPath . '/index.json';
        	$contents = file_get_contents($indexPath);
	        $posts = json_decode($contents);
            $result->pageCount = ceil(count($posts)/$per_page);
	        foreach ($posts as $post) {
                if($startCount >= $start) {
                    if($recordCount < $per_page) {
                        if($post->slug) {
                            $post = self::createPost($post);
                            $result->posts[] = $post;
                        }
                        $recordCount++;
                    }
                    else {
                        break; 
                    }
                }
                $startCount++;
	        }
        }
        return $result;
    }

    public static function get($slug) {
    	$postsPath = config('my.posts_path');
        if(file_exists($postsPath)) {
        	$indexPath = $postsPath . '/index.json';
        	$contents = file_get_contents($indexPath);
	        $posts = json_decode($contents);
	        foreach ($posts as $post) {
	        	if($post->slug == $slug) {
                    $post = self::createPost($post);
	        		return $post;
	        	}
	        }
        }
    }

    private static function createPost($post) {
        $post->tags = explode(' ', $post->tags);
        if($post->posttime) {
            $post->posttime = date('M d Y', strtotime($post->posttime));
        }
        $postPath = config('my.posts_path') . '/' . $post->slug. '.md';
        $markdown = file_get_contents($postPath);
        $parser = new \cebe\markdown\MarkdownExtra();
        $post->body = $parser->parse($markdown);
        return $post;
    }
}
