<?php 

namespace app\http\controllers\backend;
use core\Request;
use app\http\models\FaqPage;



class FaqController 
{
 
 public function Create(){
      $items = FaqPage::all()->get();
     return view('backend/faq/index',compact('items'));
 }
 public function Store(){
     
     $question = $_POST['question'];
     $answer = $_POST['answer'];
     
     $question = trim($question);
    $answer = trim($answer);
    
    if ($question === '' || $answer === '') {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Both question and answer are required.']);
        exit;
    }

     $fields = [
        'faq_question' => $question,
        'answer' => $answer,
     ];
     
    
    $insertation =  FaqPage::create($fields);
    $id = $insertation->getInsertId();
    $fields['id'] = $id;
    header('Content-Type: application/json');
    echo json_encode(['success'=> 200, 'faq' => $fields]);
 }
 
    public function Destroy(){
        $id = $_GET['target'];
       if (!filter_var($id, FILTER_VALIDATE_INT)) {
            echo json_encode(['error' => 'Invalid ID']);
            exit;
        }
         $find = FaqPage::find($id)->delete();
        echo json_encode(['success' => '200']);
        
    }
     public function Update(){
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
        
        $old = FaqPage::find($id);
        $old->update([
                 'faq_question' => $title,
                 'answer' => $content,
            ]);
        // Respond with success
        echo json_encode(FaqPage::find($id)->get());

    }
    
    
}