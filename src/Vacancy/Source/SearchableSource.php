<?php

namespace Vacancy\Source;

use Vacancy\Source;

interface SearchableSource extends Source
{
    public function find(array $filters);
}