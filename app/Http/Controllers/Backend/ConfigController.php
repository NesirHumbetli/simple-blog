<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
class ConfigController extends Controller
{
    public function index()
    {
        $config = Config::find(1);
        return view('backend.config.index',compact('config'));
    }

    public function update(Request $request)
    {
        $config = Config::findOrFail(1);
        $config->title=$request->title;
        $config->active=$request->active;
        $config->facebook=$request->facebook;
        $config->youtube=$request->youtube;
        $config->instagram=$request->instagram;
        $config->linkedin=$request->linkedin;
        $config->twitter=$request->twitter;
        $config->github=$request->github;

        if($request->hasFile('logo')){
            if(File::exists($config->logo)){
                File::delete(public_path($config->logo));
            }
            $name = Str::slug($request->title).'-logo'.'.'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('uploads'),$name);
            $config->logo='uploads/'.$name;
        }
        if($request->hasFile('favicon')){
            if(File::exists($config->favicon)){
                File::delete(public_path($config->favicon));
            }
            $name = Str::slug($request->title).'-favicon'.'.'.$request->favicon->getClientOriginalExtension();
            $request->favicon->move(public_path('uploads'),$name);
            $config->favicon='uploads/'.$name;
        }

        $config->save();
        toastr()->success('Parametrler Redakte Olundu.');
        return redirect()->back();



    }
}
