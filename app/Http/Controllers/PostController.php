<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create');

        return response()->json([
            'message' => 'abc'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $hash
     * @return JsonResponse|object
     * @throws AuthorizationException
     */
    public function show($hash)
    {
        $post = Post::where('hash', $hash)->first();
        if (!$post)
            return response()->json([
                'message' => 'No data found!'
            ])->setStatusCode(404);

        if (auth()->check())
            $this->authorize('view', $post);

        return response()
            ->json(array_merge(
                $post->toArray(), [
                    'author' => $post->user->toArray()
                ]
                ))
            ->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
