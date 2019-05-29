<?php

namespace App\Http\Controllers\admin;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $pageId = 3;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=NULL)
    {
        if($id){
            $uid =  $id;
            $posts = Post::with('member')->where('user_id', $uid)->latest()->get();
        }
        else{
            $posts = Post::with('member')->latest()->get();
        }
        // ================= without where caluse =============/
        //$posts = Post::with('member')->latest()->get();

        // =================== with where clause
        // $posts = Post::with(['member' => function ($query) {
        //     $query->where('user_id', $id);
        // }])->latest()->get();
      
        
        //return $posts;
        $data['pageId'] = $this->pageId;
        $data['posts'] = $posts;
        return view('admin.posts',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageId'] = $this->pageId;
        return view('admin.posts-add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:191',
            'content' => 'required',
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::id();
        $post->save();

        return redirect('/admin/posts')->with("success" , "Post Created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pageId'] = $this->pageId;
        $postinfo = Post::find($id);
        $data['postInfo'] = $postinfo;
        //return $postinfo;
        return view('admin.posts-view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['pageId'] = $this->pageId;
        $data['postInfo'] = Post::find($id);
        //return $data['userInfo'];
        return view('admin.posts-edit',$data);
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
        $validatedData = $request->validate([
            'title' => 'required|max:191',
            'content' => 'required',
        ]);

        $post = Post::find($id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        return redirect('/admin/posts')->with("success" , "Post Updated");
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
        return redirect('/admin/posts')->with("success" , "Post Deleted");
    }
}
