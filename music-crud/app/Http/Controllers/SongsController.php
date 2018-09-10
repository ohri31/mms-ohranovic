<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Song;
use Illuminate\Http\Request;

class SongsController extends Controller
{
    public function __construct() 
    {
        $this->middleware('cors');
    }


    public function redirect() {
        return redirect('/songs');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $songs = Song::where('title', 'LIKE', "%$keyword%")
                ->orWhere('artist', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $songs = Song::latest()->paginate($perPage);
        }

        return view('songs.index', compact('songs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('songs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {   
        $data = $request->all();
        
        // upload song
        $file = $request->file('song');
        $file->move('upload/songs', $file->getClientOriginalName());
        
        $data['song_src'] = url('upload/songs/'.$file->getClientOriginalName());

        // upload image 
        $file = $request->file('image');
        $file->move('upload/images', $file->getClientOriginalName());

        $data['image_src'] = url('upload/images/'.$file->getClientOriginalName());

        Song::create($data);

        return redirect('songs')->with('flash_message', 'Song added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $song = Song::findOrFail($id);

        return view('songs.show', compact('song'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $song = Song::findOrFail($id);

        return view('songs.edit', compact('song'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $song = Song::findOrFail($id);
        $song->update($requestData);

        return redirect('songs')->with('flash_message', 'Song updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Song::destroy($id);

        return redirect('songs')->with('flash_message', 'Song deleted!');
    }

    /**
     * List all 
     */
    public function listAll() 
    {
        // fetch all songs
        $songs = Song::all();

        // initilize the data 
        $data = [];

        // prepare thed data 
        foreach($songs as $key => $item) {
            $data[$key]['url'] = $item['song_src'];
            $data[$key]['cover'] = $item['image_src'];
            $data[$key]['artist'] = [
                'name' => $item['artist'],
                'song' => $item['title']
            ];
        }

        return response()->json($data, 200);
    }
}
