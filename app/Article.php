<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
		'title',
		'body',
		'published_at',
		'user_id'
	];

	//Permits the use of published_at to bes used as a data in its own right.
	protected $dates = ['published_at'];

	public function user() {
		return $this->belongsTo('\App\User', 'user_id');
	}

	public function tags() {
		return $this->belongsToMany('\App\Tag');
	}

	public function getTagListAttribute() {
		return $this->tags->lists('id');
	}


	public function setPublishedAtAttribute($date) {
		$this->attributes['published_at'] = Carbon::parse($date);
	}

	public function scopePublished($query) {
		$query->where('published_at', '<=', Carbon::now());
	}

	public function scopeUnPublished($query) {
		$query->where('published_at', '>', Carbon::now());
	}

}
