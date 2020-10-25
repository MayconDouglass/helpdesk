<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PostTag
 * 
 * @property int $id_post
 * @property int $id_tag
 * 
 * @property Post $post
 * @property Tag $tag
 *
 * @package App\Models
 */
class PostTag extends Model
{
	protected $table = 'post_tags';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_post' => 'int',
		'id_tag' => 'int'
	];

	public function post()
	{
		return $this->belongsTo(Post::class, 'id_post');
	}

	public function tag()
	{
		return $this->belongsTo(Tag::class, 'id_tag');
	}
}
