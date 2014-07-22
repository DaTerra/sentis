<?php
use Illuminate\Database\Eloquent\Collection;
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
  
  public function topics()
  {
      return $this->belongsToMany('Topic', 'topics_tags');
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

  public static function top5Tags(){
    $query = 'SELECT tag_id as id,
                     name, 
                     SUM(qtd) as qtd
              FROM
              (
                SELECT pt.tag_id,
                     count(*) as qtd,
                     t.name
                FROM posts_tags pt, posts p, tags t
                WHERE pt.post_id = p.id
                AND   pt.tag_id = t.id
                AND p.status = 1
                GROUP BY pt.tag_id

                UNION 

                SELECT st.tag_id, 
                     count(*) as qtd,
                     t.name
                FROM sentis_tags st, sentis s, posts p, tags t
                WHERE st.sentis_id = s.id
                AND   s.post_id = p.id
                AND   st.tag_id = t.id
                AND p.status = 1
                GROUP BY st.tag_id
              ) a 
              GROUP BY tag_id
              ORDER BY qtd DESC
              LIMIT 0, 5';

    return Tag::loadTagModelsByIds($query);
  }

  private static function loadTagModelsByIds($query) {
    return DB::select(DB::raw($query));
  }
}
