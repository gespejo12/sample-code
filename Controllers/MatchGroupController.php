<?php

namespace App\Http\Controllers;

use App\Repositories\MatchGroupRepository;
use App\Http\Requests\CreateMatchGroupRequest;

class MatchGroupController extends Controller
{
    /**
     * @var MatchGroupRepository
     */
    private $matchGroupRepository;

    /**
     * MatchGroupController constructor.
     * @param MatchGroupRepository $matchGroupRepository
     */
    public function __construct(
        MatchGroupRepository $matchGroupRepository
    ) {
        $this->matchGroupRepository = $matchGroupRepository;
    }

    /**
     * Create match Group
     *
     * @param CreateMatchGroupRequest $request
     * @return JsonResponse
     */
    public function store(CreateMatchGroupRequest $request)
    {
        $match_group = $this->matchGroupRepository->create($request->validated());
        //submit handler service
        $this->matchGroupRepository->handlerService($match_group);
        return response()->json([
            'status' => 'success',
            'data'  => $match_group->toArray()
        ], 200);
    }

    /**
     * Update match Group
     *
     * @param UpdateMatchGroupRequest $request
     * @return JsonResponse
     */
    public function update($id, UpdateMatchGroupRequest $request)
    {
        //check if match range is exists
        $match_group = $this->matchGroupRepository->findOrFail($id); 
        //update match range
        $match_group = $this->matchGroupRepository->update($match_group, $request->validated());
        //submit handler service
        $this->matchGroupRepository->handlerService($match_group);
        
        return response()->json([
            'status' => 'success',
            'data'  => $match_group->toArray()
        ], 200);
    }

    /**
     * delete match Group
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $match_group = $this->matchGroupRepository->findOrFail($id);
        try {
            DB::beginTransaction();
            $this->matchGroupRepository->delete($match_group);
            DB::commit();
        } catch (\Exception $e) {
            //rollback all database transactions
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
        ], 200);
    }

}
