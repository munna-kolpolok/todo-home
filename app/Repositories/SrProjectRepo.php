<?php

namespace App\Repositories;

use App\Models\Language;
use App\Models\Sr_Project_Translation;

class SrProjectRepo
{
    public function projects()
    {
        //$projectOptions = "<option value=''>Select a project</option>";
        $projectOptions = "";
        $projects = Sr_Project_Translation::where('locale', 'en')->get(['sr_project_id', 'name']);
        foreach ($projects as $project) {
            $projectOptions .= "<option value='$project->sr_project_id'>$project->name</option>";
        }
        return $projectOptions;
    }

    public function languagesExceptEnglish($en = true)
    {
        //$languageOptions = "<option value=''>Select a Language</option>";
        $languageOptions = "";
        $languages = $en ? $languages = Language::where('code', '!=', 'en')->get(['code', 'name']) : $languages = Language::get(['code', 'name']);
        foreach ($languages as $language) {
            $languageOptions .= "<option value='$language->code'>$language->name</option>";
        }
        return $languageOptions;
    }

    public function findProjectName($id)
    {
        $projectName = Sr_Project_Translation::findOrFail($id)->name;
        return $projectName;
    }


}