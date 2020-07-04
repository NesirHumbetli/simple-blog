<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Article;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('backend.category.index',compact('categories'));
    }

    public function switch(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status=$request->status=='true'?1:0;
        $category->save();
    }

    public function getData(Request $request)
    {
        $category = Category::findOrFail($request->id);
        return response()->json($category);
    }

    public function categoryPost(Request $request)
    {
        $isCategory=Category::whereSlug(Str::slug($request->category))->first();
        if($isCategory){
            toastr()->error($request->category.' adlı kateqoriya mövcuddur.');
            return redirect()->back();
        }

        $category = new Category;
        $category->name = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Yeni Kateqoriya Elave Edildi.');
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $isCategory=Category::whereSlug(Str::slug($request->slug))->whereNotIn('id',[$request->id])->first();
        $isName=Category::whereName($request->category)->whereNotIn('id',[$request->id])->first();
        if($isCategory or $isName){
            toastr()->error($request->category.' adlı kateqoriya mövcuddur.');
            return redirect()->back();
        }

        $category = Category::find($request->id);
        $category->name = $request->category;
        $category->slug = Str::slug($request->slug);
        $category->save();
        toastr()->success('Kateqoriya Redaktə Edildi.');
        return redirect()->back();
    }
    
    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->id);
        if($category->id==1){
            toastr()->error('Bu Kateqoriya Silinə Bilməz.');
            return redirect()->back();
        }
        $message='';
        $count=$category->articleCount();
        if($count>0){
            Article::where('category_id',$category->id)->update(['category_id'=>1]);
            $defaultCategory=Category::find(1);
            $message = 'Bu kateqoriyaya aid '.$count.'meqale'.$defaultCategory->name.'kateqoriyasina elave edildi.';
        }
        
        $category->delete();
        toastr()->success($message,'Kateqoriya Ugurla Silindi');
        return redirect()->back();
    }
}
