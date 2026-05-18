<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
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

    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);

        return view('admin.contact-messages.show', [
            'message' => $message,
        ]);
    }

    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return Redirect::route('admin.contact-messages.index')->with('success', 'Message deleted successfully.');
    }
}
