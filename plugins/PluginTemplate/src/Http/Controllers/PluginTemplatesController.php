<?php

namespace Plugins\PluginTemplate\Http\Controllers;


use App\Http\Controllers\AuthController as Controller;
use Plugins\PluginTemplate\Http\Requests\PluginTemplateCreateRequest;
use Plugins\PluginTemplate\Http\Requests\PluginTemplateUpdateRequest;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Plugins\PluginTemplate\Repositories\Contracts\PluginTemplateRepository;
use Plugins\PluginTemplate\Validators\PluginTemplateValidator;

/**
 * Class PluginTemplatesController.
 *
 * @package namespace App\PluginTemplate\Http\Controllers;
 */
class PluginTemplatesController extends Controller
{
    /**
     * @var PluginTemplateRepository
     */
    protected $repository;

    /**
     * @var PluginTemplateValidator
     */
    protected $validator;

    /**
     * PluginTemplatesController constructor.
     *
     * @param PluginTemplateRepository $repository
     * @param PluginTemplateValidator $validator
     */
    public function __construct(PluginTemplateRepository $repository, PluginTemplateValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    public function fuck()
    {
        dd('aa');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $PluginTemplates = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $PluginTemplates,
            ]);
        }

        return view('PluginTemplates.index', compact('PluginTemplates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PluginTemplateCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PluginTemplateCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $PluginTemplate = $this->repository->create($request->all());

            $response = [
                'message' => 'PluginTemplate created.',
                'data'    => $PluginTemplate->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $PluginTemplate = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $PluginTemplate,
            ]);
        }

        return view('PluginTemplates.show', compact('PluginTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $PluginTemplate = $this->repository->find($id);

        return view('PluginTemplates.edit', compact('PluginTemplate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PluginTemplateUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PluginTemplateUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $PluginTemplate = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'PluginTemplate updated.',
                'data'    => $PluginTemplate->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'PluginTemplate deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'PluginTemplate deleted.');
    }
}
