<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\Lead;
use App\Mail\NewContact;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'name' => 'required|min:3|max:100',
                'email' => 'required|email',
                'message' => 'required|min:3',
            ],
            [
                'name.required' => 'Campo obbligatorio',
                'name.min' => 'il nome deve avere almeno :min caratteri',
                'name.max' => 'il nome deve avere massimo :max caratteri',
                'email.email' => 'Formato email non corretto',
                'email.required' => 'Campo obbligatorio',
                'message.required' => 'Campo obbligatorio',
                'message.min' => 'il messaggio deve avere almeno :min caratteri',
            ],
        );

        if ($validator->fails()) {
            $success = false;
            $errors = $validator->errors();
            return response()->json(compact('success', 'errors'));
        }


        // salvo email in db
        $new_lead = new Lead();
        $new_lead->fill($data);
        $new_lead->save();

        // invio email
        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new NewContact($new_lead));

        $success = true;
        return response()->json(compact('success'));

        // return response()->json($request->all());
    }
}
