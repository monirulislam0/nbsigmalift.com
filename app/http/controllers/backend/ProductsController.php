<?php 

namespace app\http\controllers\backend;

use app\http\models\Categories;
use app\http\requests\CategoryRequest;
use app\http\requests\ProductRequest;
use app\http\models\SubCategories;
use app\http\models\Products;
use app\http\models\Faq;
use app\http\requests\SubCategoryRequest;
use core\Session;

class ProductsController{


    // For Categories 

    public function Categories(){
        $categories = Categories::all()->get();
        return view("backend/products/categories", compact('categories'));
    }

    public function CategoryStore(CategoryRequest $req){
        
        $attributes = [];
        if($req->request('category_name'))  $attributes['category_name'] = $req->request('category_name');

        if($file = $req->file('category_image')){

            $name = hexdec(uniqid()).".".$file->getClientOriginalExtension();

            $isUploaded = $file->save(public_path("/uploads"), $name);

            if($isUploaded) $attributes['category_image'] = $name;

        }

        Categories::create($attributes);

        Session::flash('message', 'Categore has been saved');

        return back();

    }

    public function CategoryEdit(){

        $id = $_GET['target'];
        $category = Categories::find($id)->get();
        $categories = Categories::all()->get();
        return view("backend/products/categories", compact('categories','category'));
    }

    public function CategoryUpdate(CategoryRequest $req){
 
        $find = Categories::find($req->request('id'));

        $data = $find->get();

        $attributes = [];

        if($req->request('category_name'))  $attributes['category_name'] = $req->request('category_name');

        if($req->has_file('category_image')){

            $file = $req->file('category_image');

            $name = hexdec(uniqid()).".".$file->getClientOriginalExtension();

            $isUploaded = $file->save(public_path("/uploads"), $name);

            if($isUploaded) $attributes['category_image'] = $name;

            if(! empty($data['category_image']) ) unlink(public_path("/uploads/").$data['category_image']);

        }


        $find->update($attributes);

        Session::flash('message', 'Categore has been updated');

        return back();
    }

    public function CategoryDelete(){
        $id = $_GET['target'];
        $find = Categories::find($id);
        $data = $find->get();

        if( !empty($data['category_image']) ) unlink(public_path("/uploads/".$data['category_image']));

       $find->delete();

       Session::flash('delete_message', 'Category has been deleted');

       return back();
    }


    // SubCategories

    public function SubCategories(){

        $categories = Categories::all()->get();
        $subcategories = Subcategories::all()->get();

        return view("backend/products/sub-categories", compact('categories','subcategories'));

    }

    public function CategoryCreate(){

        $this->SubCategories();

    }

    public function SubcategoryStore(SubCategoryRequest $req){
        $attributes = [];
        if($req->request('subcategory_name'))  $attributes['subcategory_name'] = $req->request('subcategory_name');
        $attributes['category_id'] = $req->request('category_id');
        if($file = $req->file('subcategory_image')){

            $name = hexdec(uniqid()).".".$file->getClientOriginalExtension();

            $isUploaded = $file->save(public_path("/uploads"), $name);

            if($isUploaded) $attributes['subcategory_image'] = $name;

        }

        SubCategories::create($attributes);

        Session::flash('message', 'Subcategory has been saved');

        return back();
    }

    public function SubCategoryEdit(){
        $id = $_GET['target'];
        $subcategory = SubCategories::find($id)->get();
        $categories = Categories::all()->get();
        $subcategories = Subcategories::all()->get();

        return view("backend/products/sub-categories", compact('categories','subcategories','subcategory'));
    }

    public function SubCategoryUpdate(SubCategoryRequest $req){

        $find = SubCategories::find($req->request('id'));

        $data = $find->get();

        $attributes = [];

        if($req->request('subcategory_name'))  $attributes['subcategory_name'] = $req->request('subcategory_name');
        if($req->request('category_id'))  $attributes['category_id'] = $req->request('category_id');

        if($req->has_file('subcategory_image')){

            $file = $req->file('subcategory_image');

            $name = hexdec(uniqid()).".".$file->getClientOriginalExtension();

            $isUploaded = $file->save(public_path("/uploads"), $name);

            if($isUploaded) $attributes['subcategory_image'] = $name;

            if(! empty($data['subcategory_image']) ) unlink(public_path("/uploads/").$data['subcategory_image']);

        }


        $find->update($attributes);

        Session::flash('message', 'Sub Category has been updated');

        return back();
    }

    public function DeleteSubCategory (){
        $id = $_GET['target'];
        $find = SubCategories::find($id);
        $data = $find->get();

        if( !empty($data['subcategory_image']) ) unlink(public_path("/uploads/".$data['subcategory_image']));

       $find->delete();

       Session::flash('delete_message', 'SubCategory has been deleted');

       return back();
    }

//FindSubCategoryByCategory

    public function FindSubCategoryByCategory(){

        $id = $_GET['id'];

        $data = SubCategories::where($id , "category_id")->get();

        $data = json_encode($data);

        echo $data;

    }

// All Products
 public function ProductManager() {
    $products = Products::orderBy('id', 'DESC')->get();
    return view("backend/products/products", compact('products'));
 }

 // Add new Product
 public function AddProduct(){
    $categories = Categories::all()->get();
    return view("backend/products/add", compact('categories'));

 }
 public function StoreProduct(ProductRequest $req){

    $attributes = [];

    if($req->request("productName")) $attributes["product_title"] = trim($req->request("productName"));
    if($req->request("productModel")) $attributes["product_model"] = trim($req->request("productModel"));
    if($req->request("productCategory")) $attributes["product_category"] = trim($req->request("productCategory"));
    if($req->request("productSubCategory")) $attributes["product_subcategory"] = trim($req->request("productSubCategory"));
    if($req->request("productPrice")) $attributes["price"] = trim($req->request("productPrice"));
    if($req->request("productShortDescription")) $attributes["short_description"] = trim($req->request("productShortDescription"));
    if($req->request("productLongDescription")) $attributes["long_description"] = trim($req->request("productLongDescription"));
    if($req->request("productThumbnailAltText")) $attributes["product_thumbnail_alt_text"] = trim($req->request("productThumbnailAltText"));
    if($req->request("productTags")) $attributes["meta_tags"] = trim($req->request("productTags"));
    if($req->request("OgTitle")) $attributes["og_title"] = trim($req->request("OgTitle"));
    if($req->request("OgDesription")) $attributes["og_description"] = trim($req->request("OgDesription"));
    
  if($req->request("meta_description")) $attributes["meta_description"] = trim($req->request("meta_description"));
  
    if($req->request("meta_title")) $attributes["meta_title"] = trim($req->request("meta_title"));

    if($req->has_file("productThumbnail")){
        $file = $req->file("productThumbnail");
        $name = hexdec(uniqid())."-".$file->getClientOriginalName();
        $name = strtolower(str_replace(' ','-', $name));
        $file->save(public_path("/uploads"), $name);
        $attributes['product_thumbnail'] = $name;
    }
    if($req->has_file("OgImage")){
        $file = $req->file("OgImage");
        $name = hexdec(uniqid())."-".$file->getClientOriginalName();
        $name = strtolower(str_replace(' ','-', $name));
        $file->save(public_path("/uploads"), $name);
        $attributes['og_image'] = $name;
    }
    if($req->has_file("productPDF")){
        $file = $req->file("productPDF");
        $name = hexdec(uniqid())."-".$file->getClientOriginalName();
        $name = strtolower(str_replace(' ','-', $name));
        $file->save(public_path("/uploads"), $name);
        $attributes['product_pdf'] = $name;
    }

    if($data = $req->has_file("productGallaries")){

        $names = [];

        $file = $req->file("productGallaries");

        $files = $file->get_file();

        $tmp = $files['tmp_name'];

        $name = $files['name'];

        foreach($name as $key => $value){

            $new_name = hexdec(uniqid())."-".$name[$key];

            $new_name = strtolower(str_replace(' ', '-', $new_name));

            $path = public_path("/uploads/".$new_name);

            move_uploaded_file($tmp[$key], $path);

            $names[] = $new_name;

        }
        $attributes['product_galleries'] = serialize($names);

    }



    Products::create($attributes);

    Session::flash('message', 'Product has been posted !! Let\'s create another one !!');

    return redirect("/admin/products/add");

 }

public function EditProduct(){
    $id = $_GET["target"];

    $product = Products::find($id)->get();

    $categories = Categories::all()->get();
    $subcategories = [];

    if($product['product_category']){
        $subcategories = SubCategories::where($product['product_category'],'category_id')->get();
    }

    return view("backend/products/edit", compact('product', 'categories','subcategories'));

}
// Update Product


public function UpdateProduct(ProductRequest $req){

    $find = Products::find($req->request('id'));
    $product = $find->get();
    $attributes = [];

    if($req->request("productName")) $attributes["product_title"] = trim($req->request("productName"));
    if($req->request("productModel")) $attributes["product_model"] = trim($req->request("productModel"));
    if($req->request("productCategory")) $attributes["product_category"] = trim($req->request("productCategory"));
    if($req->request("productSubCategory")) $attributes["product_subcategory"] = trim($req->request("productSubCategory"));
    if($req->request("productPrice")) $attributes["price"] = trim($req->request("productPrice"));
    if($req->request("productShortDescription")) $attributes["short_description"] = trim($req->request("productShortDescription"));
    if($req->request("productLongDescription")) $attributes["long_description"] = trim($req->request("productLongDescription"));
    if($req->request("productThumbnailAltText")) $attributes["product_thumbnail_alt_text"] = trim($req->request("productThumbnailAltText"));
    if($req->request("productTags")) $attributes["meta_tags"] = trim($req->request("productTags"));
    if($req->request("OgTitle")) $attributes["og_title"] = trim($req->request("OgTitle"));
    if($req->request("OgDesription")) $attributes["og_description"] = trim($req->request("OgDesription"));
    
  if($req->request("meta_description")) $attributes["meta_description"] = trim($req->request("meta_description"));
  
    if($req->request("meta_title")) $attributes["meta_title"] = trim($req->request("meta_title"));
    
    if($req->has_file("productThumbnail")){

        if($product['product_thumbnail']) unlink(public_path("/uploads/".$product['product_thumbnail']));

        $file = $req->file("productThumbnail");
        $name = hexdec(uniqid())."-".$file->getClientOriginalName();
        $name = strtolower(str_replace(' ','-', $name));
        $file->save(public_path("/uploads"), $name);
        $attributes['product_thumbnail'] = $name;

    }
    if($req->has_file("OgImage")){
        if($product['og_image']) unlink(public_path("/uploads/".$product['og_image']));
        $file = $req->file("OgImage");
        $name = hexdec(uniqid())."-".$file->getClientOriginalName();
        $name = strtolower(str_replace(' ','-', $name));
        $file->save(public_path("/uploads"), $name);
        $attributes['og_image'] = $name;
    }
    if($req->has_file("productPDF")){
        if($product['product_pdf']) unlink(public_path("/uploads/".$product['product_pdf']));
        $file = $req->file("productPDF");
        $name = hexdec(uniqid())."-".$file->getClientOriginalName();
        $name = strtolower(str_replace(' ','-', $name));
        $file->save(public_path("/uploads"), $name);
        $attributes['product_pdf'] = $name;
    }

    if($data = $req->has_file("productGallaries")){

        $names =  unserialize($product['product_galleries']);

        $file = $req->file("productGallaries");

        $files = $file->get_file();

        $tmp = $files['tmp_name'];

        $name = $files['name'];

        foreach($name as $key => $value){

            $new_name = hexdec(uniqid())."-".$name[$key];

            $new_name = strtolower(str_replace(' ', '-', $new_name));

            $path = public_path("/uploads/".$new_name);

            move_uploaded_file($tmp[$key], $path);

            $names[] = $new_name;

        }
        $attributes['product_galleries'] = serialize($names);

    }



    $find->update($attributes);

    Session::flash('message', 'Product has been udpated!!');

    return redirect("/admin/product/edit?target=".$req->request('id'));

 }
//  UpdateTrendingProduct
public function UpdateTrending(){
    
        $id = $_GET['target'];
        $status = $_GET['status'];
        
        $find = Products::find($id);
    
        $find->update(['trending' => $status]);
    
        $response = [
            'status' => true,
            'message' => 'Product has been updated !!',
        ];
        $response = json_encode($response);
        echo $response;
        http_response_code("200");
        exit();
}
 // Delete Product

 public function ProductDelete(){

    $id = $_GET['target'];

    $find = Products::find($id);

    $product = $find->get();

    if($product['product_thumbnail']) unlink(public_path("uploads/".$product['product_thumbnail']));

    if($product['product_pdf']) unlink(public_path("uploads/".$product['product_pdf']));

    $gallaries = unserialize($product['product_galleries']);

    foreach($gallaries as $gal){
        unlink(public_path("uploads/$gal"));
    }

    $find->delete();

    Session::flash("message", 'Product has been deleted !! Take another action ');

    return redirect("/admin/manager/products");

 }
//View Single Products base on the id 

public function SingleProducts($slug){

    preg_match('/[^-]+$/', $slug, $matches);

    $id = $matches[0];
    $categoreis = Categories::all()->get();
    $product = Products::find($id)->get();
    $related_products = Products::where($product['product_category'],'product_category')->get();
    // Og Description
    if( empty($product['og_description'])){
        $og_description = $product['short_description'];
    }else{
        $og_description = $product['og_description'];
    }
    
    //Og Title 
    if( !empty($product['meta_title'])){
        $page_title = $product['meta_title'];
    }elseif(!empty($product['og_title'])){
        $page_title = $product['og_title'];
    }else{
        $page_title = $product['product_title'];
    }
    
    if(! $product['og_image']){
        $og_image = $product['product_thumbnail'];
    }else{
        $og_image = $product['og_image'];
    }
    
    
    $page = [
            'og_description' => $og_description,
            'page_title'     => $page_title,
            'og_title'     => $product['og_title'],
            'meta_tags'     => $product['meta_tags'],
            'og_image'      => $og_image,
            'meta_description' => $product['meta_description'],
            'meta_tags'  => $product['meta_tags'],
        ];
    return view("frontend/single_product",compact('product','categoreis','related_products','page'));
    
}
 
public function ProductsByCategory($slug){
    preg_match('/[^-]+$/', $slug, $matches);

    $id = $matches[0];
    $searched = Categories::find($id)->get();
    // $categoreis = SubCategories::where($id, 'category_id');
    $products = Products::where($id, 'product_category')->get();

    return view("frontend/product_by_category",compact('products','searched'));
}

public function ProductBySubCategories($slug){

    preg_match('/[^-]+$/', $slug, $matches);

    $id = $matches[0];
    $searched = SubCategories::find($id)->get();
    // $categoreis = SubCategories::where($id, 'category_id');
    $products = Products::where($id, 'product_subcategory')->get();

    return view("frontend/product_by_category",compact('products','searched'));
}

    public function GallaryDelete() {

        $id = $_GET['target'];
        $index = $_GET['index'];

        // Find the product
        $find = Products::find($id);
        $product = $find->get();

        // Unserialize the galleries
        $galleries = unserialize($product['product_galleries']);

        // Check if the index exists before unsetting
        if (isset($galleries[$index])) {
            unset($galleries[$index]);
            $galleries = array_values($galleries); // Reindex the array
        }

        // Update the product with the new galleries array
        $find->update([
            'product_galleries' => serialize($galleries)
        ]);

        // Redirect or return a response
        $response = [
            'status' => true,
            'message' => 'Image has been removed ',
        ];
        $response = json_encode($response);
        echo $response; 
        http_response_code("200");
        exit();
    }           


    // Faq Methods
    
    public function FaqCreate(){
        $input = json_decode(file_get_contents('php://input'), true);
         $question = trim($input['question'] ?? '');
        $answer = trim($input['answer'] ?? '');
        $id = $input['id'];

        if (empty($question) || empty($answer)) {
            echo json_encode(['success' => false, 'message' => 'Fields are required']);
            return;
        }
        $insert = Faq::create([
                'product_id' => $id,
                'question' => $question,
                'answer' => $answer,
            ]);
            
        $faq_id = $insert->getInsertId();
        echo json_encode(['success'=> '200','question'=> $question , 'answer' =>$answer, 'id' => $id, 'faq_id' =>  $faq_id] );
    }


    public function GetFaq(){
           $id = isset($_GET['target']) ? (int)$_GET['target'] : 0;
        if ($id <= 0) {
            echo json_encode(['error' => 'Invalid ID']);
            return;
        }
    
        // Fetch from DB
        $faq = Faq::find($id)->get();
    
        if (!$faq) {
            echo json_encode(['error' => 'FAQ not found']);
            return;
        }
    
        // Return as JSON
        echo json_encode($faq);
    }
    public function ProductFaqUpdate(){
          $data = json_decode(file_get_contents("php://input"), true);
        
        // Check if required fields exist
        if (!isset($data['id']) || !isset($data['title']) || !isset($data['content'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Missing required fields"]);
            exit;
        }
       
        // Sanitize input (basic example)
        $id = (int)$data['id'];
        $title = htmlspecialchars(strip_tags($data['title']));
        $content = htmlspecialchars(strip_tags($data['content']));
        
        $old = Faq::find($id);
        $old->update([
                 'question' => $title,
                 'answer' => $content,
            ]);
        // Respond with success
        echo json_encode(Faq::find($id)->get());
    }
    
    
public function DeleteFaq(){
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'];
    $find = Faq::find($id)->delete();
    if($find){
         echo json_encode(['success'=> '200'] );
    }
    
}





}