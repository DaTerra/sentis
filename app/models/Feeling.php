<?php
use Illuminate\Database\Eloquent\Collection;
class Feeling extends Eloquent {
	protected $fillable = array('name', 'description', 'order', 'icon');
	public $timestamps = false;
	
	public function sentis(){
		return $this->belongsToMany('Sentis', 'sentis_feelings','feeling_id', 'sentis_id')
            ->withPivot('value');
	}

	public static function top5Feelings(){
		$query = 'SELECT feeling_id, 
			    	  	 count(*) as qtd 
				  FROM sentis_feelings
			 	  GROUP BY feeling_id
			  	  ORDER BY qtd DESC
			      LIMIT 0, 5';
		
		return Feeling::loadFeelingModelsByIds($query);
	}

	private static function loadFeelingModelsByIds($query) {
		$feelings = 
        DB::select(
            DB::raw($query)
        );

		$feelingIds = [];
        foreach ($feelings as $feeling) {
            array_push($feelingIds, $feeling->feeling_id);    
        }
        
        $feelings = Feeling::find($feelingIds);
        return Feeling::orderFeelings($feelings, $feelingIds);
	}

	private static function orderFeelings($feelings, $feelingIds){
		$sorted = array_flip($feelingIds);
					
		foreach ($feelings as $feeling) $sorted[$feeling->id] = $feeling;
		$sorted = Collection::make(array_values($sorted));

        return $sorted;
	}
}
