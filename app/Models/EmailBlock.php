<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailBlock extends Model
{
    protected $table = 'email_blocks';

    protected $fillable = [
        'sectionid',   // referencia a email_sections.id
        'blockid',     // referencia al tipo de bloque (blocks.id)
        'col',         // número de columna (1, 2, 3, 4)
        'order',        // posición dentro de la columna
        'properties'
    ];

    public function emailSection()
    {
        return $this->belongsTo(EmailSection::class, 'sectionid');
    }

    public function block()
    {
        return $this->belongsTo(Block::class, 'blockid');
    }
}

