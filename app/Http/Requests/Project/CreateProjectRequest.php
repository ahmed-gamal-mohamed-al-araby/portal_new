<?php

namespace App\Http\Requests\Project;

use App\Rules\UserActive;
use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
        return [
            'name_ar' => ['required', 'max:500', 'unique:projects,name_ar,' . $this->project],
            'name_en' => ['required', 'max:500', 'unique:projects,name_en,' . $this->project],
            'description_ar' => ['required'],
            'description_en' => ['required'],
            'sector_id' => ['required', 'exists:sectors,id'], // the sector that project belongs to 
            'manager_id' => ['required', 'exists:users,id', new UserActive],  // the manager that manage this project
            'completed' => ['required'],
            // 'code' => ['required'.'numeric','unique:projects,code'],
            // 'type' => ['required'],
            // 'business_nature_id' => ['required'],
            // 'item_id' => ['required'],

        ];
    }

    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        Toastr()->error(
            trans('site.validation_error'),
            trans("site.Sorry"),
            [
                "closeButton" => true,
                "progressBar" => true,
                "positionClass" => app()->getlocale() == 'en' ? "toast-top-right" : "toast-top-left",
                "timeOut" => "3000",
                "extendedTimeOut" => "3000",
            ]
        );
        $url = $this->redirector->getUrlGenerator();

        if ($this->redirect) {
            return $url->to($this->redirect);
        } elseif ($this->redirectRoute) {
            return $url->route($this->redirectRoute);
        } elseif ($this->redirectAction) {
            return $url->action($this->redirectAction);
        }

        return $url->previous();
    }
}
