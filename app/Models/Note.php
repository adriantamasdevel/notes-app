<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Note
 *
 * @package App
 *
 * @SWG\Definition(
 *   definition="Note",
 *   required={"title", "content"}
 * )
 *
 */
class Note extends Model {

    protected $table = 'notes';

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $dateFormat = 'd';

    protected $fillable = array('content');

    /**
     * Primary key
     *
     * @var string $id
     * @SWG\Property(type="integer")
     */
    protected $id;

    /**
     * Note content
     *
     * @var string $content
     * @SWG\Property(type="string")
     */
    protected $content;




}