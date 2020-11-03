<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Categoria
 * 
 * @property int $id_categoria
 * @property int $tipo
 * @property string $descricao
 * @property bool $status
 * 
 * @property Collection|Post[] $posts
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class Categoria extends Model
{
	protected $table = 'categoria';
	protected $primaryKey = 'id_categoria';
	public $timestamps = false;

	protected $casts = [
		'tipo' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'tipo',
		'descricao',
		'status'
	];

	public function posts()
	{
		return $this->hasMany(Post::class, 'categoria');
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'categoria_cod');
	}
}
