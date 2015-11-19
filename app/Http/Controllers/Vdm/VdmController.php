<?php

namespace App\Http\Controllers\Vdm;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Http\Controllers\Vdm\ApiController;
use App\Transformers\PostTransformer;
use App\Repositories\PostRepository;

use Underscore\Types\Arrays;
use Vdm\Scraper;

class VdmController extends ApiController
{
    /**
     * The Post transformer
     *
     * @var PostTransformer
     */   
    protected $postTransformer;

    /**
     * The Post repository
     *
     * @var PostRepository
     */
    protected $postRepository;

    function __construct(PostTransformer $postTransformer, PostRepository $postRepository)
    {
        $this->postTransformer = $postTransformer;
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = $this->postRepository->filter($request->all());

        return $this->respondWithCount($posts, ['posts' => $this->postTransformer->transformCollection($posts->all())]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->postRepository->find($id);

        if(!$post){ return $this->respondNotFound();}

        return $this->respond(['post' => $this->postTransformer->transform($post)]);
    }
}
