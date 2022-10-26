<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Ticketcategory;
use App\Models\Ticketcomment;
use App\Models\Ticket;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
	public function __construct()
	{

		$this->middleware('auth');
	}
	public function index()
	{
		// if user has not 2fa verifies
		if (!auth()->user()->enabled_2fs()) {
			return redirect()->route('show2faForm', app()->getLocale());
		}
		if (Auth::user()->currentWallet() == null) {
			return redirect(route('show.currencies', app()->getLocale()));
		}
		$tickets = Ticket::paginate(10);
		$categories = Ticketcategory::all();

		return view('tickets.index', compact('tickets', 'categories'));
	}

	public function create()
	{
		if (Auth::user()->currentWallet() == null) {
			return redirect(route('show.currencies', app()->getLocale()));
		}
		$categories = Ticketcategory::all();

		return view('tickets.create', compact('categories'));
	}

	public function store(Request $request, $lang, AppMailer $mailer)
	{
		if (Auth::user()->currentWallet() == null) {
			return redirect(route('show.currencies', app()->getLocale()));
		}
		$this->validate($request, [
			'title'     => 'required',
			'category'  => 'required',
			'priority'  => 'required',
			'message'   => 'required'
		]);

		$ticket = new Ticket([
			'title'     => $request->input('title'),
			'user_id'   => Auth::user()->id,
			'ticket_id' => strtoupper(str_random(10)),
			'ticketcategory_id'  => $request->input('category'),
			'priority'  => $request->input('priority'),
			'message'   => $request->input('message'),
			'status'    => "Open",
		]);

		$ticket->save();

		$mailer->sendTicketInformation(Auth::user(), $ticket);

		flash("A ticket with ID: #$ticket->ticket_id has been opened.", "success");

		return redirect('my_tickets');
	}

	public function userTickets()
	{
		if (Auth::user()->currentWallet() == null) {
			return redirect(route('show.currencies', app()->getLocale()));
		}
		$tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
		$categories = Ticketcategory::all();

		return view('tickets.user_tickets', compact('tickets', 'categories'));
	}

	public function show($ticket_id)
	{
		if (Auth::user()->currentWallet() == null) {
			return redirect(route('show.currencies', app()->getLocale()));
		}

		$ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

		$comments = $ticket->comments;

		$category = $ticket->category;

		return view('tickets.show', compact('ticket', 'category', 'comments'));
	}

	public function close($ticket_id, AppMailer $mailer)
	{
		$ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

		$ticket->status = 'Closed';

		$ticket->save();

		$ticketOwner = $ticket->user;

		$mailer->sendTicketStatusNotification($ticketOwner, $ticket);

		return redirect()->back()->with("status", "The ticket has been closed.");
	}
}
