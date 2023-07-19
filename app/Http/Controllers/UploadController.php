<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCsvFile;
use App\Models\TempModel;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use League\Csv\Reader;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('upload');
    }



    public function processUpload(Request $request)
    {
        if ($request->hasFile('file')) {
            ini_set("memory_limit", "-1");
            set_time_limit(0);

            try {
                $file = $request->file('file');
                $storePath = $file->move(public_path('csv_upload'), 'test.csv');
                $reader = Reader::createFromPath(public_path('csv_upload') . "/test.csv", 'r');
                $records = $reader->getRecords();
                $dataToInsert = [];

                $counter = 0;
                foreach ($records as $record) {
                    if ($counter === 0) {
                        $counter++;
                        continue;
                    }

                    $dataToInsert[] = [
                        'sr_no' => $record[0],
                        'date' => null,
                        'academic_year' => $record[2],
                        'session' => $record[3],
                        'alloted_category' => $record[4],
                        'voucher_type' => $record[5],
                        'voucher_no' => $record[6],
                        'roll_no' => $record[7],
                        'admin_no_or_unique_id' => $record[8],
                        'status' => $record[9],
                        'feecategory' => $record[10],
                        'faculty' => $record[11],
                        'program' => $record[12],
                        'department' => $record[13],
                        'batch' => $record[14],
                        'receipt_no' => $record[15],
                        'feehead' => $record[16],
                        'dueamount' => $record[17],
                        'paidamount' => $record[18],
                        'concession_amount' => $record[19],
                        'scholarship_amount' => $record[20],
                        'reverse_concession_amount' => $record[21],
                        'write_off_amount' => $record[22],
                        'adjusted_amount' => $record[23],
                        'refund_amount' => $record[24],
                        'fund_transfer_amount' => $record[25],
                        'remarks' => $record[26],
                    ];
                }

                // Use Eloquent's insert method to insert multiple records in one go
                if (!empty($dataToInsert)) {
                    TempModel::insert($dataToInsert);
                }

                // Provide a response or redirect as needed
                return response()->json(['message' => 'Data has been imported successfully.']);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()]);
            }
        }

        // Handle the case when no file is uploaded
        return redirect()->back()->with('error', 'No CSV file uploaded.');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName); // Store the file in the "uploads" folder
            return response()->json(['success' => true, 'file_name' => $fileName]);
        }

        return response()->json(['success' => false, 'message' => 'File upload failed.']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
