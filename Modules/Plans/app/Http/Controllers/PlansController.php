<?php

namespace Modules\Plans\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Plans\Http\Requests\CreatePlansRequest;
use Modules\Plans\Http\Requests\UpdatePlansRequest;
use Modules\Plans\Models\Plans;

class PlansController extends Controller
{

    public function index(): JsonResponse
    {
        $plans = Plans::paginate(15);
        return response()->json($plans);
    }

    public function store(CreatePlansRequest $request): JsonResponse
    {
        $plan = Plans::create($request->validated());
        return response()->json($plan, 201);
    }


    public function show($id): JsonResponse
    {
        $plan = Plans::findOrFail($id);
        return response()->json($plan);
    }

    public function update(UpdatePlansRequest $request, $id): JsonResponse
    {
        $plan = Plans::findOrFail($id);
        $plan->update($request->validated());
        return response()->json($plan);
    }

    public function destroy($id): JsonResponse
    {
        $plan = Plans::findOrFail($id);
        $plan->delete();
        return response()->json(null, 204);
      }
}
