<?php

namespace App\Http\Controllers;

use App\Models\StudentProject;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(StudentProject $studentProject)
    {
        $user = Auth::user();
        $isStudent = ($user->id === $studentProject->student_id);
        $isMentor = ($user->id === $studentProject->project->mentor_id);
        $isAdmin = $user->isAdmin();

        if (!($isStudent || $isMentor || $isAdmin)) {
            abort(403, 'У вас нет доступа к этому чату.');
        }

        $messages = $studentProject->messages()->with('sender')->orderBy('created_at')->get();
        return view('chat.index', compact('studentProject', 'messages'));
    }

    public function send(Request $request, StudentProject $studentProject)
    {
        $user = Auth::user();
        $isStudent = ($user->id === $studentProject->student_id);
        $isMentor = ($user->id === $studentProject->project->mentor_id);
        $isAdmin = $user->isAdmin();

        if (!($isStudent || $isMentor || $isAdmin)) {
            abort(403, 'У вас нет доступа к этому чату.');
        }

        $request->validate(['text' => 'required|string|max:1000']);

        $receiverId = ($user->id === $studentProject->student_id)
            ? $studentProject->project->mentor_id
            : $studentProject->student_id;

        if (!$receiverId) {
            return back()->with('error', 'Не удалось определить получателя.');
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'student_project_id' => $studentProject->id,
            'text' => $request->text,
        ]);

        return back()->with('success', 'Сообщение отправлено.');
    }

    public function update(Request $request, Message $message)
    {
        $user = Auth::user();
        if ($message->sender_id !== $user->id && !$user->isAdmin()) {
            abort(403);
        }

        $request->validate(['text' => 'required|string|max:1000']);
        $message->text = $request->text;
        $message->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Message $message)
    {
        $user = Auth::user();
        if ($message->sender_id !== $user->id && !$user->isAdmin()) {
            abort(403);
        }

        $message->delete();
        return response()->json(['success' => true]);
    }
}
