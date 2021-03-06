<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\blog_post;
use App\blog_post_comments;


class BlogPostController extends Controller
{
    public function shows($page){
        
        $post = blog_post::show($page);
        $countpost = blog_post::getpostnumber();

        $getpage = $page+1;
        $backpage = $page-1;
        if ($backpage < 1) {
           $backpage = 0;
        }
       
       
        $total = count($countpost) / 5;
       
        if ($total > 0) {
           $totalpage = ceil($total) - 1;
        }
       
        if (ceil($total) == $getpage) {
            $getpage = $totalpage;
        }

        return view('blog/index',compact('post','backpage','totalpage','getpage')); 
    } 

 

    public function store(){
        $post  = new blog_post;
        

        $post->title = request('blog_title_txt');
        $post->descriptions = request('blog_description_txt');
        $post->contents = request('blog_content_txt');
        $post->created_by = '1';
        $post->created_at = date("Y-m-d H:i:s");
        $post->updated_at = date("Y-m-d H:i:s");

        $post->save();



        $getid = $post->id;
        $cat = request('categories');
        $getcat = count(request('categories'));

        for ($a = 0; $a < $getcat; $a++){
            DB::table('blog_post_categories')->insert(
                [
                'blog_post_id' => $getid, 
                'category_id' => $cat[$a], 
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                ]
            );
        }

        return redirect('post/0');
    }

}
