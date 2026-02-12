<?php 
/**
 * Remember it's custom Developed Framework 
 * You can see Brand New MVC Frameworkd So Becarefull About make any change Okay !! 
 * If you don't have enough knowladge about Polymorphism, Class, Object and other data types don't touch
 * 
 * Further Assitantce contact whatsapp : +880 1568 618189
 * email: mdmonirulislam.taluqdar.2000@gmail.com
 */

use core\Router;
use app\http\controllers\User;
use app\http\controllers\backend\HomeController;
use app\http\controllers\backend\SiteSettings;
use app\http\controllers\backend\Slider;
use app\http\controllers\backend\ProductsController;
use app\http\controllers\backend\NewsController;
use app\http\controllers\backend\PagesController;
use app\http\controllers\backend\FileManager;
use app\http\controllers\backend\authentication\SessionController;
use app\http\controllers\backend\MessagesController;
use app\http\controllers\frontend\FrontendController;
use app\http\controllers\backend\FaqController;


//Frontend Routes 

Router::get('/',[FrontendController::class, 'index']);
Router::get('/about',[FrontendController::class,'about']);
Router::get('/products',[FrontendController::class,'products']);
Router::get('/product/{slug}',[ProductsController::class,'SingleProducts']);
Router::get('/products-categories/{slug}',[ProductsController::class,'ProductsByCategory']);
// products-subcategories 
Router::get('/products-subcategories/{slug}',[ProductsController::class,'ProductBySubCategories']);
Router::get('/blog/{slug}',[NewsController::class,'SingleNews']);
Router::get('/why-choose-us',[FrontendController::class, 'certificate']);
Router::get('/factory-tours',[FrontendController::class, 'company_profile']);
Router::get('/distributor',[FrontendController::class, 'global_partner']);
Router::get('/projects',[FrontendController::class, 'project']);
Router::get('/blog',[FrontendController::class, 'news']);
Router::get('/contact-us',[FrontendController::class, 'contact']);
Router::get('/faq',[FrontendController::class, 'FaqPage']);
Router::get("/search/content",[FrontendController::class,'SearchResults']);



//BackendEnd Routes
Router::get('/admin/dashboard', [HomeController::class, 'index'])->middleware('auth');

//Site Settings
Router::get("/admin/site/settings",[SiteSettings::class, 'index'])->middleware("auth");
Router::update("/admin/site/settings/changes",[SiteSettings::class, 'update'])->middleware("auth");


//Sliders Route

Router::get("/admin/sliders", [Slider::class, 'Index'])->middleware('auth');
Router::get("/admin/add/slider", [Slider::class, 'Create'])->middleware('auth');
Router::post("/admin/slider/store", [Slider::class, 'Store'])->middleware('auth');
Router::get("/admin/slide/delete", [Slider::class, 'Delete'])->middleware('auth');
Router::get("/admin/slide/edit", [Slider::class, 'Edit'])->middleware('auth');
Router::update("/admin/slide/update", [Slider::class, 'Update'])->middleware('auth');


// Products Manager Routes

Router::get("/admin/categories", [ProductsController::class, 'Categories'])->middleware('auth');
Router::post("/admin/category/store", [ProductsController::class, 'CategoryStore'])->middleware('auth');
Router::get("/admin/categories/edit", [ProductsController::class, 'CategoryEdit'])->middleware('auth');
Router::update("/admin/category/update", [ProductsController::class, 'CategoryUpdate'])->middleware('auth');
Router::get("/admin/category/delete", [ProductsController::class, 'CategoryDelete'])->middleware('auth');

// Product Sub Categories
Router::get("/admin/subcategories", [ProductsController::class, 'SubCategories'])->middleware('auth');
Router::get("/admin/subcategories/create", [ProductsController::class, 'CategoryCreate'])->middleware('auth');
Router::post('/admin/subcategory/store', [ProductsController::class, 'SubcategoryStore'])->middleware('auth');
Router::get('/admin/subcategory/edit', [ProductsController::class, 'SubCategoryEdit'])->middleware('auth');
Router::update('/admin/subcategory/update', [ProductsController::class, 'SubCategoryUpdate'])->middleware('auth');
Router::get('/admin/subcategory/delete', [ProductsController::class, 'DeleteSubCategory'])->middleware('auth');

// Find Subcategory base on Category

Router::get("/subcategories/target",[ProductsController::class, 'FindSubCategoryByCategory'])->middleware('auth');

// Product Routes

Router::get('/admin/manager/products', [ProductsController::class, 'ProductManager'])->middleware('auth');
Router::get("/admin/products/add", [ProductsController::class, 'AddProduct'])->middleware('auth');
Router::post("/admin/product/store", [ProductsController::class, 'StoreProduct'])->middleware('auth');
Router::get("/admin/product/edit", [ProductsController::class, 'EditProduct'])->middleware('auth');
Router::update("/admin/product/update", [ProductsController::class, 'UpdateProduct'])->middleware('auth');
Router::get("/admin/product/update-trending", [ProductsController::class, 'UpdateTrending'])->middleware('auth');
Router::get("/admin/product/delete", [ProductsController::class, 'ProductDelete'])->middleware('auth');
Router::get("/admin/product/image/gallaries/delete", [ProductsController::class, 'GallaryDelete'])->middleware('auth');

// Faq Routes
Router::post('/admin/faq/create',[ProductsController::class, 'FaqCreate'])->middleware('auth');
Router::post('/admin/faq/delete',[ProductsController::class, 'DeleteFaq'])->middleware('auth');
Router::get('/admin/faq/get',[ProductsController::class, 'GetFaq'])->middleware('auth');
Router::post('/admin/product/faq/update',[ProductsController::class, 'ProductFaqUpdate'])->middleware('auth');


// News Manager Routes
Router::get('/admin/manager/news', [NewsController::class, 'NewsManager'])->middleware('auth');
Router::get('/admin/news/add', [NewsController::class, 'Create'])->middleware('auth');
Router::post("/admin/news/store",[NewsController::class, "Store"])->middleware('auth');
Router::get("/admin/news/edit", [NewsController::class, 'EditNews'])->middleware('auth');
Router::update("/admin/news/update", [NewsController::class, 'UpdateNews'])->middleware('auth');
Router::get("/admin/news/delete", [NewsController::class, 'Destroy'])->middleware('auth');
Router::get("/admin/news/update-featured", [NewsController::class, 'UpdateFeatured'])->middleware('auth');


// Pages Route For Backend

Router::get("/admin/pages/about", [PagesController::class, 'IndexAbout'])->middleware('auth');
Router::update("/admin/pages/about/store", [PagesController::class, 'StoreAbout'])->middleware('auth');
Router::get("/admin/pages/product",[PagesController::class, 'IndexProduct'])->middleware('auth');
Router::update("/admin/pages/product/store", [PagesController::class, 'StoreProduct'])->middleware('auth');
Router::get("/admin/pages/global-partners",[PagesController::class, 'IndexGlobalPartners'])->middleware('auth');
Router::update("/admin/pages/global-partners/store",[PagesController::class, 'StoreGlobalPartners'])->middleware('auth');
Router::post('/admin/pages/global-partners/region/store',[PagesController::class, 'StoreGlobalPartnersRegion'])->middleware('auth');

Router::get("/admin/pages/partners/edit", [PagesController::class, "EditPartners"])->middleware('auth');
Router::update("/admin/pages/global-partners/partners/update",[PagesController::class, "UpdatePartnersEdit"])->middleware('auth');

Router::get("/admin/pages/region/delete", [PagesController::class, 'DeleteGlobalPartnersRegion'])->middleware('auth');
Router::post("/admin/pages/global-partners/partners/store",[PagesController::class, 'StoreGlobalPartnersDetails'])->middleware('auth');
Router::get("/admin/pages/partners/delete",[PagesController::class, 'DeleteGlobalPartnersDetails'])->middleware('auth');
Router::get("/global/partners/details",[PagesController::class, 'GetPartnersDetails']);
Router::get("/admin/pages/our-projects",[PagesController::class, 'IndexOurProjects'])->middleware('auth');
Router::update("/admin/pages/our-projects/store",[PagesController::class, 'StoreOurProjects'])->middleware('auth');
Router::post("/admin/pages/our-projects/prjoect/store",[PagesController::class, 'StoreProjects'])->middleware('auth');
Router::get("/admin/pages/our-projects/project/delete",[PagesController::class, 'DeleteProjects'])->middleware('auth');
Router::get("/admin/pages/certificate",[PagesController::class, 'IndexCertificate'])->middleware('auth');
Router::update("/admin/pages/certificate/store",[PagesController::class, 'CertificateStore'])->middleware('auth');
Router::get("/admin/pages/company-profile",[PagesController::class, 'IndexCompanyProfile'])->middleware('auth');
Router::update("/admin/pages/company-profile/store",[PagesController::class, 'StoreCompanyProfile'])->middleware('auth');
Router::get("/admin/pages/news",[PagesController::class, 'IndexNews'])->middleware('auth');
Router::update("/admin/pages/news/store",[PagesController::class, 'StoreNews'])->middleware('auth');
Router::get("/admin/pages/contact-us",[PagesController::class, 'IndexContact'])->middleware('auth');
Router::update("/admin/pages/contact-us/store",[PagesController::class, 'StoreContact'])->middleware('auth');

//Frontedn Store Message for customer without auth as guest
Router::post("/admin/contact-us/store",[MessagesController::class, 'StoreMessage']);
Router::get('/admin/messages', [MessagesController::class,'Index'])->middleware('auth');
Router::get("/admin/message/delete",[MessagesController::class,'DestroyMessage'])->middleware('auth');

// File Manager
Router::get("/admin/file-manager",[FileManager::class, "Index"])->middleware('auth');
Router::post("/admin/file-manager/store",[FileManager::class, "StoreFile"])->middleware('auth');
Router::get("/admin/file-manager/files",[FileManager::class, "GetFile"])->middleware('auth');
Router::post("/admin/file-manager/delete",[FileManager::class, "DeleteFile"])->middleware('auth');



//Authentication Routes
Router::get("/session/create", [SessionController::class, 'Create'])->middleware('guest');
Router::post("/session/store", [SessionController::class, 'Store'])->middleware('guest');
Router::get("/session/destroy", [SessionController::class, 'Destroy'])->middleware('auth');


//FAQ Item Route

Router::get("/admin/faq/manage", [FaqController::class, 'Create'])->middleware('auth');
Router::post("/admin/faq/save", [FaqController::class, 'Store'])->middleware('auth');
Router::get("/admin/faq/destroy", [FaqController::class, 'Destroy'])->middleware('auth');
Router::post("/admin/faq/update", [FaqController::class, 'Update'])->middleware('auth');

//Faq Page Configuration
Router::get("/admin/pages/faq", [PagesController::class, 'IndexFaq'])->middleware('auth');
Router::update("/admin/pages/faq/store", [PagesController::class, 'StoreFaq'])->middleware('auth');


//Development Ueses

// Router::get("/hash/make", [SessionController::class, 'Hash']);










