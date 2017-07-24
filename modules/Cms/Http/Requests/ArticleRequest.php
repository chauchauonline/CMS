<?php namespace Modules\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest {

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
        return [
            'title' =>'required|max:200',
            'content' => 'required',
            'category_id' =>'required',
            'orderby' =>'numeric',
            'brief'     => 'required|max:500',
            'source'    => 'max:200',
        ];
    }
}
