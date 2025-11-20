<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Store a newly created contact request in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'weddingDate' => 'nullable|date',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ]);
            }
            
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $contactRequest = ContactRequest::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone,
            'wedding_date' => $request->weddingDate,
            'message' => $request->message,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ваше сообщение успешно отправлено!'
            ]);
        }

        // Here you can add notification to admin or other actions
        // For example, send email to admin about new contact request

        return redirect()->back()->with('success', 'Ваше сообщение успешно отправлено!');
    }

    /**
     * Display a listing of contact requests for admin panel.
     */
    public function index()
    {
        $contactRequests = ContactRequest::orderBy('created_at', 'desc')->get();
        return view('admin.contact-requests.index', compact('contactRequests'));
    }

    /**
     * Display the specified contact request.
     */
    public function show(ContactRequest $contactRequest)
    {
        // Mark as read when admin opens it
        if (!$contactRequest->is_read) {
            $contactRequest->update(['is_read' => true]);
        }

        return view('admin.contact-requests.show', compact('contactRequest'));
    }

    /**
     * Send reply to contact request
     */
    public function reply(Request $request, ContactRequest $contactRequest)
    {
        $validator = Validator::make($request->all(), [
            'reply_message' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ]);
            }
            
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Send email to the client
        Mail::raw($request->reply_message, function ($message) use ($contactRequest) {
            $message->to($contactRequest->email)
                    ->subject('Ответ на ваш запрос с сайта');
        });

        // Mark as replied
        $contactRequest->update([
            'is_replied' => true,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ответ успешно отправлен клиенту!'
            ]);
        }

        return redirect()->back()->with('success', 'Ответ успешно отправлен клиенту!');
    }
}