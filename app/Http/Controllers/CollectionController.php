<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Log;
use Str;

class CollectionController extends Controller
{
    private function generateItemDataFromId( string $id ) {
        return [
            'id' => $id, 
            'name' => "dpj-sip-aip_{$id}.tar", 
            'aip_id' => "aip-uuid-for-{$id}",
            'original_id' => "sip-uuid-for-{$id}"
        ];
    }

    private function generateItemDataFromAipUuid( string $aip_uuid ) {
        $id = Str::after($aip_uuid, 'aip-uuid-for-');
        return [
            'id' => $id,
            'name' => "dpj-sip-aip_{$id}.tar",
            'aip_id' => $aip_uuid,
            'original_id' => "sip-uuid-for-{$id}"
        ];
    }

    private function generateItemDataFromSipUuid( string $sip_uuid ) {
        $id = Str::after( $sip_uuid, 'sip-uuid-for-');
        return [
            'id' => $id,
            'name' => "dpj-sip-aip_{$id}.tar",
            'aip_id' => "aip-uuid-for-{$id}",
            'original_id' => $sip_uuid
        ];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('aip_id') ) {
            $itemData = $this->generateItemDataFromAipUuid( $request->aip_id );
            return response()->json( ['items' => [ $itemData ] ] );
        } else if ($request->has('original_id') ) {
            $itemData = $this->generateItemDataFromSipUuid( $request->original_id );
            return response()->json( ['items' => [ $itemData ] ] );
        }
        $items = [];
        for($i = 1; $i < 20; $i++) {
            array_push( $items,  $this->generateItemDataFromId( "{$i}" ) );
        }
        return response()->json( ["items" => $items ] );
    }

    public function download(string $id, Request $request)
    {
        $faker = Faker::create();
        $result = $faker->file("/home/kare/dummydata/aips", "/tmp/aipsourcefiles");
        $item = $this->generateItemDataFromId( $id );
        Log::info("Serving download for id {$id} as {$result}");
        return response()->download( $result, $item['name'] );    
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
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request) {
        return response()->json( $this->generateItemDataFromId( "{$id}" )  );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        //
    }
}
