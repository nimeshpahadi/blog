<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/25/16
 * Time: 5:25 PM
 */

namespace App\Blog\Services;


use App\Blog\Repository\PostRepository;

class PostService
{
    /**
     * @var PostRepository
     */
    public $post;


    /**
     * PostService constructor.
     * @param PostRepository $post
     */
    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    public function storePost($data)
    {
        $formdata = [
            'title'=>$data['title'],
            'body'=>$data['body']
        ];

        try{
            return $this->post->storePost($formdata);

        }
        catch (Exception $e)
        {
            return false;
        }

    }
}