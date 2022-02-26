<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Models\Order;
use App\Models\Table;
use App\Models\User;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::get();
        return view('table.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('table.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TableRequest $request)
    {
        // Ambil request
        $attr = $request->all();

        // Kalau memasukkan nomor tabel yang sama
        if (!empty(Table::where('id', $request->table_number)->get()->first())) {
            session()->flash('error', 'The seat already created');

            return redirect('/seat');
        }

        // Insert
        $table = Table::create([
            'id' => $request->table_number,
            'table_number' => $request->table_number
        ]);

        // Create user berdasarkan tabel
        $userTable = User::where('table_number', $request->table_number)->get()->first();

        // dd($userTable);

        if (empty($userTable)) {
            $user = User::create([
                'id' => $request->table_number,
                'name' => 'tempat duduk' . $request->table_number,
                'email' => 'seat' . $request->table_number . '@gmail.com',
                'password' => Hash::make('password'),
                'category' => 'tempat duduk',
                'table_number' => $request->table_number,
            ]);
            $user->assignRole('tempat duduk');
            event(new Registered($user));
        }

        session()->flash('success', 'The seat was created');

        return redirect('/seat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        return view('table.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(TableRequest $request, Table $table)
    {
        // Ambil request
        $attr = $request->all();

        // Kalau update dengan nomor tabel yang sudah ada
        if ($request->table_number !== $table->table_number) {
            if (!empty(Table::where('id', $request->table_number)->get()->first())) {
                session()->flash('error', 'The seat already created');
    
                return redirect('/seat');
            }
        }

        // Update
        $table->update([
            'id' => $request->table_number,
            'table_number' => $request->table_number,
        ]);

        // Create user berdasarkan tabel
        $userTable = User::where('table_number', $request->table_number)->get()->first();

        if (empty($userTable)) {
            $user = User::create([
                'id' => $request->table_number,
                'name' => 'tempat duduk' . $request->table_number,
                'email' => 'seat' . $request->table_number . '@gmail.com',
                'password' => Hash::make('password'),
                'category' => 'tempat duduk',
                'table_number' => $request->table_number,
            ]);
            $user->assignRole('tempat duduk');
            event(new Registered($user));
        }

        session()->flash('success', 'The seat was updated');

        return redirect('/seat');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        // Menghapus row
        $table->delete();

        // Mengirim session
        session()->flash('success', 'The table was destroyed');
        return redirect('/seat');
    }

    public function waiterIndex()
    {
        $tables = Table::all();
        return view('waiter.index', compact('tables'));
    }

    public function waiterCreate(Table $table)
    {
        return view('waiter.create', compact('table'));
    }

    public function waiterStore(Request $request, Table $table)
    {
        // validate request
        $request->validate([
            'customer_name' => 'required',
        ]);

        // update
        Table::where('id', $table->id)
            ->update([
                'customer_name' => $request->customer_name,
            ]);

        return redirect('/waiter');
    }

    public function dapurIndex()
    {
        return view('dapur.index');
    }
}
