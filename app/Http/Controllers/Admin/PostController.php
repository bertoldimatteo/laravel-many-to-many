<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
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
        // validazione dati
        $request->validate([
            'title' => 'required | string | max:255',
            'content' => 'required | string | max:65000',
            'published' => 'sometimes | accepted',
            'category_id' => 'nullable | exists:categories,id',
            'tags' => 'nullable | exists:tags,id'
        ]);
        // prendo i dati request e creo il post
        $data = $request->all();
        $newPost = new Post();
        $newPost->fill($data);

        $newPost->slug = $this->getSlug($data['title']);

        $newPost->published = isset($newPost->published);
        $newPost->save();

        // se ci sono dei tag associati, li associo al post appena creato
        if(isset($data['tags'])){
            $newPost->tags()->sync($data['tags']);
        }
        // reinidirizzo a un altra pagina
        return redirect()->route('admin.posts.show', $newPost->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
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
        $postTags = $post->tags->map(function ($item){
            return $item->id;
        })->toArray();
        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'postTags'));
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
        // validazione
        $request->validate([
            'title' => 'required | string | max:255',
            'content' => 'required | string | max:65000',
            'published' => 'sometimes | accepted',
            'category_id' => 'nullable | exists:categories,id'
        ]);
        // aggiornamento
        $data = $request->all(); // prendo tutti i dati
        // se cambia il titolo genero il nuovo slug
        if( $post->title != $data['title']) {
            $post->slug = $this->getSlug($data['title']);
        }
        //prima va sempre il fill
        $post->fill($data);  //aggiorno il post con i dati nuovi

        $post->published = isset($post->published);

        $post->save();
        // return
        return redirect()->route('admin.posts.show', $post->id);
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
        // ritorno alla home 
        return redirect()->route('admin.posts.index');
    }

    private function getSlug($title)
    {
        $slug = Str::of($title)->slug('-');
        $count = 1;

        while(Post::where('slug' , $slug)->first() ){
            $slug = Str::of($title)->slug('-') . "-{$count}";
            $count++;
        }

        return $slug;
    }
}
