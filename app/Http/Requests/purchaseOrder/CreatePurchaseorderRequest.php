<?php

namespace App\Http\Requests\purchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseorderRequest extends FormRequest
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
            'delivery_place' => ['required'],
            'payment_terms' => ['required'],
            'general_terms' => ['required'],
            'suppling_duration' => ['required'],
            'total_gross' => ['required'],
            'taxes' => ['required'],
            'net_total' => ['required'],
            'supplier_id' => ['required'],

            // 'unit_id' => ['required', 'array', 'min:1'],
            // 'unit_id.*' => ['required'],

            // 'qty' => ['required', 'array', 'min:1'],
            // 'qty.*' => ['required'],

            // 'price' => ['required', 'array', 'min:1'],
            // 'price.*' => ['required'],

            // 'total' => ['required', 'array', 'min:1'],
            // 'total.*' => ['required'],
            



        ];
    }

    public function messages()
    {
        return [
            'delivery_place.required' =>__('site.delivery_place')." ".__('site.is_required'),
            'payment_terms.required' =>__('site.payment_terms')." ".__('site.is_required'),
            'general_terms.required' =>__('site.general_terms')." ".__('site.is_required'),
            'suppling_duration.required' =>__('site.suppling_duration')." ".__('site.is_required'),
            'total_gross.required' =>__('site.total_gross')." ".__('site.is_required'),
            'taxes.required' =>__('site.taxes')." ".__('site.is_required'),
            'net_total.required' =>__('site.net_total')." ".__('site.is_required'),
            'supplier_id.required' =>__('site.Supplier')." ".__('site.is_required'),
            'unit_id[].required' =>__('site.Unit')." ".__('site.is_required'),
            'qty[].required' =>__('site.actual_quantity')." ".__('site.is_required'),
            'price[].required' =>__('site.price')." ".__('site.is_required'),
            'total[].required' =>__('site.total')." ".__('site.is_required'),

        ];
    }

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
