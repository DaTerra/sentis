<?php
class Tag extends Eloquent {
	protected $fillable = array('name', 'description');
	
 	/**
     * Set timestamps off
     */
    public $timestamps = false;
	
	public function posts()
    {
        return $this->belongsToMany('Post', 'posts_tags');
    }

    public function sentis()
    {
        return $this->belongsToMany('Sentis', 'sentis_tags');
    }

    public function postSentisTagsCount(){
        //selects the sum of sentis_tags and posts_tags by tag id

        $postSentisTagsCount = 
        DB::select(
            DB::raw('SELECT (  IFNULL(
                               (SELECT count(*) qtd 
                               FROM sentis_tags st, sentis s, posts p
                               WHERE st.sentis_id = s.id
                               AND s.post_id = p.id
                               AND p.status = 1
                               AND   tag_id =' .$this->id
                               .' GROUP BY tag_id)
                               ,0)
                            )
                            +
                            ( IFNULL(
                              (SELECT count(*) qtd
                              FROM posts_tags pt, posts p
                              WHERE pt.post_id = p.id
                              AND   p.status = 1
                              AND   tag_id =' .$this->id
                              .' GROUP BY tag_id)
                              ,0)
                            ) AS qtd'
                    )
        );
        
        if($postSentisTagsCount[0]->qtd){
          return '(' .$postSentisTagsCount[0]->qtd .')';
        }

        return "";
    }
	
}
