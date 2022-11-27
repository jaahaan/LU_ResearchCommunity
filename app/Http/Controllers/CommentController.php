<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\CommentLike;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class CommentController extends Controller
{
    public function getComments($slug){
        $query = Post::where('slug',$slug)->first();

        $data = Comment::where('post_id',$query->id)->with('user', 'like')->orderBy('id', 'desc')->get();
        
        $formattedData = [];

        foreach($data as $value){
            $comment = $value;
            $likecheck = CommentLike::where(['comment_id'=>$comment->id])->first();
            $AuthLikeCheck = CommentLike::where(['user_id'=>Auth::user()->id,'comment_id'=>$comment->id])->first();

            if($likecheck){
                $comment['comment_like_count'] =$comment->like->comment_like_count;
            } if($AuthLikeCheck){
                $comment['authUserCommentLike'] = 'yes';
            } 
            if(!$likecheck){
                $comment['comment_like_count'] = 0;
            } if(!$AuthLikeCheck){
                $comment['authUserCommentLike'] = 'no';
            } 

            $comment['image'] = $comment->user->image;
            $comment['name'] = $comment->user->name;
            $comment['user_slug'] = $comment->user->slug;
            $comment['department'] = $comment->user->department;
            $comment['designation'] = $comment->user->designation;
            unset($comment['user']);
            unset($comment['like']);

            array_push($formattedData, $comment);
        }
        return response()->json([
            'success'=> true,
            'data'=>$formattedData,
        ],200);
    }

    public function commentLike(Request $request){
        $checkLike = CommentLike::where(['user_id'=>Auth::user()->id,'comment_id'=>$request->id])->first();

        \Log::info('$check');
        \Log::info($checkLike);

    	if ($checkLike) {
    		CommentLike::where(['user_id'=>Auth::user()->id,'comment_id'=>$request->id])->delete();
    		return 'deleted';
    	} else{
            return CommentLike::create([
                'user_id' => Auth::user()->id,
	    	    'comment_id' => $request->id,
            ]);
        }
        
    }

    public function addComment(Request $request){
        return Comment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $request->id,
            'comment' => $request->comment,
        ], 201);
    }
}
