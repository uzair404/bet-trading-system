<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    	$request->validate([
            'body'=>'required',
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        Comments::create($input);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comments $comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comments $comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comments $comments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Find the comment by ID
            $comment = Comments::findOrFail($id);

            // Check if the authenticated user has permission to delete the comment
            // You can customize this logic based on your authentication system
            if (auth()->user()->isAdmin == 1 || $comment->user_id == auth()->user()->id) {
                $comment->delete();

                // Optionally, you may want to redirect back with a success message
                return redirect()->back()->with('success', 'Comment deleted successfully.');
            } else {
                // If the authenticated user doesn't have permission, handle accordingly
                return redirect()->back()->with('error', 'You do not have permission to delete this comment.');
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            return redirect()->back()->with('error', 'An error occurred while deleting the comment.');
        }
    }
}
