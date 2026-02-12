<?php 


namespace app\http\controllers\backend;

use app\http\models\SiteSettings as SiteSetting;

use core\Request ;

class SiteSettings 
{
    public function index ()
    {

      
       $data = SiteSetting::all()->first()->get();

        return view('/backend/site_settings', compact('data'));

    }

    public function update(Request $request){
        
        $data = SiteSetting::all()->first();

    
        $attributes = [];

        if(! empty($request->request("meta_author"))) $attributes['meta_author'] =  $request->request("meta_author");
        if(! empty($request->request("meta_title"))) $attributes['meta_title'] =  $request->request("meta_title");
        if(! empty($request->request("meta_description"))) $attributes['meta_description'] =  $request->request("meta_description");
        if(! empty($request->request("copywrite_text"))) $attributes['copywrite_text'] =  $request->request("copywrite_text");


        if( $file = $request->file('logo')){

          $name = hexdec(uniqid()).".".$file->getClientOriginalExtension();

          $isUpload = $file->save(public_path("/uploads"), $name);

          if($isUpload) $attributes['logo'] = $name;

          if($isUpload && !empty($data->get()['logo'])) unlink(public_path("/uploads/".$data->get()['logo']));
        }

        if( $file = $request->file('icon')){

            $name = hexdec(uniqid()).".".$file->getClientOriginalExtension();
  
            $isUpload = $file->save(public_path("/uploads"), $name);
  
            if($isUpload) $attributes['icon'] = $name;

            if($isUpload && !empty($data->get()['icon'])) unlink(public_path("/uploads/".$data->get()['icon']));

  
          }

          $data->update($attributes);
      
          return back();
    }
}