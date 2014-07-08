<?php
class Feeling extends Eloquent {
	protected $fillable = array('name', 'description', 'order', 'icon');
	public $timestamps = false;
	
	public function sentis(){
		return $this->belongsToMany('Sentis', 'sentis_feelings','feeling_id', 'sentis_id')
            ->withPivot('value');
	}

	public function posts() {
		$postsByFeeling = 
        DB::select(
            DB::raw('SELECT s.post_id id
                     FROM sentis_feelings sf, sentis s, posts p
                     WHERE sf.sentis_id = s.id
                     AND p.id = s.post_id
                     AND p.status = 1
                     AND sf.feeling_id =' .$this->id 
                     .' group by s.post_id')
        );
        
        $postIds = [];
        foreach ($postsByFeeling as $post) {
            array_push($postIds, $post->id);    
        }
        
        $posts = Post::find($postIds);

        return $posts;
	}
}
