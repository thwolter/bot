<?php

namespace App\Repository;


use App\Http\Requests\WebhookRequest;
use App\Repository\Watson\IsTimeSlotFree;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class WatsonRepository
{

    private $parameters;


    public function __construct(WebhookRequest $request)
    {
        $this->parameters = $this->validate($request);
    }


    public function rules()
    {
        return [
            //
        ];
    }


    protected function validate($request)
    {
        if ($this->rules() == [])
            return $request->all();

        return Validator::make($request->all(), $this->rules())->validate();
    }

    public function __get($name)
    {
        return Arr::get($this->parameters, $name);
    }
}
