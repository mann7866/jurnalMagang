<?php

namespace App\Http\Controllers\api\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\JournalRequest;
use App\Contracts\Interfaces\JournalInterface;
use App\Http\Resources\JournalResource;
use App\Services\DetailUserService;
use App\Services\JournalService;

class JournalController extends Controller
{
    private JournalInterface $journalInterface;
    private DetailUserService $detailUserService;

    private JournalService $journalService;

    public function __construct(
        JournalInterface $journalInterface,
        DetailUserService $detailUserService,
        JournalService $journalService,
    ) {
        $this->journalInterface = $journalInterface;
        $this->detailUserService = $detailUserService;
        $this->journalService = $journalService;
    }

    public function getData(){
        try{
            $journal = $this->journalInterface->get();
            return response()->json([
                'status' => true,
                'messages' => 'Collect data journal',
                'data' => $journal,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'   => false,
                'messages' => 'error',
                'data'     => $e->getMessage(),
            ], 500);
        }
    }

    public function store(JournalRequest $request){
        $data = $this->journalService->store($request);
        $journal = $this->journalInterface->store($data['jurnal']);
        return response()->json([
                'status'   => true,
                'messages' => 'Store success',
                'data'     => new JournalResource($journal),
        ],201);
    }


}
