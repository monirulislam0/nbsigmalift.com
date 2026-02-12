<?php 

namespace app\http\controllers\frontend ;
use app\http\models\Products;
use app\http\models\News;
use app\http\models\Sliders;
use core\Request;

class FrontendController 
{
    public function index(){
        $site_settings = \app\http\models\SiteSettings::all()->first()->get();
        $page = [
                'page_title' => $site_settings['meta_title'],
                'og_title'   => $site_settings['meta_title'],
            ];
        $sliders = Sliders::all()->get();
        return view('frontend/index',compact('sliders','page'));
        
    }

    public function about(){

        $page = \app\http\models\AboutPage::all()->first()->get();

        return view('frontend/about',compact('page'));

    }

    public function products(){
        
        $pageNumber = $_GET['page'] ?? 1;
        $rows = ceil(count(Products::orderBy("id","DESC")->get())/16) ;

        $products = Products::paginate(16, $pageNumber);

         $page = \app\http\models\ProductPage::all()->first()->get();

        return view('frontend/product',compact('products','page', 'rows'));

    }

    public function certificate(){
        $page = \app\http\models\CertificatePage::all()->first()->get();
        return view('frontend/certificate',compact('page'));
        
    }

    public function company_profile(){
        $page = \app\http\models\CompanyProfilePage::all()->first()->get();
        return view('frontend/company_profile',compact('page'));

    }

    public function global_partner(){
        $page = \app\http\models\GlobalPartnersPage::all()->first()->get();
        return view('frontend/global_partner',compact('page'));

    }

    public function project(){
        $projects = \app\http\models\Projects::all()->get();
        $page = \app\http\models\OurProjects::all()->first()->get();
        return view('frontend/project',compact('projects','page'));

    }

    public function news(){
        $page = \app\http\models\NewsPage::all()->first()->get();
        $news = News::all()->get();
        return view('frontend/news',compact('news','page'));
        
    }

    public function contact(){
        $page = \app\http\models\ContactPage::all()->first()->get();
        return view('frontend/contact', compact('page'));

    }
    
    // SearchResults
    
    public function SearchResults(){
        $search_key = $_GET['search_key'];
       $products = Products::search($search_key)->get();
        $page = \app\http\models\ProductPage::all()->first()->get();
      
      return view('frontend/search_product',compact('products','page', 'search_key'));
    }
    
     public function FaqPage(){
         $page = \app\http\models\eFaqPage::all()->first()->get();
        $items = \app\http\models\FaqPage::all()->get();
        return view('frontend/faq',compact('items','page'));
    }
    
}