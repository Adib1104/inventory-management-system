<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display booking list
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $bookings = Booking::with(['user', 'approver'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->when(!Auth::user()->isAdmin() && !Auth::user()->isStaff(), function ($q) {
                // Normal users see only their own bookings
                $q->where('user_id', Auth::id());
            })
            ->orderByDesc('requested_at')
            ->paginate(10);

        return view('bookings.index', compact('bookings', 'search'));
    }

    /**
     * Show booking form (User)
     */
    public function create()
    {
        $items = Item::orderBy('name')->get();
        return view('bookings.create', compact('items'));
    }

    /**
     * Store new booking (User)
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,item_id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            $booking = Booking::create([
                'user_id'      => Auth::id(),
                'status'       => 'pending',
                'requested_at' => now(),
            ]);

            foreach ($request->items as $row) {
                BookingItem::create([
                    'booking_id' => $booking->booking_id,
                    'item_id'    => $row['item_id'],
                    'quantity'   => $row['quantity'],
                ]);
            }
        });

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking submitted successfully.');
    }

    /**
     * View booking details
     */
    public function show($id)
    {
        $booking = Booking::with(['user', 'approver', 'items.item'])
            ->findOrFail($id);

        // Allow only owner, admin, or staff
        if (
            !Auth::user()->isAdmin() &&
            !Auth::user()->isStaff() &&
            $booking->user_id !== Auth::id()
        ) {
            abort(403, 'Unauthorized access to this booking.');
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Approve booking (Admin / Staff)
     */
    public function approve($id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isStaff()) {
            abort(403, 'Unauthorized.');
        }

        DB::transaction(function () use ($id) {

            $booking = Booking::with('items.item')->findOrFail($id);

            if ($booking->status !== 'pending') {
                abort(403, 'Booking already processed.');
            }

            // Check stock
            foreach ($booking->items as $row) {
                if ($row->item->quantity < $row->quantity) {
                    abort(400, 'Insufficient stock for item: ' . $row->item->name);
                }
            }

            // Deduct stock
            foreach ($booking->items as $row) {
                $row->item->decrement('quantity', $row->quantity);
            }

            $booking->update([
                'status'      => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);
        });

        return back()->with('success', 'Booking approved successfully.');
    }

    /**
     * Reject booking (Admin / Staff)
     */
    public function reject(Request $request, $id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isStaff()) {
            abort(403, 'Unauthorized.');
        }

        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'pending') {
            abort(403, 'Booking already processed.');
        }

        $booking->update([
            'status'      => 'rejected',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'remarks'     => $request->remarks,
        ]);

        return back()->with('success', 'Booking rejected.');
    }

    /**
     * Delete booking (Admin / Staff)
     */
    public function destroy($id)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isStaff()) {
            abort(403, 'Unauthorized.');
        }

        DB::transaction(function () use ($id) {

            $booking = Booking::with('items')->findOrFail($id);

            if ($booking->status === 'approved') {
                abort(403, 'Approved bookings cannot be deleted.');
            }

            $booking->items()->delete();
            $booking->delete();
        });

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}
