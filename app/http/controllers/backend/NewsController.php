<?php 


namespace app\http\controllers\backend;

use app\http\models\News;
use app\http\requests\NewsRequest;
use core\Session;
class NewsController{


public function NewsManager(){
    $news = News::all()->get();
    return view('backend/news/index',compact('news'));
}

public function Create(){
    return view('backend/news/create');

}
public function Store(NewsRequest $req){

    $attributes = [];

    $attributes['news_title'] = $req->request('news_name');
    $attributes['content'] = $req->request('content');

    if($req->has_file("news_image")){
        $file = $req->file("news_image");
        $name = hexdec(uniqid())."-".$file->getClientOriginalName();
        $name = strtolower(str_replace(' ','-', $name));
        $file->save(public_path("/uploads"), $name);
        $attributes['news_image'] = $name;
    }
    if($req->has_file("OgImage")){
        $file = $req->file("OgImage");
        $name = hexdec(uniqid())."-".$file->getClientOriginalName();
        $name = strtolower(str_replace(' ','-', $name));
        $file->save(public_path("/uploads"), $name);
        $attributes['og_image'] = $name;
    }


    if($req->request("meta_tags")) $attributes ['meta_tags'] = $req->request("meta_tags");
    if($req->request("alt_text")) $attributes ['alt_text'] = $req->request("alt_text");
    if($req->request("OgTitle")) $attributes ['og_title'] = $req->request("OgTitle");
    if($req->request("OgDescription")) $attributes ['og_description'] = $req->request("OgDescription");
    if($req->request("alt_text")) $attributes ['alt_text'] = $req->request("alt_text");
    if($req->request("meta_title")) $attributes ['meta_title'] = $req->request("meta_title");
    if($req->request("meta_description")) $attributes ['meta_description'] = $req->request("meta_description");


    News::create($attributes);
    return redirect('/admin/manager/news')->with('message','News Added Successfully !!');   
    
}

    public function UpdateFeatured(){
      
        $id = $_GET['target'];
        $status = $_GET['status'];
        
        $find = News::find($id);
    
        $find->update(['featured' => $status]);
    
        $response = [
            'status' => true,
            'message' => 'featured has been updated !!',
        ];
        $response = json_encode($response);
        echo $response;
        http_response_code("200");
        exit();

    }
    public function EditNews(){
        $id = $_GET['target'];
        $news = News::find($id)->get();

        return view("backend/news/edit", compact('news'));
    }

    public function UpdateNews(NewsRequest $req){
        $id = $req->request('id');

        $find = News::find($id);

        $news = $find->get();

        $attributes = [];

        $attributes['news_title'] = $req->request('news_name');
        $attributes['content'] = $req->request('content');
    
        if($req->has_file("news_image")){

            if($news['news_image']) unlink(public_path("uploads/".$news["news_image"]));

            $file = $req->file("news_image");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['news_image'] = $name;
        }
        if($req->has_file("OgImage")){
            if($news['og_image']) unlink(public_path("uploads/".$news["og_image"]));
            $file = $req->file("OgImage");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['og_image'] = $name;
        }
    
    
        if($req->request("meta_tags")) $attributes ['meta_tags'] = $req->request("meta_tags");
        if($req->request("alt_text")) $attributes ['alt_text'] = $req->request("alt_text");
        if($req->request("OgTitle")) $attributes ['og_title'] = $req->request("OgTitle");
        if($req->request("OgDescription")) $attributes ['og_description'] = $req->request("OgDescription");
        if($req->request("alt_text")) $attributes ['alt_text'] = $req->request("alt_text");
    if($req->request("meta_title")) $attributes ['meta_title'] = $req->request("meta_title");
    if($req->request("meta_description")) $attributes ['meta_description'] = $req->request("meta_description");
    
        $find->update($attributes);
    Session::flash('message', 'News has been updated');
        return back();
    }
 public function SingleNews($slug){
    preg_match('/[^-]+$/', $slug, $matches);

    $id = $matches[0];
    $news = News::find($id)->get();

     // Og Description
    if(! $news['og_description']){
        $og_description = $news['short_description'];
    }else{
        $og_description = $news['og_description'];
    }
    

   if( !empty($news['meta_title'])){
        $page_title = $news['meta_title'];
    }elseif(!empty($news['og_title'])){
        $page_title = $news['og_title'];
    }else{
        $page_title = $news['news_title'];
    }
    
    if(! $news['og_image']){
        $og_image = $news['news_image'];
    }else{
        $og_image = $news['og_image'];
    }
    
    
    $page = [
            'og_description' => $og_description,
            'page_title'     => $page_title,
            'og_title'     => $news['og_title'],
            'meta_tags'     => $news['meta_tags'],
            'og_image'      => $og_image,
            'meta_description' => $news['meta_description']
        ];
        
        
    return view("frontend/single_news",compact('news','page'));
 }

    public function Destroy(){
        $id = $_GET['target'];
        $find = News::find($id);
        $data = $find->get();

        if( !empty($data['news_image']) ) unlink(public_path("/uploads/".$data['news_image']));

       $find->delete();

       Session::flash('message', 'News has been deleted');

       return back();
    }


}