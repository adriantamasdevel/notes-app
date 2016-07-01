<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\ApiController;

use App\Models\Note;
use App\Transformers\NoteTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;


/**
 * Class NotesController
 *
 * @package App\Http\Controllers\Api
 */


class NotesController extends ApiController
{

    public function welcome()
    {

        return $this->response->errorForbidden();
    }

    /**
     * Display a listing of notes.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/notes",
     *     description="Returns all notes from the system",
     *     produces={"application/json"},
     *     tags={"notes"},
     *     @SWG\Response(
     *         response=200,
     *         description="A list of notes."
     *     )
     * )
     */
    public function index()
    {

        // paginate the items
        $notes = Note::paginate(100);

        return $this->response->paginator($notes, new NoteTransformer());
    }


    /**
     * Store a newly created note in storage
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/notes",
     *     description="Store a new resource",
     *     produces={"application/json"},
     *   @SWG\Parameter(
     *     name="content",
     *     in="formData",
     *     description="The content of the note",
     *     type="string",
     *     required=true
     *   ),
     *     tags={"notes"},
     *     @SWG\Response(
     *         response=201,
     *         description="Resource Created"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $rules = array(
            'content'      => 'required'
        );

        $input = $request->all();

        $validator = Validator::make($input, $rules);

        // validate the data
        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new note.', $validator->errors());
        } else {
            // store
            $now = Carbon::now();
            $note = new Note;
            $note->content      = $request->get('content');
            $note->created_at      = $now;
            $note->updated_at      = $now;
            $note->save();

            return $this->response->created();

        }
    }


    /**
     * Display a specific note
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponsev
     *
     * @SWG\Get(
     *     path="/notes/{id}",
     *     description="Show a single note",
     *     produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The id of the note to get.",
     *     type="string",
     *     required=true
     *   ),
     *     tags={"notes"},
     *     @SWG\Response(
     *         response=200,
     *         description="Resource Created"
     *     ),
     *     @SWG\Response(
     *         response=404, description="Resource not found"
     *     )
     * )
     */
    public function show($id)
    {

        $note = Note::find($id);

        return $this->response->item($note, new NoteTransformer());
    }



    /**
     * Update the specified note in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @SWG\Put(
     *     path="/notes",
     *     description="Update a single note entry",
     *     consumes={"application/json", "application/xml"},
     *     produces={"application/json", "application/xml"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Fields that need to be updated",
     *     type="string",
     *     required=true
     *   ),
     *     tags={"notes"},
     *     @SWG\Response(
     *         response=200,
     *         description="Resource Created"
     *     ),
     *     @SWG\Response(
     *         response=404, description="Resource not found"
     *     )
     * )
     */
    public function update(Request $request)
    {
        $input = (array) json_decode($request->getContent());

        $id = $input['id'];




        // find the requested resource
        try {
            $note = Note::findOrFail($id);
        }catch (ModelNotFoundException $e) {
            throw new DeleteResourceFailedException('Resource not found');
        }


        // update the note with the passed data and update the updated_at field
        $now = Carbon::now();
        $note->fill($input);
        $note->updated_at = $now;

        $note->save();

        // retrieve the saved note from DB
        $note = Note::find($id);

        return $this->response->item($note, new NoteTransformer());
    }

    /**
     * Remove the specified note from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Delete(
     *     path="/notes/{id}",
     *     description="Remove a note",
     *     produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The id of the note to delete.",
     *     type="string",
     *     required=true
     *   ),
     *     tags={"notes"},
     *     @SWG\Response(
     *         response=200,
     *         description="Resource Deleted"
     *     ),
     *     @SWG\Response(
     *         response=422, description="Resource not found"
     *     )
     * )
     */
    public function destroy($id)
    {

        // find the requested resource
        try {
            $note = Note::findOrFail($id);
        }catch (ModelNotFoundException $e) {
            throw new DeleteResourceFailedException('Resource not found');
        }

        $note->delete();

    }
}
