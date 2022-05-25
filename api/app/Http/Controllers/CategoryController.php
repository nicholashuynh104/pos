<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = new Category;

        return response()->json([
            'totalCategory' => $categories->count(),
            'categories' => $categories->all()
        ]);
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
        $validation = Validator::make($request->all(),[
            'name' => ['required','string','max:20','min:5','unique:categories'],
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }
        $filename = $request->image ? $request->file('image')->store('category','public') : '';
        $result = Category::create([
            'name' => $request->name,
            'image' => $filename,
        ]);
        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Added Category Successfully',
                'category' => $result
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'error'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        if (!$category) {
            return response()->json(['message' => 'category not found']);
        }

        return response()->json($category);
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
        $category = Category::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'name' => [
                'required', 'string', 'max:20', 'min:3', 'unique:categories'
            ]
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        } else {
            $category->name = $request->name;
            if ($request->image && $request->image != $category->image) {
                Storage::delete($category->image);
                $category->image = $request->file('image')->store('category','public') ?: '';
            } else if (!$request->image){
                Storage::delete($category->image);
                $category->image = '';
            }
            $result = $category->save();
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category Updated Successfully'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Some Problem'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = Category::findOrFail($id)->delete();
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category Deleted Successfully'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Some Problem'
            ]);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Active or Deactive for category
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($id)
    {
        try {
            $result = Category::findOrFail($id);
            $result->status = !$result->status;
            $result->save();
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category Status Changed Successfully',
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Some Problem'
            ]);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
