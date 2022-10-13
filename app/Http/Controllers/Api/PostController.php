<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Trait\ApiResponse;

class PostController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $post =PostResource::collection(Post::get());
        return $this->Apiresponse($post, 'ok', 200);
    }
    public function show($id)
    {
        # code...
        $post = Post::find($id);
        if ($post) {
            return $this->Apiresponse(new PostResource($post), 'ok', 200);
        }
        return $this->Apiresponse(null, 'Not Found', 404);
    }

    public function store(Request $request)
    {
        # code...
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->Apiresponse(null,$validator->errors(), 401);
        }
        $post=Post::create($request->all());
        if ($post) {
            return $this->Apiresponse(new PostResource($post), 'ok', 200);
        }
        return $this->Apiresponse(null, 'Not Found', 401);
    }


    public function update(Request $request,$id){
            # code...
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:posts',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->Apiresponse(null,$validator->errors(), 401);
            }

            $post = Post::find($id);
            if (!$post) {
                return $this->Apiresponse(null, 'Not Found', 404);
            }

            $post->update($request->all());
            if ($post) {
                return $this->Apiresponse(new PostResource($post), 'ok', 200);
            }
    }
    public function delete($id)
    {
        # code...
        $post = Post::find($id);
        if (!$post) {
            return $this->Apiresponse(null, 'Not Found', 404);
        }
        $post->delete($id);
        if ($post) {
            return $this->Apiresponse(null,'post delete', 200);
        }
    }
}