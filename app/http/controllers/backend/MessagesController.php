<?php 

namespace app\http\controllers\backend;

use core\Request;
use app\http\models\Messages;
use core\Session;
use core\Mailer;
class MessagesController {
    
   public function Index(){
        $pageNumber = $_GET['page'] ?? 1;
        $rows = ceil(count(Messages::orderBy("id","DESC")->get())/10) ;

        $messages = Messages::paginate(10, $pageNumber);

        return view('backend/messages/index',compact('messages','rows'));
   }
   
    public function StoreMessage(Request $req){
      
        $req->validate([
            'email' => 'required',
            'name' => 'required',
            'message' => 'required',
        ],[
            'email.required'    => 'Email is required !!',
            'name.required'    => 'Name is required !!',
            'message.required'    => 'Message Body is required !!',
        ]);

        $attributes = [];

        if($req->request('email')) $attributes['email'] =$req->request('email');
        if($req->request('name')) $attributes['name'] = $req->request('name');
        if($req->request('message')) $attributes['message']= $req->request('message');
        //if we chaining insert it will return the state if upload or not;
        Messages::create($attributes);


  $mail_to_send_to = "sales@hayashimulift-jp.com";
$subject = "You have been requested for information from " . $req->request('name');
$messages = $req->request('message');

$from_email = "notification@hayashimulift-jp.com";
$sendflag = 'send';
$name = $req->request('name');

if ($sendflag == "send") {
    $subject = "Message subject";
    $email = $req->request('name');
    $message = "\r\n" . "Name: $name" . "\r\n"; // Get recipient name in contact form
    $message = $message . $messages . "\r\n"; // Add message from the contact form to the existing message (name of the client)

    // Email headers
    $headers = "From: $from_email" . "\r\n" . "Reply-To: $from_email" . "\r\n";
    
    // Email Body (HTML Template)
    $body = "
    <html>
        <head>
            <title>{$subject}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f9;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    width: 80%;
                    margin: 20px auto;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                .header {
                    background-color: #4CAF50;
                    color: white;
                    padding: 15px;
                    text-align: center;
                    border-radius: 8px 8px 0 0;
                }
                .content {
                    padding: 20px;
                }
                .content p {
                    line-height: 1.6;
                    font-size: 16px;
                    margin: 10px 0;
                }
                .footer {
                    background-color: #f1f1f1;
                    padding: 15px;
                    text-align: center;
                    font-size: 14px;
                    border-radius: 0 0 8px 8px;
                    color: #777;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Message from {$name}</h2>
                </div>
                <div class='content'>
                    <p><strong>Name:</strong> {$name}</p>
                    <p><strong>Email:</strong> {$req->request('email')}</p>
                    <p><strong>Message:</strong></p>
                    <p>{$messages}</p>
                </div>
                <div class='footer'>
                    <p>Thank you for reaching out to us!</p>
                </div>
            </div>
        </body>
    </html>";

    // Send the email with HTML content
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Send the email
   // $a = mail($mail_to_send_to, $subject, $body, $headers);
    // if ($a) {
    //     print("Message was sent, you can send another one");
    // } else {
    //     print("Message wasn't sent, please check that you have changed emails in the bottom");
    // }
}


        Session::flash('message', 'You have sent a message !! Waiting for response !!');

        return back();
    }
    
    public function DestroyMessage(){
        $id = $_GET['target'];

        $message = Messages::find($id);
        
        $message->delete();
        Session::flash('message', 'Message Has Been Deleted !!');

        return back();
    }
    
}