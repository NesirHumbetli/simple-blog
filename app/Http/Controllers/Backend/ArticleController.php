<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at','DESC')->get();
        return view('backend.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.articles.create',compact('categories'));        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'content' => 'required'
        ]);

        $article = new Article();
        $article->title=$request->title;
        $article->category_id=$request->category;
        $article->content=$request->content;
        $article->slug=Str::slug($request->title);

        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $article->image='uploads/'.$imageName;
        }
        $article->save();
        toastr()->success('Ugurlu','Meqale Ugurla Elave edildi.');
        return redirect()->route('manage.meqale.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('backend.articles.update',compact('categories','article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $update = Article::findOrFail($id);
        $update->title=$request->title;
        $update->category_id=$request->category;
        $update->content=$request->content;
        $update->slug=Str::slug($request->title);
        if($request->hasFile('image')){
            $delImg=$update->image;
            unlink(public_path($delImg));
            $file_name = Str::slug($request->title).uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$file_name);
            $update->image='uploads/'.$file_name;
        }
        toastr()->success('Ugurlu Emeliyyat','Meqale Redakte Edildi.');
        $update->save();
        return redirect()->route('manage.meqale.index');

    }

    public function switch(Request $request)
    {   
        $article = Article::findOrFail($request->id);
        $article->status = $request->status=='true' ? 1:0;
        $article->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Article::where('id',$id)->update(['category_id'=>1]);

        $article = Article::find($id);
        $article->delete();
        toastr()->success('Meqale Silindi');
        return redirect()->route('manage.meqale.index');
    }

    public function trashed()
    {
        $articles = Article::onlyTrashed()->orderBy('deleted_at','DESC')->get();
        return view('backend.articles.trashed',compact('articles'));
    }

    public function recover($id)
    {
        Article::onlyTrashed()->find($id)->restore();
        toastr()->success('Məqalə Uğular Bərpa Edildi.');
        return redirect()->back();
    }

    public function hardDelete($id)
    {

        $article = Article::onlyTrashed()->find($id);
        if(File::exists($article->image)){
            File::delete(public_path($article->image));   
        }
        $article->forceDelete();        
        toastr()->success('Meqale Bazadan Silindi');
        return redirect()->back();
    }

    public function destroy($id)
    {
        return $id;
    }
}
