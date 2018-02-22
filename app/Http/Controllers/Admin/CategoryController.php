<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$categories = PostCategory::all();

        $categories = PostCategory::where('parent_id', '=', 0)->get();
        $allCategories = PostCategory::pluck('name','id')->all();

        $params = [
            'title'         => 'DANH MỤC BÀI VIẾT - MIBLOG',
            'categories'    => $categories,
            'js'            => 'js.postcategory-js',
            'allCategories' => $allCategories
        ];
        //return view('categoryTreeview',compact('categories','allCategories'));

        return view('admin.postcategory')->with($params);
    }

    function action(){
        $input  = request()->all();
        $action = "";
        if($input!=null){
            $action = $input['action'];
        }
    
        switch ($action) {
            case 'add':
                $params = [
                    'title' => 'Create Post Category',
                ];
                //print_r($params);
                return view('components.postcategory.add_modal')->with($params);
                break;
            
            default:
                # code...
                break;
        }

        //return response()->json(['success'=>'Got Simple Ajax Request.']);;

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCategory(Request $request)
    {
        $this->validate($request, [
        		'name' => 'required',
        	]);
        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        
        PostCategory::create($input);
        return back()->with('success', 'New Category added successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $params = [
            'title' => 'Create Product Category',
        ];
        $attributes = [
            'name'  => 'Main'
        ];
        //PostCategory::create($attributes); // Saved as root
        $node = new Category($attributes);
        //$node1 = new Category($attributes);
        print_r($node);
        //$node->save(); // Saved as root

        //$data = PostCategory::getNodeData(3);
        //print_r($node);
        //print_r($node->getNodeData(1));
        //$root = PostCategory::root();
        $node = new PostCategory([ 'name' => 'test' ]);
        //$node1->prependNode($node);
        $node1->appendNode($node);
        print_r($node1);

        //$node->appendToNode($parent)->save();
        //print_r($attributes);

        //return view('components.postcategory.add_modal')->with($params);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
            'description' => 'required',
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('product-categories.index')->with('success', "The product category <strong>$category->name</strong> has successfully been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $category = Category::findOrFail($id);

            $params = [
                'title' => 'Edit Product Category',
                'category' => $category,
            ];

            return view('admin.categories.categories_delete')->with($params);
        }
        catch (ModelNotFoundException $ex) 
        {
            if ($ex instanceof ModelNotFoundException)
            {
                return response()->view('errors.'.'404');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $category = Category::findOrFail($id);

            $params = [
                'title' => 'Edit Product Category',
                'category' => $category,
            ];

            return view('admin.categories.categories_edit')->with($params);
        }
        catch (ModelNotFoundException $ex) 
        {
            if ($ex instanceof ModelNotFoundException)
            {
                return response()->view('errors.'.'404');
            }
        }
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
        try
        {
            $this->validate($request, [
                'name' => 'required|unique:categories,name,'.$id,
                'description' => 'required',
            ]);

            $category = Category::findOrFail($id);

            $category->name = $request->input('name');
            $category->description = $request->input('description');

            $category->save();

            return redirect()->route('product-categories.index')->with('success', "The product category <strong>Category</strong> has successfully been updated.");
        }
        catch (ModelNotFoundException $ex) 
        {
            if ($ex instanceof ModelNotFoundException)
            {
                return response()->view('errors.'.'404');
            }
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
        try
        {
            $category = Category::findOrFail($id);

            $category->delete();

            return redirect()->route('product-categories.index')->with('success', "The product category <strong>Category</strong> has successfully been archived.");
        }
        catch (ModelNotFoundException $ex) 
        {
            if ($ex instanceof ModelNotFoundException)
            {
                return response()->view('errors.'.'404');
            }
        }
    }
}
