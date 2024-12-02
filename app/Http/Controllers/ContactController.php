<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function __invoke(StoreContactRequest $request)
    {

        try {
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json($contact, 201);
    }
}
