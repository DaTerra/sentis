<?php
use Illuminate\Database\Eloquent\Collection;
class Feeling extends Eloquent {
	protected $fillable = array('name', 'description', 'order', 'icon');
	public $timestamps = false;

	public function topics()
  	{
      return $this->belongsToMany('Topic', 'topics_feelings');
  	}
	
	public function sentis(){
		return $this->belongsToMany('Sentis', 'sentis_feelings','feeling_id', 'sentis_id')
            ->withPivot('value');
	}

	public static function top5Feelings(){
		$query = 'SELECT sf.feeling_id as id, 
				  	     f.name,
					     count(*) as qtd 
				  FROM sentis_feelings sf, 
				  	   feelings f, 
				  	   sentis s, 
				  	   posts p
				  WHERE sf.feeling_id = f.id
				  AND   sf.sentis_id = s.id
			  	  AND   s.post_id = p.id
				  AND   p.status = 1
				  GROUP BY sf.feeling_id
				  ORDER BY qtd DESC
				  LIMIT 0, 5';
		
		return Feeling::loadFeelingModelsByIds($query);
	}

	private static function loadFeelingModelsByIds($query) {
		return DB::select(DB::raw($query));
	}
}
