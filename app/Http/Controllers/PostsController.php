<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PostReactions;
use App\Models\Posts;
use App\Models\Reactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use \Str;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['posts'] = Posts::orderBy('created_at', 'desc')->get();
        return view('admin.manage posts', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['categories'] = Category::all();
        return view('admin.create post', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif',
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'post-content' => 'required|string',
            'category' => 'required|exists:categories,id',
        ]);

        // Handle image upload
        // $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $file =$request->file('thumbnail');
        $extension = $file->getClientOriginalExtension();
        $filename = time().'.' . $extension;
        $file->move(public_path('uploads/thumbnails/'), $filename);

        // Create a new post instance
        $post = new Posts();
        $post->image = $filename;
        $post->title = $request->input('title');
        $post->slug = Str::slug($request->input('title'), '-');
        $post->summary = $request->input('summary');
        $post->content = $request->input('post-content');
        $post->category_id = $request->input('category');
        // Save the post to the database
        $post->save();

        // Redirect back with a success message
        return redirect(route('admin.posts'))->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
    	$data['post'] = Posts::where('slug',$slug)->first();
    	$data['reactions'] = Reactions::all();
        if(!$data['post']){
            return redirect('/blog')->with('error', 'Post Not Found');
        }

        $cookie_name = (Auth::user()->id.'-'. $data['post']->id);//logged in user
        if(Cookie::get($cookie_name) == ''){//check if cookie is set
            $cookie = cookie($cookie_name, '1', 60);//set the cookie
            $data['post']->incrementReadCount();//count the view
            return response()
            ->view('post', $data)
            ->withCookie($cookie);//store the cookie
        } else {
            return view('post', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['post'] = Posts::where('id', $id)->first();
        if(!$data['post']){return redirect()->back()->with('error', 'Page Not Found'); }
        $data['categories'] = Category::all();
        return view('admin.edit post', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'thumbnail' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'post-content' => 'required|string',
            'category' => 'required|exists:categories,id',
        ]);

        // Find the post by ID
        $post = Posts::findOrFail($id);
        if(!$post){return redirect()->back()->with('error', 'Page Not Found'); }


        // Handle image upload if a new image is provided
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.' . $extension;
            $file->move(public_path('uploads/thumbnails/'), $filename);
            // Delete the old thumbnail if it exists
            if ($post->image) {
                if (File::exists(public_path('uploads/thumbnails/'.$post->image))) {
                    File::delete(public_path('uploads/thumbnails/'.$post->image));
                }
            }
            // Set the new image filename
            $post->image = $filename;
        }

        // Update the post data
        $post->title = $request->input('title');
        $post->slug = Str::slug($request->input('title'), '-');
        $post->summary = $request->input('summary');
        $post->content = $request->input('post-content');
        $post->category_id = $request->input('category');

        // Save the updated post to the database
        $post->save();

        // Redirect back with a success message
        return redirect(route('admin.posts'))->with('success', 'Post updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $post = Posts::where('id', $id)->first();
        if(!$post){return redirect()->back()->with('error', 'Page Not Found'); }
        $post->delete();
        return redirect()->back()->with('success', 'Post Deleted Successfully');
    }

    public function vote($post_id, $reaction_id)
    {
        //
        $post = Posts::where('id', $post_id)->first();
        $reaction = Reactions::where('id', $reaction_id)->first();
        $post_reaction = PostReactions::where('post_id', $post_id)->where('user_id', Auth::user()->id)->first();
        if(!$post || !$reaction){
            return redirect()->back()->with('error', 'Failed To React');
        }
        if($post_reaction){
            $post_reaction->delete();
        }
        $post_reaction = new PostReactions();
        $post_reaction->user_id = Auth::user()->id;
        $post_reaction->post_id = $post_id;
        $post_reaction->reaction_id = $reaction_id;
        $post_reaction->save();
        return redirect()->back()->with('success', 'Thank You For Your Reaction');
    }
}
