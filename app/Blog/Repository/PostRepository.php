<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/25/16
 * Time: 5:32 PM
 */

namespace App\Blog\Repository;


use App\Post;

class PostRepository
{
    /**
     * @var Post
     */
    public $post;

    /**
     * PostRepository constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {

        $this->post = $post;
    }

    public function storePost($formdata)
    {
        return $this->post->create($formdata);
    }


}