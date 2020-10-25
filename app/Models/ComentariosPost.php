<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ComentariosPost
 * 
 * @property int $id_comentario
 * @property int $id_post
 * @property string $comentario
 * @property Carbon $data_cad
 * 
 * @property Post $post
 *
 * @package App\Models
 */
class ComentariosPost extends Model
{
	protected $table = 'comentarios_post';
	protected $primaryKey = 'id_comentario';
	public $timestamps = false;

	protected $casts = [
		'id_post' => 'int'
	];

	protected $dates = [
		'data_cad'
	];

	protected $fillable = [
		'id_post',
		'comentario',
		'data_cad'
	];

	public function post()
	{
		return $this->belongsTo(Post::class, 'id_post');
	}
}
