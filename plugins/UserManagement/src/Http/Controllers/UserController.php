<?php

namespace Plugins\UserManagement\Http\Controllers;


use App\Http\Controllers\AuthController as Controller;
use Plugins\UserManagement\Http\Requests\UserCreateRequest;
use Plugins\UserManagement\Http\Requests\UserUpdateRequest;
use Prettus\Validator\Exceptions\ValidatorException;
use Plugins\UserManagement\Repositories\Contracts\UserRepository;

/**
 * Class UserController.
 *
 * @package namespace App\User\Http\Controllers;
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
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
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function store(UserCreateRequest $request)
    {
        try {


            $PluginTemplate = $this->repository->create($request->all());

            $response = [
                'message' => 'User created.',
                'data'    => $PluginTemplate->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (\Exception $e) {
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
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UserUpdateRequest $request, $id)
    {
        try {


            $PluginTemplate = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'User updated.',
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
                'message' => 'User deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'User deleted.');
    }
}
