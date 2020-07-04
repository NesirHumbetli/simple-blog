<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class PageController extends Controller
{ 
    public function index()
    {
        $pages = Page::all();
        return view('backend.pages.index',compact('pages'));
    }

    public function create()
    {
        return view('backend.pages.create');
    }

    public function post(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);
        $last = Page::orderBy('order','DESC')->first();

        $page = new Page;
        $page->title=$request->title;
        $page->content=$request->content;
        $page->order=$last->order+1;
        $page->slug=Str::slug($request->title);

        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $page->image='uploads/'.$imageName;
        }
        $page->save();
        toastr()->success('Səhifə Ugurla Elave edildi.');
        return redirect()->route('manage.page.index');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('backend.pages.update',compact('page'));

    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'title' => 'required|min:3',
            'image' => 'image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $page = Page::findOrFail($id);
        $page->title=$request->title;
        $page->content=$request->content;
        $page->slug=Str::slug($request->title);

        if($request->hasFile('image')){
            $imageName = Str::slug($request->title).uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $page->image='uploads/'.$imageName;
        }
        $page->save();
        toastr()->success('Səhifə Ugurla Redakte edildi.');
        return redirect()->route('manage.page.index');
    }

    public function delete($id)
    {
        $article = Page::find($id);
        if(File::exists($article->image)){
            File::delete(public_path($article->image));   
        }
        $article->delete();        
        toastr()->success('Səhifə Uğurla Silindi');
        return redirect()->route('manage.page.index');
    }

    public function switch(Request $request)
    {
        $pages = Page::findOrFail($request->id);
        $pages->status = $request->status=='true'?1:0;
        $pages->save();
    }

    public function sortable(Request $request)
    {
        foreach($request->get('page') as $key => $order){
            Page::where('id',$order)->update(['order'=>$key]);
        }
    }
}
