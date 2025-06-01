<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Dash\DashController;
use App\Http\Requests\Dash\ContactRequest;
use App\Models\Contact;

class ContactController extends DashController
{
    public function __construct(Contact $model)
    {
        parent::__construct();
        $this->model = $model;

        view()->share([
            'module_actions' => [],
        ]);
    }

    public function getContact()
    {
        $item = Contact::find(1); 
        return $this->returnData(['item' => $item]);
    }

    public function update(ContactRequest $request)
    {
        $data =  $request->all();
        $contact = Contact::find(1);
        $update = $contact->update($data);

        if ($update) {
            return $this->returnSuccess(trans('messages.update_successfully'));
        } else {
            return $this->returnError(trans('messages.fail_update'));
        }
    }
}
