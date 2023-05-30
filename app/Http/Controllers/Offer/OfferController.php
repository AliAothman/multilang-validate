<?php
namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    public function create()
    {
        return view('offer.create');
    }

    public function store(Request $request)
    {

        $messages = $this ->getMessages();
        $rules = $this ->getRules();

        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()) {
            return redirect('create')
                ->withErrors($validator)
                ->withInput();
        }
        Offer::query()->create(
            [
                'offername'=>$request->input('offername'),
                'company'=>$request->input('company'),
                'quality'=>$request->input('quality'),
                'description'=>$request->input('description'),
                'price'=>$request->input('price')

            ]
        );

        return redirect()->back()->with(['success' => 'تم إضافة العرض بنجاح']);
    }

    protected function getMessages(){
        return $messages=    [
            'offername.required'=> __('messages.offername required'),
            'offername.unique'=> __('messages.offername.unique'),
            'offername.max'=> __('messages.offername.max'),
            'company.required'=> __('messages.company.required'),
            'quality.required'=> __('messages.quality.required'),
            'description.required'=> __('messages.description.required'),
            'description.max'=> __('messages.description.max'),
            'price.required'=> __('messages.price.required'),
            'price.numeric'=> __('messages.price.numeric'),
            'price.max'=> __('messages.price.max'),

        ];
    }
    protected function getRules(){
        return $rules= [
            'offername' => 'required|unique:offers|max:255',
            'company' => 'required',
            'quality'=> 'required',
            'description'=>'required|max:1024',
            'price'=>'required|numeric|max:100000000'
        ];
    }


}



