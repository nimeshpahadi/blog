<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class PagesController extends Controller {

	public function getIndex() {
      
      $post = Post::orderBy('created_at', 'desc')->limit(4)->get();
      return view('pages/welcome')->withPosts($post);

	}

	public function getAbout() {
      
      $first = 'Nimesh';
      $last = 'Pahadi';

      $fullname = $first . " " . $last;
      $email = 'nimesh4477@gmail.com';

      $data = [];
      $data['email'] = $email;
      $data['fullname'] = $fullname; 
      return view('pages.about')->withData($data);
	}

	public function getContact() {
      
      return view('pages/contact');
	}

	public function postContact(Request $request) {
	    $this->validate($request, [
	        'email'   => 'required|email',
            'subject' => 'min:3',
            'message' => 'min:10']);

        $data = array(
          'email' => $request->email,
          'subject'=> $request->subject,
          'bodyMessage' => $request->message
        );

        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->from($data['email']);
            $message->to('hello@nimesh.io');
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Your Email was Sent');

        return redirect('/');
    }

}