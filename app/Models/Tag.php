<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * 
 * @property int $id_tag
 * @property string $descricao
 * @property bool $status
 * 
 * @property Collection|Post[] $posts
 *
 * @package App\Models
 */
class Tag extends Model
{
	protected $table = 'tags';
	protected $primaryKey = 'id_tag';
	public $timestamps = false;

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'descricao',
		'status'
	];

	public function posts()
	{
		return $this->belongsToMany(Post::class, 'post_tags', 'id_tag', 'id_post');
	}
}
