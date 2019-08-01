<?php

namespace App\Http\Controllers;

use App\Http\Resources\Item as ItemResource;
use App\Item;
use Illuminate\Http\Request;
use Validator;

class ItemController extends Controller
{

    public function list()
    {
        $items = Item::orderBy('id', 'desc')->take(10)->paginate(10);
        return ItemResource::collection($items);
    }

    public function item($id)
    {
        $item = Item::find($id);

        if (is_null($item)) {
            // item not found
            return response()->json('Item not found', 404);
        } else {
            // show item
            return new ItemResource($item);
        }
    }

    public function create(Request $request)
    {
        $validation = [
            'name' => 'required|string|min:3|max:255',
            'weight' => 'required|string|min:3|max:255',
            'size' => 'required|string|min:3|max:255',
        ];
        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            // validation failed
            return response()->json($validator->errors(), 400);
        } else {
            // validation success
            $item = new Item;
            $item->name = $request->input('name');
            $item->weight = $request->input('weight');
            $item->size = $request->input('size');

            if ($item->save()) {
                // success
                return response()->json(['message' => 'Item saved'], 200);
            } else {
                // failed
                return response()->json(['message' => 'Something went wrong. Please try againg'], 500);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (is_null($item)) {
            // item not found
            return response()->json(['message' => 'Item not found'], 404);
        } else {
            // item found
            $validation = [
                'name' => 'required|string|min:3|max:255',
                'weight' => 'required|string|min:3|max:255',
                'size' => 'required|string|min:3|max:255',
            ];
            $validator = Validator::make($request->all(), $validation);

            if ($validator->fails()) {
                // validation failed
                return response()->json($validator->errors(), 400);
            } else {
                // validation success
                $item->name = $request->input('name');
                $item->weight = $request->input('weight');
                $item->size = $request->input('size');

                if ($item->update()) {
                    // success
                    return response()->json(['message' => 'Item updated'], 200);
                } else {
                    // failed
                    return response()->json(['message' => 'Something went wron. Please try againg'], 500);
                }
            }
        }
    }

    public function delete($id)
    {
        $item = Item::find($id);

        if (is_null($item)) {
            // item not found
            return response()->json(['message' => 'Item not found'], 404);
        } else {
            // item found
            if ($item->delete()) {
                // success
                return response()->json(['message' => 'Item deleted'], 200);
            } else {
                // failed
                return response()->json(['message' => 'Something went wrong. Please try again'], 500);
            }
        }
    }
}
