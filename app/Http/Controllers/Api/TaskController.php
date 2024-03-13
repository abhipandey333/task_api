<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskGetRequest;
use App\Models\Note;
use App\Models\Task;
use App\PriorityEnum;

class TaskController extends Controller
{
    public function store(TaskCreateRequest $request)
    {
        // Create the task
        $task = Task::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'priority' => $request->priority
        ]);

        // Create notes for the task if exists
        if ($request->notes && count($request->notes)) {

            foreach ($request->notes as $note) {

                $taskNote = new Note([
                    'subject' => $note['subject'],
                    'note' => $note['note']
                ]);

                // add attachments in note if exists
                if (isset($note['attachments']) && count($note['attachments'])) {

                    $attachmentNamesArr = [];

                    // Store attachments
                    foreach ($note['attachments'] as $attachment) {

                        // Generate a unique filename for each attachment
                        $filename = uniqid() . '.' . $attachment->getClientOriginalExtension();

                        // Save the attachment to the local storage under the 'attachments' directory
                        $attachment->storeAs('attachments', $filename);

                        $attachmentNamesArr[] = $filename;
                    }

                    $attachmentNames = implode(',', $attachmentNamesArr);
                    $taskNote['attachment'] = $attachmentNames ?? null;
                }

                $task->notes()->save($taskNote);
            }
        }

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    public function getTasks(TaskGetRequest $request)
    {
        $tasks = Task::whereHas('notes', function ($query) use ($request) {
            $query->where('note', 'like', '%' . $request->note . '%');
        })
            ->with('notes')
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->has('due_date'), function ($query) use ($request) {
                $query->where('due_date', $request->due_date);
            })
            ->when($request->has('priority'), function ($query) use ($request) {
                $query->where('priority', $request->priority);
            })
            ->withCount('notes')
            ->orderByRaw("CASE 
                                WHEN priority = '" . PriorityEnum::HIGH->value . "' THEN 1 
                                WHEN priority = '" . PriorityEnum::MEDIUM->value . "' THEN 2 
                                ELSE 3 
                            END")
            ->orderBy('notes_count', 'desc')
            ->get();


        if (count($tasks)) {

            return response()->json(['tasks' => $tasks], 200);
        }

        return response()->json(['tasks' => "No Task Found!"], 200);
    }
}
