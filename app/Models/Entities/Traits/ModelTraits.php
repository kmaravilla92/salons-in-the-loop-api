<?php

namespace App\Models\Entities\Traits;

trait ModelTraits {

    public function prepareOptions($options = [])
    {
        $model = $this;
        if(isset($options['relationships'])) {
            $relationships = explode(',', $options['relationships']);
            $with = [];
            foreach($relationships as $relationship) {
                $with[$relationship] = function($query) {
                    $query->orderBy('id', 'DESC');
                };
            }
            $model = $model->with($with);
        }
        return $model;
    }

    public function getFullClassNameAttribute()
    {
        return self::class;
    }

    public function scopeOwnedBy($query, $user_id = null, $field = 'user_id')
    {
        return $query->where($field, $user_id);
    }

    public function truncate($value, $limit = 20)
    {
        if(strlen($value) <= $limit){
            return $value;
        }
        return substr($value, 0, $limit) . '...';
    }
}
