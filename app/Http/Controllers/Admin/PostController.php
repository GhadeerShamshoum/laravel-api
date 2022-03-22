<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Post;
use App\Tag;
use Illuminate\Support\facades\Storage;
use App\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $validate = [
        'title' => 'required|max:255',
        'content' => 'required',
        'category_id' => 'nullable|exists:categories,id',
        'image' => 'nullable| mimes:jpeg, bmp, png,jpg| max:2048',
        'tags' => 'exists:tags,id'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $tags = Tag::all();
        return view('admin.posts.index', compact('posts', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validate);

        $form_data = $request->all();
        if(isset($form_data["image"])){
            // save img 
            $img_path = Storage::put('uploads', $form_data['image']);
            //save img Database
            $form_data["image"] = $img_path;
        }

        $slugTmp = Str::slug($form_data['title']);
        $count = 1;
        while(Post::where('slug', $slugTmp)->first()){
            $slugTmp = Str::slug($form_data['title'])."-".$count;
            $count++;
        }
        $form_data['slug'] = $slugTmp;
        $new_post = new Post();

        $new_post->fill($form_data);
        $new_post->save();

        if(isset($form_data['tags'])){
            $new_post->tags()->sync($form_data['tags']);
        }

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if(!$post){
            abort(404);
        }
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post','categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->validate);

        $form_data = $request->all();

        if($post->title == $form_data ['title']){            
            $slug = $post->slug;
        }else{
            $slug = Str::slug($form_data['title']);        
            $count = 1;
            while(Post::where('slug', $slug)->where('id', '!=', $post->id)->first()){
                $slug = Str::slug($form_data['title'])."-".$count;
                $count ++;
            }
        }
        $form_data['slug'] = $slug;
        
        $post->update($form_data);

        $post->tags()->sync(isset($form_data['tags']) ? $form_data['tags'] : []);

        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
