<?php

namespace App\Repositories\Course;

use App\Models\Course;
use App\Repositories\BaseRepository;
use App\Repositories\Course\CourseInterface;
use Illuminate\Support\Str;

class EloquentCourseRepository extends BaseRepository implements CourseInterface
{
    public $model;

    function __construct(Course $model) {
        $this->model = $model;
    }

    public function create(array $attributes)
    {


        $provider_price = intval(floatval($attributes['provider_price'])*100);
        $retail_price = intval(floatval($attributes['retail_price'])*100);

        if(isset($attributes['discounted_retail_price'])){
            $discounted_retail_price = intval(floatval($attributes['discounted_retail_price'])*100);
        }

        $course = $this->model->create([
            'provider_id'           => $attributes['provider']['id'],
            'title'                 => $attributes['title'],
            'provider_price'        => $provider_price,
            'retail_price'          => $retail_price,
            'description'           => $attributes['description'],
            'featured'              => isset($attributes['featured']) ? $attributes['featured'] : false,
            'excerpt'               => $attributes['excerpt'],
            'duration'              => $attributes['duration'],
            'main_image'            => $attributes['main_image'],
            'provider_reference_id' => isset($attributes['provider_reference_id']) ? $attributes['provider_reference_id'] : null,
            'modules'               => isset($attributes['modules']) ? $attributes['modules'] : null,
            'skills_learned'        => isset($attributes['skills_learned']) ? $attributes['skills_learned'] : null,
            'discounted_retail_price'        => isset($attributes['discounted_retail_price']) ? $discounted_retail_price : null
        ]);

        $course->categories()->sync(collect($attributes['categories'])->pluck('id'));

        return true;
    }

    public function updateById($id, array $attributes)
    {
        $provider_price = intval(floatval($attributes['provider_price'])*100);
        $retail_price = intval(floatval($attributes['retail_price'])*100);

        if(isset($attributes['discounted_retail_price'])){
            $discounted_retail_price = intval(floatval($attributes['discounted_retail_price'])*100);
        }


        $course = $this->model->find($id);
        $course->update([
            'provider_id'           => $attributes['provider']['id'],
            'title'                 => $attributes['title'],
            'provider_price'        => $provider_price,
            'retail_price'          => $retail_price,
            'description'           => $attributes['description'],
            'featured'              => isset($attributes['featured']) ? $attributes['featured'] : false,
            'excerpt'               => $attributes['excerpt'],
            'duration'              => $attributes['duration'],
            'main_image'            => $attributes['main_image'],
            'provider_reference_id' => isset($attributes['provider_reference_id']) ? $attributes['provider_reference_id'] : null,
            'modules'               => isset($attributes['modules']) ? $attributes['modules'] : null,
            'skills_learned'        => isset($attributes['skills_learned']) ? $attributes['skills_learned'] : null,
            'discounted_retail_price'        => isset($attributes['discounted_retail_price']) ? $discounted_retail_price : null
        ]);

        $course->categories()->sync(collect($attributes['categories'])->pluck('id'));

        return true;

    }

}
