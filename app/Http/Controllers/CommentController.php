<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentController extends Controller
{

    use AuthorizesRequests;

    public function index($taskId)
    {
        $task = Task::findOrFail($taskId);
        $comments = $task->comments()->with('user')->get();
        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
        ]);
    
        $comment = Comment::create([
            'task_id' => $request->task_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);
    
        return response()->json($comment->load('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $this->authorize('update', $comment);
    
            $request->validate([
                'content' => 'required|string',
            ]);
    
            $comment->update(['content' => $request->content]);
    
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroy(Comment $comment)
    {
        try {
            $this->authorize('delete', $comment);
    
            $comment->delete();
    
            return response()->json(['success' => true, 'message' => 'Comentario eliminado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}