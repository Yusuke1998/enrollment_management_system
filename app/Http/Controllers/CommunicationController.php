<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Father, Course, Communication, 
    CommunicationRecipient
};

class CommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $communications = Communication::all();
        return view('communications.index', compact('communications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('communications.create');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $communication = Communication::with(['recipients.recipient', 'course'])->findOrFail($id);
        return view('communications.show', compact('communication'));
    }

    public function resend(Communication $communication)
    {
        $originalRecipients = $communication->recipients()
            ->where('is_resent', false)
            ->pluck('recipient_id')
            ->toArray();

        foreach ($originalRecipients as $recipientId) {
            CommunicationRecipient::create([
                'communication_id' => $communication->id,
                'recipient_id' => $recipientId,
                'recipient_type' => Father::class,
                'user_id' => auth()->id(),
                'status' => Communication::PENDING,
                'is_resent' => true,
                'resent_at' => now()
            ]);
        }
        
        $communication->update(['sent_date' => now()]);
        
        return redirect()->route('communications.show', $communication->id)
                    ->with('success', 'Comunicación reenviada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Communication $communication)
    {
        return view('communications.edit', compact('communication'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Communication $communication)
    {
        $communication->delete();
        return redirect()->route('communications.index')
                    ->with('success', 'Comunicación eliminada exitosamente');
    }
}
