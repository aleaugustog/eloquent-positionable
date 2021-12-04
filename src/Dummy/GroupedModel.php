<?php

namespace Thytanium\EloquentPositionable\Dummy;

use Illuminate\Database\Eloquent\Model;
use Thytanium\EloquentPositionable\Positionable;

class GroupedModel extends Model
{
    use Positionable;

    protected $table = 'grouped_positionables';
    public $fillable = ['type', 'position'];

    protected $positionable = [
        'groups' => ['type'],
    ];
}
