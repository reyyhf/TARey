<?php

namespace App\Http\Services\Scheduling;

use App\Helpers\ApiResponseTrait;
use App\Models\Scheduling\ScheduleReport;
use Illuminate\Support\Facades\Auth;

class ScheduleReportService
{
  use ApiResponseTrait;

  public function index()
  {
    $reports = ScheduleReport::all()->toArray();

    foreach ($reports as &$report) {
      $report['data'] = json_decode($report['data']);
    }

    return $this->resultResponse('success', 'Data berhasil ditampilkan', 200, $reports);
  }

  public function show($id)
  {
    $report = ScheduleReport::where('id', $id)->first();
    $report['data'] = json_decode($report['data']);

    return $this->resultResponse('success', 'Data berhasil ditampilkan', 200, $report);
  }

  public function store($inputData)
  {
    $report = ScheduleReport::create(
      [
        'title' => $inputData['title'],
        'data' => $inputData['data'],
        'reported_by' => Auth::user()->id
      ]
    );

    return $this->resultResponse('success', 'Data berhasil ditambahkan', 200, $report);
  }

  public function destroy($id)
  {
    $report = ScheduleReport::find($id);
    $report->delete();

    return $this->resultResponse('success', 'Data berhasil dihapus', 200, $report);
  }
}
