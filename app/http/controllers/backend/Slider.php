<?php


namespace app\http\controllers\backend;

use app\http\models\Sliders;

use core\Request;

use core\Session;

class Slider 
{
    public function Index(){

        $sliders = Sliders::orderBy('id','DESC')->get();
      
        return view("backend/sliders/slider", compact('sliders'));
    }

    public function Create(){

        return view("backend/sliders/new_slider");
    }

    public function Store(Request $request){

        $attributes = [];

        $attributes["alternative_text"] = $request->request("alternative_text");

        if($file = $request->file("slider")){

            $name = hexdec(uniqid()).".".$file->getClientOriginalExtension();

            $isUploaded = $file->save(public_path("/uploads/"), $name);

            if($isUploaded){

                $attributes['slider_image'] = $name;

            }

        }

        Sliders::create($attributes);

        return redirect("/admin/sliders");

    }

    public function Delete(){

        $id = $_GET['target'];

        $find = Sliders::find($id);

        $data = $find->get();

        try {

            if($data['slider_image']) unlink(public_path()."/uploads/".$data['slider_image']);

        } catch (\Throwable $th) {
            //throw $th;
        }
       
        $isDelete =  $find->Delete();

        if($isDelete) redirect("/admin/sliders");

        dd("We cannot delete this item !! Error occured . Contact Engineer !!");
    }

    public function Edit(){

        $id = $_GET['target'];

        $slide = Sliders::find($id)->get();

        return view("backend/sliders/edit_slider", compact('slide'));
    }

    public function Update(Request $req){

        $data = Sliders::find($req->request('id'));

        
        $attributes = [];

        if($req->request('alternative_text')) $attributes['alternative_text'] = $req->request('alternative_text');

        if($file = $req->file('slider')){

            $name = hexdec(uniqid()).".".$file->getClientOriginalExtension();

            $isUploaded = $file->save(public_path("/uploads/"), $name);

            if($isUploaded){

                $image = $data->get();

                if($image['slider_image'])  unlink(public_path()."/uploads/".$image['slider_image']);
              
                $attributes['slider_image'] = $name;

            }
        }

        $data->update($attributes);

        Session::flash("message", "Slider has been updated");

        return back();

    }
}