<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Redirect;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);

        return view('admin.contact-messages.index', [
            'messages' => $messages,
        ]);
    }

    public function show(ContactMessage $contactMessage)
    {
        return view('admin.contact-messages.show', [
            'message' => $contactMessage,
        ]);
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return Redirect::route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}
