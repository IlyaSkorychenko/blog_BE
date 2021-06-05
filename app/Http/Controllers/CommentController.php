<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Post $post
     * @return AnonymousResourceCollection
     */
    public function index(Post $post): AnonymousResourceCollection
    {
        return CommentResource::collection($post->comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Post $post
     * @param StoreCommentRequest $request
     * @return CommentResource
     */
    public function store(Post $post, StoreCommentRequest $request)
    {
        $comment = $request->user()->comments()->make($request->validated());
        return new CommentResource($post->comments()->save($comment));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommentRequest $request
     * @param Comment $comment
     * @return CommentResource
     */
    public function update(UpdateCommentRequest $request, Comment $comment): CommentResource
    {
        $comment->update($request->validated());
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return Response
     * @throws Exception
     */
    public function destroy(Comment $comment): Response
    {
        $comment->delete();
        return response()->noContent();
    }
}
