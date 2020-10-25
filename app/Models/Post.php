<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * 
 * @property int $id_postagem
 * @property int $categoria
 * @property string $assunto
 * @property string $texto
 * @property string|null $imagem
 * @property int $user_cad
 * @property Carbon $data_cad
 * @property int|null $user_alt
 * @property Carbon|null $data_alt
 * @property bool $visivel
 * @property int $rating
 * @property int $comentarios
 * 
 * @property Categorium $categorium
 * @property Usuario|null $usuario
 * @property Collection|ComentariosPost[] $comentarios_posts
 * @property Collection|Tag[] $tags
 *
 * @package App\Models
 */
class Post extends Model
{
	protected $table = 'posts';
	protected $primaryKey = 'id_postagem';
	public $timestamps = false;

	protected $casts = [
		'categoria' => 'int',
		'user_cad' => 'int',
		'user_alt' => 'int',
		'visivel' => 'bool',
		'rating' => 'int',
		'comentarios' => 'int'
	];

	protected $dates = [
		'data_cad',
		'data_alt'
	];

	protected $fillable = [
		'categoria',
		'assunto',
		'texto',
		'imagem',
		'user_cad',
		'data_cad',
		'user_alt',
		'data_alt',
		'visivel',
		'rating',
		'comentarios'
	];

	public function categorium()
	{
		return $this->belongsTo(Categorium::class, 'categoria');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'user_alt');
	}

	public function comentarios_posts()
	{
		return $this->hasMany(ComentariosPost::class, 'id_post');
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class, 'post_tags', 'id_post', 'id_tag');
	}
}
