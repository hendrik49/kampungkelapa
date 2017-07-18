<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MasterData;
use App\User;
use Illuminate\Http\Request;

class PageController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function masterdata()
	{
		$master_datas = User::orderBy('id', 'desc')->paginate(10);

		return view('page.master-data', compact('master_datas'));
	}

	public function installday()
	{
		$user = User::orderBy('id', 'desc')->paginate(10);

		return view('page.install.install-day', compact('user'));
	}

	public function installweek()
	{
		$user = User::orderBy('id', 'desc')->paginate(10);

		return view('page.install.install-week', compact('user'));
	}

	public function installyear()
	{
		$user = User::orderBy('id', 'desc')->paginate(10);

		return view('page.install.install-year', compact('user'));
	}

	public function clickday()
	{
		$master_datas = MasterData::orderBy('id', 'desc')->paginate(10);

		return view('page.click.click-day', compact('master_datas'));
	}

	public function viewday()
	{
		return view('page.view.view-day');
	}
}
