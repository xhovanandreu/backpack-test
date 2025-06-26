<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use App\Models\Article;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class ArticlesImport implements ToModel, WithValidation, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Article([
            'title'       => $row['title'],
            'subtitle'    => $row['subtitle'],
            'body' =>  $row['body'],
            'slug' =>  $row['slug'],
        ]);
    }

    /**
     * Validate the data from the csv file
     *
     * @return array of rules
     */

    public function rules(): array
    {
        return [
            'title' => ['required','string'],
            'subtitle' => ['required','string'],
            'body' => ['required','string'],
            'slug' => ['required','string', 'unique:articles,slug'],
        ];
    }

}
