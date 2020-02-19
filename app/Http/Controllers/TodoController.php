<?php

namespace App\Http\Controllers;

use App\Todo;
use App\Http\Requests\TodoRequest;
use App\Traits\ApiResponse;
use http\Client;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Todo::all();
    }

    public function store(TodoRequest $request)
    {


        $todo = Todo::create([
            'title' => $request->title,
        ]);

         $this->storeMetropolis($request);

        return $this->apiResponse(['message' => 'todo created successfully', 'result' => $todo], 201);
    }


    public function show($id)
    {
        $todo = Todo::whereId($id)->first();
        if ($todo)
            return $this->showOne($todo, 200);
        return $this->errorResponse('no resource found', 404);
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::whereId($id)->first();

        $this->authorize('update', $todo);

        $todo->update($request->all());
        return $this->apiResponse(['message' => 'todo updated successfully'], 201);
    }

    public function destroy($id)
    {
        return Todo::whereIn('id', explode(',', $id))->delete();
    }

    protected function storeMetropolis($request){
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'token'=>env('METROPOLIS_KEY')
            ]
        ]);

        $response=$client->post('http://127.0.0.1:8002/api/create-todo', [
            'json' => [
                'title'=>$request->title,
                'user_id'=>auth()->user()->id
            ]
        ]);

        return $response->getBody()->getContents();
    }
}
