<?php

namespace Vacancy\Source;

use Vacancy\Source;
use Vacancy\Source\Model;

interface WriteableSource extends Source
{
    public function update(Model $model);
}