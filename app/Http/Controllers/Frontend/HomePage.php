<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

//Models
use App\Models\Category;
use App\Models\Article;
use App\Models\Config;
use App\Models\Page;
use App\Models\Contact;


class HomePage extends Controller
{

    public function __construct()
    {
        if(Config::find(1)->active == 0){
            // return redirect()->to('offline')->send();
            return redirect()->to('offline')->send();
        }
        view()->share('pages',Page::orderBy('order','ASC')->where('status',1)->get());
        view()->share('categories',Category::where('status',1)->inRandomOrder()->get());
    }

    public function index()
    {
        $data['articles'] = Article::with('getCategory')->where('status',1)->whereHas('getCategory',function($query){
            $query->where('status',1);
        })->orderBy('created_at','DESC')->paginate(10);
        $data['articles']->withPath(url('/sehife'));

        return view('frontend.homepage',$data);
    }

    public function single($category,$slug)
    {
        $category = Category::whereSlug($category)->first() ?? abort(403,'Kateqoriya Movcud Deyil');
        $article= Article::whereSlug($slug)->whereCategoryId($category->id)->first() ?? abort(403,'Movzu Movcud Deyil');
        $article->increment('hit');
        $data['article'] = $article;
        return view('frontend.single',$data);
    }

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->first() ?? abort(403,'Kateqoriya Tapilmadi');
        $data['category'] = $category;
        $data['articles'] = Article::whereCategoryId($category->id)->where('status',1)->orderBy('created_at','DESC')->paginate(1);
        return view('frontend.category',$data); 
    }

    public function page($slug)
    {
        $page = Page::whereSlug($slug)->first() ?? abort(403,'Sehife Tapilmadi...');
        $data['page'] = $page;
        return view('frontend.page',$data);
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function contactPost(Request $request)
    {
        //Validate ve Validator::make arasindaki ferq validator yeni bir validate qura bilirsen message rules attributes kimi bir cox weyi deyise bilirsen ve errorlari oz isteyine uygun gondere bilirsen Validate ise avtomatik isleyir eger qisa bir sorgudursa Validate islenilmesi daha suretlidir zaman baximindan

        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'topic' => 'required',
            'message' => 'required|min:10'
        ];
        $validate = Validator::make($request->post(),$rules);

        if($validate->fails())
        {
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }

        Mail::send([],[],function($message)use($request){
            $message->from('iletisim@blogsite.com','Blog Sitesi');
            $message->setBody('Mesaj By: '.$request->name.'<br>
            Mesaji Gonderen Mail:'.$request->mail.'<br>
            Mesaj Movzu: ' .$request->topic.'<br>
            Mesaj:'.$request->message.'<br><br>
            Tarix:'.now(),'text/html');
            $message->to('human@blogsite.com');
            $message->subject($request->name.'elaqeden mesaj gonderildi');

        });



        /* $contact = new Contact;
        $contact->name=$request->name;
        $contact->email=$request->email;
        $contact->topic=$request->topic;
        $contact->message=$request->message;
        $contact->save(); */


        return redirect()->route('contact')->with('success','Melumatlar Gonderildi');
    }
}
