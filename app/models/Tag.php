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

    public function postsByTag(){
      //get the posts with tags on posts_tags and sentis_tags
      $postsWithPostSentisTags = 
        DB::select(
            DB::raw('SELECT p.id
                     FROM   posts p, posts_tags pt
                     WHERE  p.id = pt.post_id 
                     AND    p.status = 1
                     AND    pt.tag_id =' .$this->id

                     .' UNION

                     SELECT s.post_id
                     FROM   posts p, sentis_tags st, sentis s
                     WHERE  st.sentis_id = s.id
                     AND    p.id = s.post_id
                     AND    p.status = 1
                     AND    st.tag_id =' .$this->id)
        );
        
        $postIds = [];
        foreach ($postsWithPostSentisTags as $post) {
            array_push($postIds, $post->id);    
        }
        
        $posts = Post::find($postIds);

        return $posts;
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
