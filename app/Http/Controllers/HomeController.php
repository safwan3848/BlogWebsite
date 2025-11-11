<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        if (Auth::check() && Auth::user()->usertype == 'user') {
            return view('dashboard');
        } else {
            return view('admin.dashboard');
        }
    }

    public function showAllPost() {
        $posts = Post::all();
        return view('home', compact('posts'));
    }

    public function showFullPostHome($id) {
        $post = Post::findOrFail($id);
        return view('fullpost', compact('post'));
    }
}
