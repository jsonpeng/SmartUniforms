<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSchoolClassRequest;
use App\Http\Requests\UpdateSchoolClassRequest;
use App\Repositories\SchoolClassRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\School;

class SchoolClassController extends AppBaseController
{
    /** @var  SchoolClassRepository */
    private $schoolClassRepository;

    public function __construct(SchoolClassRepository $schoolClassRepo)
    {
        $this->schoolClassRepository = $schoolClassRepo;
    }

    /**
     * Display a listing of the SchoolClass.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request,$school_id)
    {
        $this->schoolClassRepository->pushCriteria(new RequestCriteria($request));
        $school = School::find($school_id);

        if(empty($school)){
             Flash::error('没有找到该学校的信息');

            return redirect(route('schools.index'));
        }

        $schoolClasses = $this->descAndPaginateToShow($this->schoolClassRepository->model()::where('school_id',$school_id),'created_at','desc');

        return view('school_classes.index')
            ->with('schoolClasses', $schoolClasses)
            ->with('school_id',$school_id)
            ->with('school',$school);
    }

    /**
     * Show the form for creating a new SchoolClass.
     *
     * @return Response
     */
    public function create($school_id)
    {
        return view('school_classes.create',compact('school_id'));
    }

    /**
     * Store a newly created SchoolClass in storage.
     *
     * @param CreateSchoolClassRequest $request
     *
     * @return Response
     */
    public function store(CreateSchoolClassRequest $request,$school_id)
    {
        $input = $request->all();

        $schoolClass = $this->schoolClassRepository->create($input);

        Flash::success('添加成功.');

        return redirect(route('schoolClasses.index',$school_id));
    }

    /**
     * Display the specified SchoolClass.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($school_id,$id)
    {
        $schoolClass = $this->schoolClassRepository->findWithoutFail($id);

        if (empty($schoolClass)) {
            Flash::error('没有找到该信息');

            return redirect(route('schoolClasses.index'));
        }

        return view('school_classes.show')->with('schoolClass', $schoolClass);
    }

    /**
     * Show the form for editing the specified SchoolClass.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($school_id,$id)
    {
        $schoolClass = $this->schoolClassRepository->findWithoutFail($id);

        if (empty($schoolClass)) {
            Flash::error('没有找到该信息');

            return redirect(route('schoolClasses.index'));
        }

        return view('school_classes.edit')
        ->with('schoolClass', $schoolClass)
        ->with('school_id',$school_id);
    }

    /**
     * Update the specified SchoolClass in storage.
     *
     * @param  int              $id
     * @param UpdateSchoolClassRequest $request
     *
     * @return Response
     */
    public function update($school_id,$id, UpdateSchoolClassRequest $request)
    {
        $schoolClass = $this->schoolClassRepository->findWithoutFail($id);

        if (empty($schoolClass)) {
            Flash::error('没有找到该信息');

            return redirect(route('schoolClasses.index'));
        }

        $schoolClass = $this->schoolClassRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('schoolClasses.index',$school_id));
    }

    /**
     * Remove the specified SchoolClass from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($school_id,$id)
    {
        $schoolClass = $this->schoolClassRepository->findWithoutFail($id);

        if (empty($schoolClass)) {
            Flash::error('没有找到该信息');

            return redirect(route('schoolClasses.index'));
        }

        $this->schoolClassRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('schoolClasses.index',$school_id));
    }
}
