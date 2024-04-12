<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    /**
     * Valida os dados do post
     *
     * @param Request $request
     * @return object
     */
    private function validation($request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'summary' => 'required|max:300',
            'content' => 'required|max:10000',
            'category_id' => 'required|exists:post_categories,id',
        ]);

        return $validator;
    }

    /**
     * Salva os dados do post
     *
     * @param Request $request
     * @param Post $post
     * @return void
     */
    private function save(Request $request, Post $post) {
        $post->title = $request->title;
        $post->summary = $request->summary;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->author_id = $request->user()->id;

        $post->save();
    }

    /**
     * Obter os posts
     *
     * @param Request $request
     * @param boolean $own
     * @return void
     */
    private function getPosts(Request $request, $own = false) {
        $limit = $request->display_qty ?? 6;

        $orderColumns = ['id', 'title', 'category_id', 'created_at'];
        $orderBy = checkOrderBy($orderColumns, $request->sort_by, 'id');
        $order = $request->descending == 'false' ? 'asc' : 'desc';

        return Post::search($request, $own)->orderBy($orderBy, $order)->paginate($limit);
    }

    /**
     * Obter todos os posts
     *
     * @return void
     */
    public function listPosts(Request $request) {
        return $this->getPosts($request);
    }

    /**
     * Obter todos os posts do usuário logado
     *
     * @return void
     */
    public function ownPosts(Request $request) {
        return $this->getPosts($request, true);
    }

    /**
     * Obter um post específico
     *
     * @param [type] $id
     * @return void
     */
    public function getPost($id) {
        $post = Post::where('posts.id', $id)
        ->join('users as u', 'posts.author_id', '=', 'u.id')
        ->join('post_categories as c', 'posts.category_id', '=', 'c.id')
        ->select('posts.*', 'u.name as author', 'c.name as category', 'c.slug as category_slug')
        ->first();

        $post->makeHidden(['created_at', 'updated_at']);
        $post->date = $post->created_at->format('d/m/Y');

        return $post;
    }

    /**
     * Obter todas as categorias
     *
     * @return void
     */
    public function getCategories() {
        return PostCategory::select('id', 'name')->get();
    }

    /**
     * Obter um post para edição
     *
     * @param [type] $id
     * @return void
     */
    public function edit($id) {
        $post = Post::where('id', $id)->select('id', 'title', 'summary', 'content', 'category_id', 'author_id')->first();

        if (!$post) {
            return Response('Post não encontrado', 404);
        }

        if ($post->author_id != Auth::id()) {
            return Response('Você não tem permissão para editar este post', 403);
        }

        return $post;
    }

    /**
     * Cria o post
     *
     * @param Request $request
     * @return void
     */
    public function insert(Request $request) {

        $validator = $this->validation($request);

        if ($validator->fails()) {
            return Response()->json($validator->errors(), 400);
        }

        try {

            $post = new Post();

            $this->save($request, $post);

            // return Response()->json(['message' => 'Post criado com sucesso'], 201);
            return Response('Post criado com sucesso', 201);

        } catch (\Exception $e) {
            Log::error('[POST][INSERT] Falha ao inserir um novo post, erro: '.$e->getMessage());
            return Response('Falha ao cadastrar o post. Tente novamente mais tarde.', 500);
        }

    }

    /**
     * Atualiza o post
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id) {
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return Response()->json($validator->errors(), 400);
        }

        try {

            $post = Post::find($id);

            if (!$post) {
                return Response('Post não encontrado', 404);
            }

            $this->save($request, $post);

            return Response('Post atualizado com sucesso', 200);

        } catch (\Exception $e) {
            Log::error('[POST][UPDATE] Falha ao atualizar o post, erro: '.$e->getMessage());
            return Response('Falha ao atualizar o post. Tente novamente mais tarde.', 500);
        }
    }

    /**
     * Deleta o post
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id) {
        try {

            $post = Post::find($id);

            if (!$post) {
                return Response('Post não encontrado', 404);
            }

            if ($post->author_id != Auth::id()) {
                return Response('Você não tem permissão para excluir este post', 403);
            }

            $post->delete();

            return Response('Post excluído com sucesso', 200);

        } catch (\Exception $e) {
            Log::error('[POST][DELETE] Falha ao excluir o post, erro: '.$e->getMessage());
            return Response('Falha ao excluir o post. Tente novamente mais tarde.', 500);
        }
    }
}
