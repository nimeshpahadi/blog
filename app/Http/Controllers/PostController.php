<?php

namespace App\Http\Controllers;

use App\Blog\Services\PostService;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Post;
use Session;

class PostController extends Controller
{
    /**
     * @var PostService
     */
    public $post;

    /**
     * PostController constructor.
     * @param PostService $post
     */
    public function __construct(PostService $post)
    {

        $this->post = $post;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create a variable and store all the blog in it from the database
        $posts = Post::orderBy('id', 'desc')->paginate(3);

        // return a view and pass in the above variable
        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        

        $this->validate($request, array(
            'title' =>  'required|max:255',
            'body'  =>  'required'
        ));
        $data= $request->all();

        $response = $this->post->storePost($data);

        if($response)
        {
            Session::flash('success', 'The blog was successfully  save!');
            return redirect()->route('posts.show',$response->id);
        }

        return redirect()->withErrors("Something went wrong!");



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
        {
        // find the post in the database and save as a var

                $post = Post::find($id);

         // return the view and pass in the var we previously created

            return view('posts.edit')->withPost($post);


        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the data
        $this->validate($request, array(
            'title' =>  'required|max:255',
            'body'  =>  'required'
        ));

        // Save the data to the database
        $post = Post::find($id);


        $post->title =  $request->input('title');
        $post->body = $request->input('body');

        $post->save();

        // set flash data with success message
        Session::flash('success', 'This Post was successfully saved');

        // redirect with flash data to posts.show
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        $post->delete();

        Session::flash('success', 'The Post was successfully deleted');

        return redirect()->route('posts.index');
    }   
}
