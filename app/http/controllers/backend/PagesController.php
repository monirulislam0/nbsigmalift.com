<?php 

namespace app\http\controllers\backend;

use app\http\requests\AboutRequest;
use app\http\requests\FaqRequest;
use core\Request;
use app\http\models\AboutPage;
use app\http\models\CertificatePage;
use app\http\models\ProductPage;
use app\http\models\Region;
use app\http\models\GlobalPartnersPage;
use app\http\models\OurProjects;
use app\http\models\Partners;
use app\http\models\Projects;
use app\http\models\CompanyProfilePage;
use app\http\models\ContactPage;
use app\http\models\NewsPage;
use app\http\models\eFaqPage;
use core\Session;


class PagesController 
{

    public function IndexAbout()
    {
        $page = AboutPage::all()->first()->get();
        return view('/backend/pages/about',compact('page'));
    }

    public function StoreAbout(AboutRequest $request){
        $find = AboutPage::find($request->request('id'));
        $oldPage = $find->get();
        $attributes = [];

        if($request->request('page_title')) $attributes['page_title'] = $request->request("page_title");
        if($request->request('page_content')) $attributes['page_content'] = $request->request("page_content");
        if($request->request('alt_text')) $attributes['alt_text'] = $request->request("alt_text");
        if($request->request('meta_tags')) $attributes['meta_tags'] = $request->request("meta_tags");
        if($request->request('OgTitle')) $attributes['og_title'] = $request->request("OgTitle");
        if($request->request('OgDescription')) $attributes['og_description'] = $request->request("OgDescription");
        if($request->has_file("banner_image")){
            if($oldPage["banner_image"]) unlink(public_path("/uploads/".$oldPage['banner_image']));
            $file = $request->file("banner_image");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['banner_image'] = $name;
        }
         if($request->has_file("OgImage")){
            if($oldPage["og_image"]) unlink(public_path("/uploads/".$oldPage['og_image']));
            $file = $request->file("OgImage");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['og_image'] = $name;
        }
        $find->update($attributes);
        Session::flash('message', "Hey admin, I'm updated !!");
        redirect("/admin/pages/product");
    }

    public function IndexProduct(){
        $page = ProductPage::all()->first()->get();
        return view('/backend/pages/product',compact('page'));
    }

    public function StoreProduct(Request $request){

        $request->validate(
            [
                'page_content'  => 'required',
                'page_title'    => 'required'
            ],
             [
                'page_content.required' => 'Page content are essential , You cannot move next without me !!',
                'page_title.required' => 'Page content are essential , You cannot move next without me !!'
             ]
        );

        $find = ProductPage::find($request->request('id'));
        $oldPage = $find->get();
        $attributes = [];

        if($request->request('page_title')) $attributes['page_title'] = $request->request("page_title");
        if($request->request('page_content')) $attributes['page_content'] = $request->request("page_content");
        if($request->request('alt_text')) $attributes['alt_text'] = $request->request("alt_text");
        if($request->request('meta_tags')) $attributes['meta_tags'] = $request->request("meta_tags");
        if($request->request('OgTitle')) $attributes['og_title'] = $request->request("OgTitle");
        if($request->request('OgDescription')) $attributes['og_description'] = $request->request("OgDescription");
        if($request->has_file("banner_image")){
            if($oldPage["banner_image"]) unlink(public_path("/uploads/".$oldPage['banner_image']));
            $file = $request->file("banner_image");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['banner_image'] = $name;
        }
         if($request->has_file("OgImage")){
            if($oldPage["og_image"]) unlink(public_path("/uploads/".$oldPage['og_image']));
            $file = $request->file("OgImage");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['og_image'] = $name;
        }
        $find->update($attributes);
        Session::flash('message', "Hey admin, I'm updated !!");
        redirect("/admin/pages/product");
    }

    //GlobalPartners 

    public function IndexGlobalPartners(){
        $page = GlobalPartnersPage::all()->first()->get();
        $partners = Partners::all()->get();
        $regions = Region::all()->get();
        return view('/backend/pages/global_partners',compact('page','regions','partners'));
    }

    public function StoreGlobalPartners(Request $request){

        $request->validate(
            [
                'page_content'  => 'required',
                'page_title'    => 'required'
            ],
             [
                'page_content.required' => 'Page content are essential , You cannot move next without me !!',
                'page_title.required' => 'Page content are essential , You cannot move next without me !!'
             ]
        );

        $find = GlobalPartnersPage::find($request->request('id'));
        $oldPage = $find->get();
        $attributes = [];

        if($request->request('page_title')) $attributes['page_title'] = $request->request("page_title");
        if($request->request('page_content')) $attributes['page_content'] = $request->request("page_content");
        if($request->request('alt_text')) $attributes['alt_text'] = $request->request("alt_text");
        if($request->request('meta_tags')) $attributes['meta_tags'] = $request->request("meta_tags");
        if($request->request('OgTitle')) $attributes['og_title'] = $request->request("OgTitle");
        if($request->request('OgDescription')) $attributes['og_description'] = $request->request("OgDescription");
        if($request->has_file("banner_image")){
            if($oldPage["banner_image"]) unlink(public_path("/uploads/".$oldPage['banner_image']));
            $file = $request->file("banner_image");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['banner_image'] = $name;
        }
         if($request->has_file("OgImage")){
            if($oldPage["og_image"]) unlink(public_path("/uploads/".$oldPage['og_image']));
            $file = $request->file("OgImage");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['og_image'] = $name;
        }
        $find->update($attributes);
        Session::flash('message', "Hey admin, I'm updated !!");
        redirect("/admin/pages/global-partners");
    }

    public function StoreGlobalPartnersRegion(Request $req){
        $req->validate([
            'region'    => 'required',
        ],[
            'region.required'   => 'Region is required !!',
        ]
        );
        Region::create([
            'region'    => $req->request("region"),
        ]);
        Session::flash('message', "Region '".$req->request("region")."' is inserted successfully !!");
        redirect("/admin/pages/global-partners");
    }
    public function DeleteGlobalPartnersRegion(){
        $id = $_GET['target'];
        
        $find = Region::find($id);


       $find->delete();

       Session::flash('message', 'Region has been deleted !!');

       redirect("/admin/pages/global-partners");
    }

    public function StoreGlobalPartnersDetails(Request $req){

        $req->validate([
            'country_name'  => 'required',
            'company_details'  => 'required',
        ],[
            'country_name.required'     => 'Country Name is required !!',
            'company_details.required'     => 'Company Details is required !!',
        ]);
        Partners::create([
            'region_id' => $req->request('region_id'),
            'country_name' => $req->request('country_name'),
            'company_details' => $req->request('company_details')
        ]);
        Session::flash('message', "Partners is inserted successfully !!");
        redirect("/admin/pages/global-partners");
    }

    public function EditPartners(){
        $id = $_GET['target'];
        $partner = Partners::find($id)->get();
        $page = GlobalPartnersPage::all()->first()->get();
        $partners = Partners::all()->get();
        $regions = Region::all()->get();
        return view('/backend/pages/global_partners',compact('page','regions','partners','partner'));
    }
    
    public function UpdatePartnersEdit(Request $req){
        
        $id = $req->request('id');
        
        $req->validate([
            'country_name'  => 'required',
            'company_details'  => 'required',
        ],[
            'country_name.required'     => 'Country Name is required !!',
            'company_details.required'     => 'Company Details is required !!',
        ]);
        Partners::find($id)->update([
            'region_id' => $req->request('region_id'),
            'country_name' => $req->request('country_name'),
            'company_details' => $req->request('company_details')
        ]);
        Session::flash('message', "Partners has been updated successfully !!");
        redirect("/admin/pages/global-partners");
    }
    public function DeleteGlobalPartnersDetails(){
        $id = $_GET['target'];
        
        $find = Partners::find($id);


       $find->delete();

       Session::flash('message', 'Partners has been deleted !!');

       redirect("/admin/pages/global-partners");
    }

    //Get Partners For Frontend

    public function GetPartnersDetails()
    {   
        try{
        $id = $_GET['target'];
        $partner = Partners::find($id)->get();
        $partner = json_encode($partner);
        echo $partner;
        http_response_code(200);
        }catch(\Exception $e){
            http_response_code(400);
        }
       
    }
    //IndexOurProjects

    public function IndexOurProjects(){
        $page = OurProjects::all()->first()->get();
        $projects = Projects::all()->get();
        return view('/backend/pages/our_projects',compact('page','projects'));
    }

    //StoreOurProjects

    public function StoreOurProjects(Request $request){
        $request->validate(
            [
                'page_content'  => 'required',
                'page_title'    => 'required'
            ],
             [
                'page_content.required' => 'Page content are essential , You cannot move next without me !!',
                'page_title.required' => 'Page content are essential , You cannot move next without me !!'
             ]
        );

        $find = OurProjects::find($request->request('id'));
        $oldPage = $find->get();
        $attributes = [];

        if($request->request('page_title')) $attributes['page_title'] = $request->request("page_title");
        if($request->request('page_content')) $attributes['page_content'] = $request->request("page_content");
        if($request->request('alt_text')) $attributes['alt_text'] = $request->request("alt_text");
        if($request->request('meta_tags')) $attributes['meta_tags'] = $request->request("meta_tags");
        if($request->request('OgTitle')) $attributes['og_title'] = $request->request("OgTitle");
        if($request->request('OgDescription')) $attributes['og_description'] = $request->request("OgDescription");
        if($request->has_file("banner_image")){
            if($oldPage["banner_image"]) unlink(public_path("/uploads/".$oldPage['banner_image']));
            $file = $request->file("banner_image");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['banner_image'] = $name;
        }
         if($request->has_file("OgImage")){
            if($oldPage["og_image"]) unlink(public_path("/uploads/".$oldPage['og_image']));
            $file = $request->file("OgImage");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['og_image'] = $name;
        }
        $find->update($attributes);
        Session::flash('message', "Hey admin, I'm updated !!");
        redirect("/admin/pages/our-projects");
    }

    public function StoreProjects(Request $req){
        $req->validate([
            'location'  => 'required',
        ],[
            'location.required' => 'This is required field. !! Must be filled '
        ]);
        $attributes=[
            'location' => $req->request('location'),
        ];
        if($req->has_file('project_image')){

            $file = $req->file('project_image');

            $name = hexdec(uniqid()).".".$file->getClientOriginalExtension();

            $isUploaded = $file->save(public_path("/uploads"), $name);

            if($isUploaded) $attributes['project_image'] = $name;

        }
        Projects::create($attributes);
        Session::flash('message', "Hey admin, Project has been added !!");
        redirect("/admin/pages/our-projects");
    }
    public function DeleteProjects(){
        $id = $_GET['target'];
        
        $find = Projects::find($id);

        $project = $find->get(); 

        if($project['project_image']) unlink(public_path("uploads/".$project['project_image']));

        $find->delete();

       Session::flash('message', 'Project has been deleted !!');

       redirect("/admin/pages/our-projects");
    }

    public function IndexCertificate(){
        $page = CertificatePage::all()->first()->get();
        return view('/backend/pages/certificate',compact('page'));
    }
    public function CertificateStore(Request $request){
        $request->validate(
            [
                'page_content'  => 'required',
                'page_title'    => 'required'
            ],
             [
                'page_content.required' => 'Page content are essential , You cannot move next without me !!',
                'page_title.required' => 'Page content are essential , You cannot move next without me !!'
             ]
        );

        $find = CertificatePage::find($request->request('id'));
        $oldPage = $find->get();
        $attributes = [];

        if($request->request('page_title')) $attributes['page_title'] = $request->request("page_title");
        if($request->request('page_content')) $attributes['page_content'] = $request->request("page_content");
        if($request->request('alt_text')) $attributes['alt_text'] = $request->request("alt_text");
        if($request->request('meta_tags')) $attributes['meta_tags'] = $request->request("meta_tags");
        if($request->request('OgTitle')) $attributes['og_title'] = $request->request("OgTitle");
        if($request->request('OgDescription')) $attributes['og_description'] = $request->request("OgDescription");
        if($request->has_file("banner_image")){
            if($oldPage["banner_image"]) unlink(public_path("/uploads/".$oldPage['banner_image']));
            $file = $request->file("banner_image");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['banner_image'] = $name;
        }
         if($request->has_file("OgImage")){
            if($oldPage["og_image"]) unlink(public_path("/uploads/".$oldPage['og_image']));
            $file = $request->file("OgImage");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['og_image'] = $name;
        }
        $find->update($attributes);
        Session::flash('message', "Hey admin, I'm updated !!");
        redirect("/admin/pages/certificate");
    }

    //IndexCompanyProfile

    public function IndexCompanyProfile(){
        $page = CompanyProfilePage::all()->first()->get();
        return view('/backend/pages/company_profile',compact('page'));
    }
    public function StoreCompanyProfile(Request $request){
        $request->validate(
            [
                'page_content'  => 'required',
                'page_title'    => 'required'
            ],
             [
                'page_content.required' => 'Page content are essential , You cannot move next without me !!',
                'page_title.required' => 'Page content are essential , You cannot move next without me !!'
             ]
        );

        $find = CompanyProfilePage::find($request->request('id'));
        $oldPage = $find->get();
        $attributes = [];

        if($request->request('page_title')) $attributes['page_title'] = $request->request("page_title");
        if($request->request('page_content')) $attributes['page_content'] = $request->request("page_content");
        if($request->request('alt_text')) $attributes['alt_text'] = $request->request("alt_text");
        if($request->request('meta_tags')) $attributes['meta_tags'] = $request->request("meta_tags");
        if($request->request('OgTitle')) $attributes['og_title'] = $request->request("OgTitle");
        if($request->request('OgDescription')) $attributes['og_description'] = $request->request("OgDescription");
        if($request->has_file("banner_image")){
            if($oldPage["banner_image"]) unlink(public_path("/uploads/".$oldPage['banner_image']));
            $file = $request->file("banner_image");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['banner_image'] = $name;
        }
         if($request->has_file("OgImage")){
            if($oldPage["og_image"]) unlink(public_path("/uploads/".$oldPage['og_image']));
            $file = $request->file("OgImage");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['og_image'] = $name;
        }
        $find->update($attributes);
        Session::flash('message', "Hey admin, I'm updated !!");
        redirect("/admin/pages/company-profile");
    }


    // Public IndexNews
    public function IndexNews(){
        $page = NewsPage::all()->first()->get();
        return view('/backend/pages/news',compact('page'));
    }

    public function StoreNews(Request $request){
        $request->validate(
            [
                'page_content'  => 'required',
                'page_title'    => 'required'
            ],
             [
                'page_content.required' => 'Page content are essential , You cannot move next without me !!',
                'page_title.required' => 'Page content are essential , You cannot move next without me !!'
             ]
        );

        $find = NewsPage::find($request->request('id'));
        $oldPage = $find->get();
        $attributes = [];

        if($request->request('page_title')) $attributes['page_title'] = $request->request("page_title");
        if($request->request('page_content')) $attributes['page_content'] = $request->request("page_content");
        if($request->request('alt_text')) $attributes['alt_text'] = $request->request("alt_text");
        if($request->request('meta_tags')) $attributes['meta_tags'] = $request->request("meta_tags");
        if($request->request('OgTitle')) $attributes['og_title'] = $request->request("OgTitle");
        if($request->request('OgDescription')) $attributes['og_description'] = $request->request("OgDescription");
        if($request->has_file("banner_image")){
            if($oldPage["banner_image"]) unlink(public_path("/uploads/".$oldPage['banner_image']));
            $file = $request->file("banner_image");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['banner_image'] = $name;
        }
         if($request->has_file("OgImage")){
            if($oldPage["og_image"]) unlink(public_path("/uploads/".$oldPage['og_image']));
            $file = $request->file("OgImage");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['og_image'] = $name;
        }
        $find->update($attributes);
        Session::flash('message', "Hey admin, I'm updated !!");
        redirect("/admin/pages/news");
    }

    public function IndexContact(){
        $page = ContactPage::all()->first()->get();
        return view('/backend/pages/contact',compact('page'));
    }

    public function StoreContact(Request $request){
        $request->validate(
            [
                'page_content'  => 'required',
                'page_title'    => 'required'
            ],
             [
                'page_content.required' => 'Page content are essential , You cannot move next without me !!',
                'page_title.required' => 'Page content are essential , You cannot move next without me !!'
             ]
        );

        $find = ContactPage::find($request->request('id'));
        $oldPage = $find->get();
        $attributes = [];

        if($request->request('page_title')) $attributes['page_title'] = $request->request("page_title");
        if($request->request('page_content')) $attributes['page_content'] = $request->request("page_content");
        if($request->request('alt_text')) $attributes['alt_text'] = $request->request("alt_text");
        if($request->request('meta_tags')) $attributes['meta_tags'] = $request->request("meta_tags");
        if($request->request('OgTitle')) $attributes['og_title'] = $request->request("OgTitle");
        if($request->request('OgDescription')) $attributes['og_description'] = $request->request("OgDescription");
        if($request->request('google_iframe')) $attributes['google_iframe'] = $request->request('google_iframe');
        if($request->has_file("banner_image")){
            if($oldPage["banner_image"]) unlink(public_path("/uploads/".$oldPage['banner_image']));
            $file = $request->file("banner_image");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['banner_image'] = $name;
        }
         if($request->has_file("OgImage")){
            if($oldPage["og_image"]) unlink(public_path("/uploads/".$oldPage['og_image']));
            $file = $request->file("OgImage");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['og_image'] = $name;
        }
        $find->update($attributes);
        Session::flash('message', "Hey admin, I'm updated !!");
        redirect("/admin/pages/contact-us");
    }
    
    
      
    // Faq Pages
    
    public function IndexFaq()
    {
        $page = eFaqPage::all()->first()->get();
        return view('/backend/pages/faq',compact('page'));
    }

    public function StoreFaq(FaqRequest $request){
        $find = eFaqPage::find($request->request('id'));
        $oldPage = $find->get();
        $attributes = [];

        if($request->request('page_title')) $attributes['page_title'] = $request->request("page_title");
        if($request->request('page_content')) $attributes['page_content'] = $request->request("page_content");
        if($request->request('alt_text')) $attributes['alt_text'] = $request->request("alt_text");
        if($request->request('meta_tags')) $attributes['meta_tags'] = $request->request("meta_tags");
        if($request->request('OgTitle')) $attributes['og_title'] = $request->request("OgTitle");
        if($request->request('OgDescription')) $attributes['og_description'] = $request->request("OgDescription");
        if($request->has_file("banner_image")){
            if($oldPage["banner_image"]) unlink(public_path("/uploads/".$oldPage['banner_image']));
            $file = $request->file("banner_image");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['banner_image'] = $name;
        }
         if($request->has_file("OgImage")){
            if($oldPage["og_image"]) unlink(public_path("/uploads/".$oldPage['og_image']));
            $file = $request->file("OgImage");
            $name = hexdec(uniqid())."-".$file->getClientOriginalName();
            $name = strtolower(str_replace(' ','-', $name));
            $file->save(public_path("/uploads"), $name);
            $attributes['og_image'] = $name;
        }
        $find->update($attributes);
        Session::flash('message', "Hey admin, I'm updated !!");
        redirect("/admin/pages/faq");
    }
    
    
    
    
}
