<?php

namespace App\Concerns;

use App\Post\Model as PostModel;
use App\Term\Model as TermModel;
use Illuminate\Support\Collection;

trait HasRelationships
{
    public function hasOneOrMany($class)
    {
        $instance = new $class;
        return (is_subclass_of($instance, PostModel::class)) ? $this->retrievePost($instance)
            : $this->retrieveTaxonomy($instance);
    }

    /**
     * @param $relatedClass TermModel
     * @return Collection
     */
    protected function retrieveTaxonomy($relatedClass)
    {
        $class = new \ReflectionClass($relatedClass);
        return Collection::make(wp_get_post_terms($this->id, $relatedClass->taxonomy))
            ->map(function ($term) use ($class) {
                return ($class->name)::fromID($term->term_id);
            });
    }

    /**
     * @param $relatedClass PostModel
     * @return Collection
     */
    protected function retrievePost($relatedClass)
    {
        return $relatedClass
            ->query()
            ->set(
                'tax_query',
                [
                    [
                        'taxonomy' => $this->taxonomy,
                        'field' => 'term_id',
                        'terms' => $this->term_id,
                    ]
                ]
            )
            ->results();
    }
}
