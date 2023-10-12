<?php

namespace App\Elasticsearch\Traits;

trait ParentTrait
{
    public function name(string $remove = '')
    {
        $remove = str($remove)->ucfirst()->value();
        return str(class_basename($this))
            ->replace($remove, '')
            ->snake()
            ->value();
    }
}
