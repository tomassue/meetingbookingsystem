<?php

namespace App\Http\Livewire;

use App\Models\RefSignatoriesModel;
use App\Models\TblBookedMeetingsModel;
use App\Models\TblFileDataModel;
use App\Models\TblMeetingFeedbackModel;
use App\Models\TblMemoModel;
use App\Models\User;
use DateTime;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Request extends Component
{
    use WithFileUploads, WithPagination;

    # viewAttachedFileModal
    public $files, $previewFile, $title;

    # addMemoModal
    public $booking_no, $created_at_date, $attendees, $subject, $memo_message, $signatory;

    # generate memo
    public $pdfMemo;

    # tabs (multiple)
    public $tab = 'tab1'; //* I used wire:click="$set('property_name', 'value')" on this one.

    # search
    public $search;

    protected $rules = [
        'booking_no'   => 'required|unique:tbl_memo,id_booking_no',
        'memo_message' => 'required',
        'signatory'    => 'required',
    ];

    protected $messages = [
        'booking_no.unique' => 'Memo already exist!'
    ];

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        # Signatories
        $signatories = RefSignatoriesModel::select(
            'id',
            'honorifics',
            'full_name'
        )
            ->get();

        # Upcoming Meetings
        // $query = TblBookedMeetingsModel::select(
        //     'booking_no',
        //     DB::raw("DATE_FORMAT(start_date_time, '%c/%d/%Y %h:%i %p') AS start"),
        //     DB::raw("DATE_FORMAT(end_date_time, '%c/%d/%Y %h:%i %p') AS end"),
        //     'subject',
        //     'type_of_attendees',
        //     'id_file_data'
        // )
        //     ->whereNotExists(function ($query) {
        //         $query->select(DB::raw(1))
        //             ->from('tbl_memo')
        //             ->whereRaw('tbl_booked_meetings.booking_no = tbl_memo.id_booking_no');
        //     })
        //     ->whereExists(function ($query) {
        //         $query->select(DB::raw(1))
        //             ->from('tbl_attendees as a')
        //             ->leftJoin('tbl_meeting_feedback as f', function ($join) {
        //                 $join->on('a.id_booking_no', '=', 'f.id_booking_no')
        //                     ->on('a.id_users', '=', 'f.attendee');
        //             })
        //             ->whereRaw('a.id_booking_no = tbl_booked_meetings.booking_no')
        //             ->groupBy('a.id_booking_no')
        //             ->havingRaw('COUNT(a.id_users) = SUM(CASE WHEN f.attendee IS NOT NULL THEN 1 ELSE 0 END)');
        //     })
        //     ->where(function ($query) {
        //         $query->where('subject', 'like', '%' . $this->search . '%')
        //             ->orWhere('type_of_attendees', 'like', '%' . $this->search . '%');
        //     })
        //     ->orderBy('start_date_time', 'ASC');

        // $request = $query->paginate(10, ['*'], 'tab1');

        $query = TblBookedMeetingsModel::select(
            'booking_no',
            DB::raw("DATE_FORMAT(start_date_time, '%c/%d/%Y %h:%i %p') AS start"),
            DB::raw("DATE_FORMAT(end_date_time, '%c/%d/%Y %h:%i %p') AS end"),
            'subject',
            'type_of_attendees',
            'id_file_data'
        )
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tbl_memo')
                    ->whereRaw('tbl_booked_meetings.booking_no = tbl_memo.id_booking_no');
            })
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tbl_attendees as a')
                    ->leftJoin('tbl_meeting_feedback as f', function ($join) {
                        $join->on('a.id_booking_no', '=', 'f.id_booking_no')
                            ->on('a.id_users', '=', 'f.attendee')
                            ->where('f.meeting_status', '=', 1); // Added this condition where attendees with approved feedback will only be shown in the upcoming meeting tab.
                    })
                    ->whereRaw('a.id_booking_no = tbl_booked_meetings.booking_no')
                    ->groupBy('a.id_booking_no')
                    ->havingRaw('COUNT(a.id_users) = SUM(CASE WHEN f.attendee IS NOT NULL THEN 1 ELSE 0 END)');
            })
            ->where(function ($query) {
                $query->where('subject', 'like', '%' . $this->search . '%')
                    ->orWhere('type_of_attendees', 'like', '%' . $this->search . '%');
            })
            ->orderBy('start_date_time', 'ASC');

        $request = $query->paginate(10, ['*'], 'tab1');

        # With Memo
        $request2 = TblBookedMeetingsModel::rightJoin('tbl_memo', 'tbl_memo.id_booking_no', '=', 'tbl_booked_meetings.booking_no')
            ->select(
                'tbl_memo.id_booking_no',
                DB::raw("DATE_FORMAT(start_date_time, '%c/%d/%Y %h:%i %p') AS start"),
                DB::raw("DATE_FORMAT(end_date_time, '%c/%d/%Y %h:%i %p') AS end"),
                'subject',
                'type_of_attendees',
                'id_file_data'
            )
            ->where('subject', 'like', '%' . $this->search . '%')
            ->orWhere('type_of_attendees', 'like', '%' . $this->search . '%')
            ->paginate(10, ['*'], 'tab2');

        return view('livewire.request', [
            'request'   =>  $request,
            'request2'  =>  $request2,
            'signatories' => $signatories
        ]);
    }

    public function updated()
    {
        $this->resetPage('tab1');
        $this->resetPage('tab2');
    }

    public function clear()
    {
        $this->resetValidation();
        // $this->reset();
        $this->reset(['booking_no', 'created_at_date', 'attendees', 'subject', 'memo_message', 'signatory', 'pdfMemo']);
    }

    public function hideAttachedFileModal()
    {
        # booted() runs on every request, after the component is mounted or hydrated, but before any update methods are called
        $this->reset('files', 'previewFile');
    }

    public function viewAttachedFile($id)
    {
        if ($id) {
            # Explode the data into an array an loop them using foreach to look for it.
            $id_file_data = explode(',', $id);
            foreach ($id_file_data as $item) {
                $query = TblFileDataModel::where('id', $item)
                    ->select(
                        'id',
                        'file_name'
                    );
                $getfiles = $query->first();
                $this->files[] = $getfiles; # Data that were found from the loop, we store them in an array property. This way, we can display them in our blade using foreach.
            }
        }
    }

    public function previewAttachedFile($id)
    {
        $file = TblFileDataModel::findOrFail($id);
        $this->title = $file->file_name;
        $file_content = base64_encode($file['file_data']);
        $this->previewFile = $file_content;
    }

    public function memo($booking_no)
    {
        // dd($booking_no);
        $this->booking_no = $booking_no;
        $booked_meeting = TblBookedMeetingsModel::where('booking_no', $booking_no)->first();
        $this->created_at_date = (new DateTime($booked_meeting->created_at))->format('F d, Y');

        $one = TblMeetingFeedbackModel::join('users', 'tbl_meeting_feedback.attendee', '=', 'users.id')
            ->join('ref_departments', 'users.id_department', '=', 'ref_departments.id')
            ->where('tbl_meeting_feedback.id_booking_no', $booking_no)
            ->select(
                DB::raw("CONCAT(users.first_name, COALESCE(users.middle_name, ''), ' ',users.last_name, IF(TRIM(IFNULL(users.extension, '')) != '', CONCAT(', ', users.extension), '')) as full_name"),
                'users.sex',
                'ref_departments.department_name',
                'proxy'
            )
            ->get();
        foreach ($one as $item) {
            $this->attendees[] = $item;
        }
        $this->subject = $booked_meeting->subject;

        $this->emit('showaddMemoModal');
    }

    public function saveMemo()
    {
        $this->validate();
        TblMemoModel::create([
            'id_booking_no' =>  $this->booking_no,
            'message'       =>  base64_encode($this->memo_message),
            'id_ref_signatories'    =>  $this->signatory
        ]);
        $this->clear();
        session()->flash('success', 'Added a memo succesfully.');
        return redirect()->route('request');
    }

    public function generateMemo($key)
    {
        $query_attendees = TblMeetingFeedbackModel::join('users', 'users.id', '=', 'tbl_meeting_feedback.attendee')
            ->where('id_booking_no', $key)
            ->select(
                'tbl_meeting_feedback.proxy as proxy',
                'tbl_meeting_feedback.attendee',
                DB::raw("CONCAT(users.first_name, COALESCE(users.middle_name, ''), ' ',users.last_name, IF(users.extension IS NOT NULL, CONCAT(', ', users.extension), '')) as full_name")
            )
            ->get();
        foreach ($query_attendees as $item) {
            if ($item->proxy == NULL) {
                $attendee[] = $item->full_name;
            } elseif ($item->proxy !== NULL) {
                $attendee[] = $item->proxy;
            }
        }

        $memo = TblMemoModel::join('tbl_meeting_feedback', 'tbl_meeting_feedback.id_booking_no', '=', 'tbl_memo.id_booking_no')
            ->join('tbl_booked_meetings', 'tbl_booked_meetings.booking_no', '=', 'tbl_memo.id_booking_no')
            ->join('ref_signatories', 'ref_signatories.id', '=', 'tbl_memo.id_ref_signatories')
            ->where('tbl_memo.id_booking_no', $key)
            ->select(
                'tbl_memo.id_booking_no',
                'tbl_booked_meetings.subject',
                'tbl_memo.message',
                DB::raw("CONCAT(ref_signatories.honorifics, ' ', ref_signatories.full_name) AS signatory"),
                'ref_signatories.signature',
                'ref_signatories.title',
                DB::raw("DATE_FORMAT(tbl_memo.created_at, '%e %b %Y') AS formatted_created_at")
            )
            ->first();

        $data = [
            'css'   =>  file_get_contents(public_path() . '/theme/vendor/bootstrap/css/bootstrap.min.css'), # When using domPDF, most of the CSS aren't compatible so, what I did, since I'm using summernote and it uses bootstrap classes, I manually added an internal css where when there's a table tag, styles for tables are set automatically because of the css I manually set in the header tag.
            'attendee' => $attendee,
            'memo' => $memo,
            'id' => $key,
            'cdo_logo' =>  base64_encode(file_get_contents(public_path('images/cdo-seal.png'))),
            'headergoldencdologo' => base64_encode(file_get_contents(public_path('images/headergoldencdologo.png'))),
            'riselogo'  =>  base64_encode(file_get_contents(public_path('images/rise.png')))
        ];

        // Load HTML content from another Blade file
        $htmlContent = view('livewire.generate-pdf.pdf-memo', $data)->render();
        $dompdfMemo = new Dompdf();
        $dompdfMemo->loadHtml($htmlContent);
        $dompdfMemo->render();

        $this->pdfMemo = 'data:application/pdf;base64,' . base64_encode($dompdfMemo->output());
    }
}
