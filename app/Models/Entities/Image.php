<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Image extends Model
{

	protected $table = 'images';

 	protected $guarded = [];  

 	protected $appends = [];

 	public function saveAndStore(Request $request)
 	{
 		if($request->hasFile('file')){
            $file = $request->file('file');
            $this->name = $file->getClientOriginalName();
            $this->type = $request->type;
            $this->type_id = $request->type_id; // user id
            $this->path = $file->store(
                sprintf(
                    'public/images/%s/%s',
                    $this->type, 
                    $this->type_id
                )
            );
            $this->path = str_replace('public',config('app.url') . '/storage', $this->path);
            // $this->save();
            return $this;
        }

        return null;
 	}
}
