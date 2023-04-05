<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Post;
use App\Models\Image;
use App\Models\User;
use App\Models\Liker;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LikeRequest;
use App\Http\Requests\PostComment;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function getAllPost(){
                $catagores = DB::table('catagores')->get()->toArray();
                $posts = DB::table('posts')->join('images', 'images.id', '=', 'posts.image_id')
                        ->join('users', 'users.id', '=', 'posts.user_id')->get(['posts.*','images.image_url','users.name','users.profile_url'])->toArray();
                $comments = DB::table('comments')->get()->toArray();
                $likes = DB::table('likes')->get()->toArray();

                foreach($posts as $post)
                {
                    $post->comments = array_filter($comments, function($comment) use ($post) {
                        return $comment->post_id === $post->id;
                    });
                }
                foreach($posts as $post)
                {
                    $post->likes = array_filter($likes, function($like) use ($post) {
                        return $like->post_id === $post->id;
                    });
                }

                return [
                    'posts'=>$posts,
                    'catagores' => $catagores
                ];

    }
    public function getByCatagore($id){
                        $catagores = DB::table('catagores')->get()->toArray();
                        $posts = DB::table('posts')->join('images', 'images.id', '=', 'posts.image_id')
                        ->join('users', 'users.id', '=', 'posts.user_id')->get(['posts.*','images.image_url','users.name','users.profile_url'])->toArray();
                        $comments = DB::table('comments')->get()->toArray();
                        $likes = DB::table('likes')->get()->toArray();
                        $catagores = DB::table('catagores')->get()->toArray();

                        foreach($posts as $post)
                        {
                        $post->comments = array_filter($comments, function($comment) use ($post) {
                        return $comment->post_id === $post->id;
                        });
                        }
                        foreach($posts as $post)
                        {
                        $post->likes = array_filter($likes, function($like) use ($post) {
                        return $like->post_id === $post->id;
                        });
                        }
                        foreach($posts as $post)
                        {
                        $post->catagores = array_filter($catagores, function($catagore) use ($post) {
                        return $catagore->id === $post->catagore_id;
                        });
                        }
                        $postInfo = [];
                        $p_id = null;
                        // used the serching concepts here
                        foreach($posts as $post){
                        if($post->catagore_id == $id){ 
                        $p_id = $post->id;
                        $postInfo = $post;
                        }
                        }
                        if($postInfo != null){
                            return [
                                'posts'=> [$postInfo],
                                'catagores' => $catagores
                            ];
                        }
                        else{
                            return [
                                'posts'=> null,
                                'catagores' => $catagores
                            ];
                        }
                        
    }
    public function getPost($id){
                // first of all find the post by this id
                $posts = DB::table('posts')->join('images', 'images.id', '=', 'posts.image_id')
                    ->join('users', 'users.id', '=', 'posts.user_id')->get(['posts.*','images.image_url','users.name','users.profile_url'])->toArray();
                $comments = DB::table('comments')->get()->toArray();
                $likes = DB::table('likes')->get()->toArray();

                foreach($posts as $post)
                {
                $post->comments = array_filter($comments, function($comment) use ($post) {
                    return $comment->post_id === $post->id;
                });
                }
                // there are 3 post 
                foreach($posts as $post)
                {
                $post->likes = array_filter($likes, function($like) use ($post) {
                    return $like->post_id === $post->id;
                });
                }
                $postInfo = null;
                $p_id = null;
                // used the serching concepts here
                foreach($posts as $post){
                    if($post->id == $id){ 
                        $p_id = $post->id;
                        $postInfo = $post;
                    }
                }

                return $postInfo;
    }
    public function storeLike(LikeRequest $request){
                $currentUser = $request->user();
                $likes =DB::table('likes')->where('post_id', $request->postId)->get();
                $isLiked = "false";
                $like_id =null;
                foreach($likes as $like){
                if($currentUser->email == $like->email){
                    $isLiked = "true";
                    $like_id = $like->id;
                }
                }
                // now start registration
                $liked = null;
                $result = null;
                if($isLiked == "false"){
                $liked =Like::create([
                    'post_id'=> $request['postId'],
                    'name'=> $currentUser->name,
                    'email' => $currentUser->email,
                    'profile' => $currentUser->profile_url,
                ]);
                }
                else{
                // now here dislike the post
                $result = Like::where('id',$like_id)->delete();
                }
                // now after all of this return the post data
                $posts = DB::table('posts')->join('images', 'images.id', '=', 'posts.image_id')
                ->join('users', 'users.id', '=', 'posts.user_id')->get(['posts.*','images.image_url','users.name','users.profile_url'])->toArray();
                $comments = DB::table('comments')->get()->toArray();
                $likes = DB::table('likes')->get()->toArray();

                foreach($posts as &$post)
                {
                $post->comments = array_filter($comments, function($comment) use ($post) {
                return $comment->post_id === $post->id;
                });
                }
                foreach($posts as &$post)
                {
                $post->likes = array_filter($likes, function($like) use ($post) {
                return $like->post_id === $post->id;
                });
                }
                return $posts;
    }
    function postComment(PostComment $request){
                $currentUser = $request->user();
                $comment = Comment::create([
                    'post_id'=>$request->postId,
                    'message'=>$request->comment,
                    'name'=>$currentUser->name,
                    'email'=>$currentUser->email,
                    'profile'=> $currentUser->profile_url,
                ]);
                // after store the comment featch now the all post data 
                $posts = DB::table('posts')->join('images', 'images.id', '=', 'posts.image_id')
                    ->join('users', 'users.id', '=', 'posts.user_id')->get(['posts.*','images.image_url','users.name','users.profile_url'])->toArray();
                $comments = DB::table('comments')->get()->toArray();
                $likes = DB::table('likes')->get()->toArray();

                foreach($posts as $post)
                {
                $post->comments = array_filter($comments, function($comment) use ($post) {
                    return $comment->post_id === $post->id;
                });
                }
                // there are 3 post 
                foreach($posts as $post)
                {
                $post->likes = array_filter($likes, function($like) use ($post) {
                    return $like->post_id === $post->id;
                });
                }
                $postInfo = null;
                $p_id = null;
                // used the serching concepts here
                foreach($posts as $post){
                    if($post->id == $request->postId){ 
                        $p_id = $post->id;
                        $postInfo = $post;
                    }
                }

                return $postInfo;
    }
    
}
