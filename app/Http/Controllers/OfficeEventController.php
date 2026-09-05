<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class OfficeEventController extends Controller
{
    // Folders inside public/ where the banner and the gallery files are kept
    private const IMAGE_DIR = 'uploads/events';
    private const MEDIA_DIR = 'uploads/events/media';

    private const VIDEO_EXT = ['mp4', 'webm', 'ogg', 'mov', 'avi', 'mkv', 'm4v'];

    // 📌 List events with search, filters, trash tab & pagination
    public function index(Request $request)
    {
        $trashed = $request->get('trashed') == 1 ? 1 : 0;

        $query = DB::table('tbl_office_event')
            ->select(
                'tbl_office_event.*',
                DB::raw('(select count(*) from tbl_office_event_media m
                          where m.eventId = tbl_office_event.uniqueId and m.isTrashed = 0) as mediaCount')
            )
            ->where('isTrashed', $trashed);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('eventTitle', 'like', '%' . $search . '%')
                    ->orWhere('eventVenue', 'like', '%' . $search . '%')
                    ->orWhere('employeeName', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('eventType')) {
            $query->where('eventType', $request->eventType);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', (int) $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('eventDate', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('eventDate', '<=', $request->to_date);
        }

        $events = $query->orderBy('eventDate', 'desc')
            ->orderBy('uniqueId', 'desc')
            ->paginate(10)
            ->withQueryString();

        $eventTypes = $this->eventTypes();
        $trashCount = DB::table('tbl_office_event')->where('isTrashed', 1)->count();

        return view('events.index', compact('events', 'eventTypes', 'trashed', 'trashCount'));
    }

    // 📌 Show Create Event Form
    public function create()
    {
        return view('events.create', ['eventTypes' => $this->eventTypes()]);
    }

    // 📌 Store Event + gallery media
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        try {
            $eventImage = null;
            if ($request->hasFile('eventImage')) {
                $eventImage = $this->uploadFile($request->file('eventImage'), self::IMAGE_DIR);
            }

            $eventId = DB::table('tbl_office_event')->insertGetId([
                'eventTitle'       => $data['eventTitle'],
                'eventSlug'        => $this->makeSlug($data['eventSlug'] ?? null, $data['eventTitle']),
                'eventType'        => $data['eventType'],
                'eventDate'        => $data['eventDate'],
                'eventEndDate'     => $data['eventEndDate'] ?? null,
                'eventTime'        => $data['eventTime'] ?? null,
                'eventVenue'       => $data['eventVenue'] ?? null,
                'employeeName'     => $data['employeeName'] ?? null,
                'eventImage'       => $eventImage,
                'driveUrl'         => $data['driveUrl'] ?? null,
                'eventDescription' => $data['eventDescription'] ?? null,
                'isHoliday'        => $request->boolean('isHoliday') ? 1 : 0,
                'isRecurring'      => $request->boolean('isRecurring') ? 1 : 0,
                'priority'         => $data['priority'] ?? null,
                'status'           => (int) $data['status'],
                'createdOn'        => time(),
                'createdBy'        => auth()->id(),
                'isTrashed'        => 0,
            ]);

            $this->saveMedia($request, $eventId);

            return redirect()->route('events.index')->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('events.create')
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // 📌 Show Edit Form
    public function edit($id)
    {
        $eventId = $this->decryptId($id);
        if ($eventId === null) {
            return redirect()->route('events.index')->with('error', 'Invalid event ID.');
        }

        $event = DB::table('tbl_office_event')->where('uniqueId', $eventId)->first();
        if (!$event) {
            return redirect()->route('events.index')->with('error', 'Event not found.');
        }

        $media = DB::table('tbl_office_event_media')
            ->where('eventId', $eventId)
            ->where('isTrashed', 0)
            ->orderByRaw('priority is null, priority asc')
            ->orderBy('uniqueId', 'asc')
            ->get();

        return view('events.edit', [
            'event'      => $event,
            'media'      => $media,
            'id'         => $id,
            'eventTypes' => $this->eventTypes(),
        ]);
    }

    // 📌 Update Event
    public function update(Request $request, $id)
    {
        $eventId = $this->decryptId($id);
        if ($eventId === null) {
            return redirect()->route('events.index')->with('error', 'Invalid event ID.');
        }

        $event = DB::table('tbl_office_event')->where('uniqueId', $eventId)->first();
        if (!$event) {
            return redirect()->route('events.index')->with('error', 'Event not found.');
        }

        $data = $request->validate($this->rules());

        try {
            $eventImage = $event->eventImage;
            if ($request->hasFile('eventImage')) {
                $eventImage = $this->uploadFile($request->file('eventImage'), self::IMAGE_DIR);
                $this->deleteFile($event->eventImage);
            } elseif ($request->boolean('remove_event_image')) {
                $this->deleteFile($event->eventImage);
                $eventImage = null;
            }

            DB::table('tbl_office_event')->where('uniqueId', $eventId)->update([
                'eventTitle'       => $data['eventTitle'],
                'eventSlug'        => $this->makeSlug($data['eventSlug'] ?? null, $data['eventTitle'], $eventId),
                'eventType'        => $data['eventType'],
                'eventDate'        => $data['eventDate'],
                'eventEndDate'     => $data['eventEndDate'] ?? null,
                'eventTime'        => $data['eventTime'] ?? null,
                'eventVenue'       => $data['eventVenue'] ?? null,
                'employeeName'     => $data['employeeName'] ?? null,
                'eventImage'       => $eventImage,
                'driveUrl'         => $data['driveUrl'] ?? null,
                'eventDescription' => $data['eventDescription'] ?? null,
                'isHoliday'        => $request->boolean('isHoliday') ? 1 : 0,
                'isRecurring'      => $request->boolean('isRecurring') ? 1 : 0,
                'priority'         => $data['priority'] ?? null,
                'status'           => (int) $data['status'],
                'updatedOn'        => time(),
                'updatedBy'        => auth()->id(),
            ]);

            $this->saveMedia($request, $eventId);

            return redirect()->route('events.index')->with('success', 'Event updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('events.edit', $id)
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // 📌 Toggle Active / Inactive straight from the list
    public function toggleStatus(Request $request, $id)
    {
        $eventId = $this->decryptId($id);
        if ($eventId === null) {
            return back()->with('error', 'Invalid event ID.');
        }

        $event = DB::table('tbl_office_event')->where('uniqueId', $eventId)->first();
        if (!$event) {
            return back()->with('error', 'Event not found.');
        }

        $newStatus = (int) $event->status === 1 ? 0 : 1;

        DB::table('tbl_office_event')->where('uniqueId', $eventId)->update([
            'status'    => $newStatus,
            'updatedOn' => time(),
            'updatedBy' => auth()->id(),
        ]);

        $message = $newStatus === 1
            ? 'Event activated successfully.'
            : 'Event deactivated successfully.';

        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $newStatus, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    // 📌 Move Event to trash (soft delete, its media goes with it)
    public function destroy($id)
    {
        $eventId = $this->decryptId($id);
        if ($eventId === null) {
            return redirect()->route('events.index')->with('error', 'Invalid event ID.');
        }

        $event = DB::table('tbl_office_event')->where('uniqueId', $eventId)->first();
        if (!$event) {
            return redirect()->route('events.index')->with('error', 'Event not found.');
        }

        DB::table('tbl_office_event')->where('uniqueId', $eventId)->update([
            'isTrashed' => 1,
            'TrashedOn' => time(),
            'status'    => 0,
            'updatedOn' => time(),
            'updatedBy' => auth()->id(),
        ]);

        DB::table('tbl_office_event_media')->where('eventId', $eventId)->update([
            'isTrashed' => 1,
            'TrashedOn' => time(),
        ]);

        return redirect()->route('events.index')->with('success', 'Event moved to trash.');
    }

    // 📌 Restore an event from trash
    public function restore($id)
    {
        $eventId = $this->decryptId($id);
        if ($eventId === null) {
            return redirect()->route('events.index')->with('error', 'Invalid event ID.');
        }

        DB::table('tbl_office_event')->where('uniqueId', $eventId)->update([
            'isTrashed' => 0,
            'TrashedOn' => null,
            'updatedOn' => time(),
            'updatedBy' => auth()->id(),
        ]);

        DB::table('tbl_office_event_media')->where('eventId', $eventId)->update([
            'isTrashed' => 0,
            'TrashedOn' => null,
        ]);

        return redirect()->route('events.index', ['trashed' => 1])
            ->with('success', 'Event restored successfully.');
    }

    // 📌 Permanently remove a trashed event along with its files
    public function forceDelete($id)
    {
        $eventId = $this->decryptId($id);
        if ($eventId === null) {
            return redirect()->route('events.index')->with('error', 'Invalid event ID.');
        }

        $event = DB::table('tbl_office_event')->where('uniqueId', $eventId)->first();
        if (!$event) {
            return redirect()->route('events.index')->with('error', 'Event not found.');
        }

        $media = DB::table('tbl_office_event_media')->where('eventId', $eventId)->get();
        foreach ($media as $item) {
            $this->deleteFile($item->mediaPath);
            $this->deleteFile($item->mediaThumb);
        }

        DB::table('tbl_office_event_media')->where('eventId', $eventId)->delete();
        $this->deleteFile($event->eventImage);
        DB::table('tbl_office_event')->where('uniqueId', $eventId)->delete();

        return redirect()->route('events.index', ['trashed' => 1])
            ->with('success', 'Event deleted permanently.');
    }

    // 📌 Remove a single gallery item from the edit screen
    public function destroyMedia($id)
    {
        $mediaId = $this->decryptId($id);
        if ($mediaId === null) {
            return back()->with('error', 'Invalid media ID.');
        }

        $item = DB::table('tbl_office_event_media')->where('uniqueId', $mediaId)->first();
        if (!$item) {
            return back()->with('error', 'Media not found.');
        }

        $this->deleteFile($item->mediaPath);
        $this->deleteFile($item->mediaThumb);
        DB::table('tbl_office_event_media')->where('uniqueId', $mediaId)->delete();

        return back()->with('success', 'Media removed successfully.');
    }

    /* -----------------------------------------------------------------
     |  Helpers
     | -----------------------------------------------------------------
     */

    private function eventTypes()
    {
        return [
            'event'       => 'Event',
            'holiday'     => 'Holiday',
            'festival'    => 'Festival',
            'birthday'    => 'Birthday',
            'anniversary' => 'Work Anniversary',
            'celebration' => 'Celebration',
            'meeting'     => 'Meeting',
            'training'    => 'Training',
            'achievement' => 'Achievement',
        ];
    }

    private function rules()
    {
        return [
            'eventTitle'           => 'required|string|max:256',
            'eventSlug'            => 'nullable|string|max:256',
            'eventType'            => 'required|string|max:50',
            'eventDate'            => 'required|date',
            'eventEndDate'         => 'nullable|date|after_or_equal:eventDate',
            'eventTime'            => 'nullable|string|max:50',
            'eventVenue'           => 'nullable|string|max:256',
            'employeeName'         => 'nullable|string|max:256',
            'eventDescription'     => 'nullable|string',
            'driveUrl'             => 'nullable|url|max:512',
            'priority'             => 'nullable|integer|min:0',
            'status'               => 'required|in:0,1',
            'eventImage'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'media_files'          => 'nullable|array',
            'media_files.*'        => 'file|mimes:jpeg,png,jpg,gif,webp,mp4,webm,mov|max:20480',
            'media_link_url'       => 'nullable|array',
            'media_link_url.*'     => 'nullable|url|max:512',
            'media_link_type'      => 'nullable|array',
            'media_link_type.*'    => 'nullable|in:image,video',
            'media_link_caption'   => 'nullable|array',
            'media_link_caption.*' => 'nullable|string|max:256',
        ];
    }

    private function decryptId($id)
    {
        try {
            return (int) Crypt::decryptString($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    // Keeps eventSlug unique so the public site can resolve an event by its slug
    private function makeSlug($slug, $title, $ignoreId = null)
    {
        $base = Str::slug($slug ?: $title);
        if ($base === '') {
            $base = 'event';
        }

        $candidate = $base;
        $suffix = 1;

        while (true) {
            $exists = DB::table('tbl_office_event')->where('eventSlug', $candidate);
            if ($ignoreId) {
                $exists->where('uniqueId', '!=', $ignoreId);
            }

            if (!$exists->exists()) {
                return $candidate;
            }

            $candidate = $base . '-' . (++$suffix);
        }
    }

    // Moves an upload into public/<dir> and returns the web-relative path
    private function uploadFile($file, $dir)
    {
        $destination = public_path($dir);
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $name = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($destination, $name);

        return $dir . '/' . $name;
    }

    private function deleteFile($path)
    {
        // Only local uploads live on disk; external links have nothing to remove
        if (!$path || Str::startsWith($path, ['http://', 'https://'])) {
            return;
        }

        $full = public_path($path);
        if (file_exists($full) && is_file($full)) {
            @unlink($full);
        }
    }

    // Stores uploaded gallery files and external links (Drive / YouTube / direct url)
    private function saveMedia(Request $request, $eventId)
    {
        $rows = [];
        $now = time();
        $userId = auth()->id();

        foreach ((array) $request->file('media_files', []) as $file) {
            if (!$file) {
                continue;
            }

            $ext = strtolower($file->getClientOriginalExtension());
            $rows[] = [
                'eventId'      => $eventId,
                'mediaType'    => in_array($ext, self::VIDEO_EXT, true) ? 'video' : 'image',
                'mediaPath'    => $this->uploadFile($file, self::MEDIA_DIR),
                'mediaThumb'   => null,
                'mediaCaption' => null,
                'priority'     => null,
                'status'       => 1,
                'createdOn'    => $now,
                'createdBy'    => $userId,
                'isTrashed'    => 0,
            ];
        }

        $urls     = (array) $request->input('media_link_url', []);
        $types    = (array) $request->input('media_link_type', []);
        $captions = (array) $request->input('media_link_caption', []);

        foreach ($urls as $i => $url) {
            $url = trim((string) $url);
            if ($url === '') {
                continue;
            }

            $caption = isset($captions[$i]) ? trim((string) $captions[$i]) : '';

            $rows[] = [
                'eventId'      => $eventId,
                'mediaType'    => (($types[$i] ?? 'image') === 'video') ? 'video' : 'image',
                'mediaPath'    => $url,
                'mediaThumb'   => null,
                'mediaCaption' => $caption !== '' ? $caption : null,
                'priority'     => null,
                'status'       => 1,
                'createdOn'    => $now,
                'createdBy'    => $userId,
                'isTrashed'    => 0,
            ];
        }

        if ($rows) {
            DB::table('tbl_office_event_media')->insert($rows);
        }
    }
}
