<?php

namespace Korko\SecretSanta\Http\Requests;

class RandomFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'g-recaptcha-response' => 'required|recaptcha',
            'name'                 => 'required|array|min:3|arrayunique',
            'email'                => 'array',
            'exclusions'           => 'array',
            'dearsanta'            => 'boolean|in:"0","1"',
            'dearsanta-expiration' => 'required_if:dearsanta,"1"|date|after:tomorrow|before:+1year',
        ];

        if (!empty($this->request->get('name'))) {
            $rules += [
                'title'       => 'required_with:'.implode(',', array_map(function ($key) {
                    return 'email.'.$key;
                }, array_keys($this->request->get('name', [])))).'|string',
                'contentMail' => 'required_with:'.implode(',', array_map(function ($key) {
                    return 'email.'.$key;
                }, array_keys($this->request->get('name', [])))).'|string|contains:{TARGET}',
            ];

            foreach ($this->request->get('name') as $key => $name) {
                $rules += [
                    'email.'.$key      => 'required|email',
                    'exclusions.'.$key => 'sometimes|array',
                ];

                $exclusions = $this->request->get('exclusions') ?: [];
                $exclusions = isset($exclusions[$key]) ? (array) $exclusions[$key] : [];
                foreach ($exclusions as $key2 => $name2) {
                    $rules += [
                        'exclusions.'.$key.'.'.$key2 => 'integer|fieldinkeys:name,'.$key,
                    ];
                }
            }
        }

        return $rules;
    }
}
