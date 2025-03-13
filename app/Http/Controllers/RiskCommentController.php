<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\RiskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiskCommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Risk $risk)
    {
        // Validate the request
        $validated = $request->validate([
            'content' => 'required|string',
        ]);
        
        // Create the comment
        $comment = new RiskComment([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);
        
        // Save the comment
        $risk->comments()->save($comment);
        
        return redirect()->route('risks.show', $risk)
            ->with('success', 'Comment added successfully.');
    }
    
    /**
     * Remove the specified comment.
     */
    public function destroy(Risk $risk, RiskComment $comment)
    {
        // Check if user has permission to delete this comment
        if (Auth::id() === $comment->user_id){
            $comment->delete();
            return redirect()->route('risks.show', $risk)
                ->with('success', 'Comment deleted successfully.');
        }
        
        return redirect()->route('risks.show', $risk)
            ->with('error', 'You do not have permission to delete this comment.');
    }
}