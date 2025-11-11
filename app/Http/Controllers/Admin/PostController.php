<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        $posts = Post::latest()->get();
        return view('admin.post.index', compact('posts'));
    }

    public function create() {
        return view('admin.post.create');
    }

    public function store(Request $request) {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image'
        ]);
        
        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put('posts', $request->file('image'));
            $imagePath = $path; 
        }
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.post.index')->with('success', 'Post created successfully!');
    }

    public function edit($id) {
        $post = Post::findOrFail($id);
        return view('admin.post.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $post = Post::findOrFail($id);
        $data = $request->only('title', 'description');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.post.index')->with('success', 'Post updated successfully!');
    }

    public function destroy($id)
    {
        // Find the post
        $post = Post::findOrFail($id);

        // Delete the image from storage if it exists
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        // Delete the post from the database
        $post->delete();

        // Redirect back with success message
        return redirect()->route('admin.post.index')->with('success', 'Post deleted successfully.');
    }
}
