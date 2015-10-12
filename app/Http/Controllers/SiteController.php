<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;

class SiteController extends Controller {

    /**
     * Index
     *
     * @param int $page
     * @return Response
     */
    public function index(Request $req, $page = null)
    {
        $result = Post::all();
        return view('home', ['posts' => $result->posts, 'currentPage' => $result->currentPage, 'pageCount' => $result->pageCount]);
    }
}
