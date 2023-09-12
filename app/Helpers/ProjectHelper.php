<?php

namespace App\Helpers;

use App\Models\Project;

class ProjectHelper
{
    public static function hasHeadOffice(?Project $project)
    {
        return str($project?->location_prefix)->contains('HO') || str($project?->project)->contains('HO');
    }
}
