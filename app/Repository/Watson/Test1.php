<?php

namespace App\Repository\Watson;

use App\Repository\WatsonRepository;
use Illuminate\Support\Facades\Validator;


class Test1 extends WatsonRepository
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'parameter' => 'required',
        ];
    }

    public function handle()
    {
        return ['message' => $this->parameter];
    }
}
