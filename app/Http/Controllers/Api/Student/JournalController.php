<?php
namespace App\Http\Controllers\api\Student;

use App\Contracts\Interfaces\JournalInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\JournalRequest;
use App\Http\Resources\JournalResource;
use App\Services\JournalService;

class JournalController extends Controller
{
    private JournalInterface $journalInterface;

    private JournalService $journalService;

    public function __construct(
        JournalInterface $journalInterface,
        JournalService $journalService,
    ) {
        $this->journalInterface  = $journalInterface;
        $this->journalService    = $journalService;
    }

    public function getData()
    {
        try {
            $journal = $this->journalInterface->get();
            return response()->json([
                'status'   => true,
                'messages' => 'Collect data journal',
                'data'     => JournalResource::collection($journal),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'error',
                'data'     => $e->getMessage(),
            ], 500);
        }
    }

    public function store(JournalRequest $request)
    {
        try {
            $data    = $this->journalService->store($request);
            $journal = $this->journalInterface->store($data['jurnal']);
            return response()->json([
                'status'   => true,
                'messages' => 'Store success',
                'data'     => new JournalResource($journal),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'failed to store data',
                'data'     => $e->getMessage(),
            ], 422);
        }
    }
    public function update(JournalRequest $request, $id)
    {
        try {
            $oldData = $this->journalInterface->find($id);
            $data    = $this->journalService->update($request, $oldData);
            $journal = $this->journalInterface->update($id, $data['jurnal']);
            return response()->json([
                'status'   => true,
                'messages' => 'Update success',
                'data'     => $data['jurnal'],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'failed to update data',
                'data'     => $e->getMessage(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $this->journalInterface->delete($id);
            return response()->json([
                'status'   => true,
                'messages' => 'Success to delete data',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'Student not found',
                'data'     => $e->getMessage(),
            ]);
        }

    }

}
