<?php

namespace App\Transformers;


use League\Fractal\TransformerAbstract;

use App\Models\Note;
class NoteTransformer extends TransformerAbstract {

    public function transform(Note $note)
    {
        return [
            'id'     => (int) $note->id,
            'content' => $note->content,
            'created_at' =>  $note->created_at,
            'updated_at'  =>  $note->updated_at
        ];
    }
}