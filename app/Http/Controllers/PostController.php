<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Auth;
use File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts=Post::latest()->get();
        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::latest()->get();
        return view('post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $request->validate([
            'name'=>"required|min:3",
            'desc'=>'required',
            'slug'=>'required|unique:posts,slug',
            'image'=>'required|image|mimes:png,jpg,webp|max:2048',
            'category_id'=>'required'
        ]);
        if($request->hasFile('image'))
        {
            $manager=new ImageManager(new Driver());
            $file=$request->file('image');
            $image=$manager->read($file->getPathname());
            $image->resize(height:1200);
            $image=$image->toPng();
            $timestamp=time();
            $originalName=pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename=$timestamp . '_' . $originalName . '.png';
            $path=public_path('storage/posts' . $filename);
            //dd($public_path());
            $image->save($path);
        }
        $post=Post::create([
            'name'=>$request->name,
            'desc'=>$request->desc,
            'slug'=>$request->slug,
            'image'=>'storage/posts' . $filename,
            'category_id'=>$request->category_id,
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id,
        ]);

        return redirect()->route('post.index')->with('status','Uspesno Sacuvano');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories=Category::latest()->get();
        return view('post.edit',compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validate([
            'name'=>"required|min:3",
            'desc'=>'required',
            'slug'=>'required|unique:posts,slug,'.$post->id,
            'image'=>'image|mimes:png,jpg,webp|max:2048',
            'category_id'=>'required'
        ]);
        if($request->hasFile('image'))
        {
            if (File::exists(public_path($post->image))){
                File::delete(public_path($post->image));
            }
            $manager=new ImageManager(new Driver());
            $file=$request->file('image');
            $image=$manager->read($file->getPathname());
            $image->resize(height:1200);
            $image=$image->toPng();
            $timestamp=time();
            $originalName=pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename=$timestamp . '_' . $originalName . '.png';
            $path=public_path('storage/posts' . $filename);
            $db_path='storage/posts' . $filename;
            $image->save($path);
        }
        else{
            $db_path=$post->image;
        }
        $post->update([
            'name'=>$request->name,
            'desc'=>$request->desc,
            'slug'=>$request->slug,
            'image'=>$db_path,
            'category_id'=>$request->category_id,
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id,
        ]);

        return redirect()->route('post.index')->with('status','Uspesno Sacuvano');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (File::exists(public_path($post->image))){
            File::delete(public_path($post->image));
        }
        $post->delete();
        return redirect()->route('post.index')->with('status','Uspesno obrisano!');
    }
}
