<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PostCategory;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kalnoy\Nestedset\NestedSet;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public $f;
    public function index()
    {
        $categories = PostCategory::all();
        foreach ($categories as $key => $value) {
            $parent_cate = PostCategory::find($value->parent_id);
            $value->parent_cate = count($parent_cate) ? trim($parent_cate->name) : 'Thư mục gốc';

        }

        $tree = PostCategory::descendantsOf(1)->toTree(1);
        $params = [
            'title'         => 'DANH MỤC BÀI VIẾT - MIBLOG',
            'categories'    => $categories,
            'js'            => 'js.postcategory-js'
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
                $output = $this->output();
                $params = [
                    'title' => 'Thêm mới danh mục',
                    'output'    => $output
                ];
                return view('components.postcategory.add_modal')->with($params);
                break;

            case 'edit':
                $id = $input['id'];
                $info = PostCategory::find($id);
                $output2 = $this->output2($id);
                $params = [
                    'title' => 'Sửa danh mục',
                    'output2'    => $output2,
                    'info'  => $info
                ];
                return view('components.postcategory.edit_modal')->with($params);
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
    public function create(Request $input)
    {
        $errors  = array('error' => 0);
        $name               = isset($_POST['name']) ? trim($_POST['name']) : '';
        $parent             = isset($_POST['parent']) ? trim($_POST['parent']) : 0;
        $description        = isset($_POST['description']) ? trim($_POST['description']) : '';
        $slug               = isset($_POST['slug']) ? trim($_POST['slug']) : '';
        $valid              = isset($_POST['valid']) ? trim($_POST['valid']) : '';
        if (empty($name)){ $errors['name'] = 'Xin nhập tên danh mục';}
        if (empty($slug)){ $errors['slug'] = 'Slug không được trống';}

        $query = $this->findCategory($name);
        if(count($query)){
            $errors['name'] = 'Tên danh mục đã tồn tại';
        }
        if (PostCategory::where('slug', '=', $slug)->exists()) {
            $errors['slug'] = 'slug đã tồn tại';
        }

        if (count($errors) > 1){
            $errors['error'] = 1;
            return response()->json($errors);
        }

        if($parent == 0){
            $node = new PostCategory($attributes= array('name'=>$name,'parent_id'=>0,'description'=>$description,'slug'=>$slug,'valid'=>$valid));
            $node->save(); // Saved as root
        }else{
            $node = new PostCategory($attributes= array('name'=>$name,'parent_id'=>$parent,'description'=>$description,'slug'=>$slug,'valid'=>$valid));
            $parent = PostCategory::get()->find($parent);
            $node->appendToNode($parent)->save();
        }
        return response()->json($errors);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $errors  = array('error' => 0);
        $id                 = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $name               = isset($_POST['name']) ? trim($_POST['name']) : '';
        $parent             = isset($_POST['parent']) ? intval($_POST['parent']) : 0;
        $description        = isset($_POST['description']) ? trim($_POST['description']) : '';
        $slug               = isset($_POST['slug']) ? trim($_POST['slug']) : '';
        $valid              = isset($_POST['valid']) ? trim($_POST['valid']) : '';

        //check null
        if (empty($name)){ $errors['name'] = 'Xin nhập tên danh mục';}
        if (empty($slug)){ $errors['slug'] = 'Slug không được trống';}

        if (count($errors) > 1){
            $errors['error'] = 1;
            return response()->json($errors);
        }

        $id = intval($id);
        // check duplicate name
        $info = PostCategory::find($id);
        if(strtolower($name) != strtolower($info->name)){
            $query = $this->findCategory($name);
            if(count($query)){
                $errors['name'] = 'Tên danh mục đã tồn tại';
            }

            if (PostCategory::where('slug', '=', $slug)->exists()) {
                $errors['slug'] = 'slug đã tồn tại';
            }

            if (count($errors) > 1){
                $errors['error'] = 1;
                return response()->json($errors);
            }
        }

        if($parent == 0){
            //print_r('OK');
            //$node = PostCategory::get()->find($id);
            $node = PostCategory::findOrFail($id);
            $node->name = $name;
            $node->description = $description;
            $node->slug = $slug;
            $node->valid = $valid;

            $node->saveAsRoot(); // Saved as root
        }else{
            $node = PostCategory::findOrFail($id);
            $node->name = $name;
            $node->description = $description;
            $node->slug = $slug;
            $node->valid = $valid;

            $parent = PostCategory::get()->find($parent);
            $node->appendToNode($parent)->save();
        }
        return response()->json($errors);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $errors  = array('error' => 0);
        if ($_POST['id']) {
            
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            try
            {
                $category = PostCategory::findOrFail($id);
    
                $category->delete();
    
                //return redirect()->route('product-categories.index')->with('success', "The product category <strong>Category</strong> has successfully been archived.");
            }
            catch (ModelNotFoundException $ex) 
            {
                if ($ex instanceof ModelNotFoundException)
                {
                    $errors['errors'] = 1;
                }
            }
            return response()->json($errors);
        }
    }

    
    public function makeOptions(Collection $items)
    {
        $options = [ '' => 'Root' ];
        foreach ($items as $item)
        {
            $options[$item->getKey()] = str_repeat('‒', $item->depth + 1).' '.$item->title;
        }
        return $options;
    }

    function getCategoryOptions($except = null)
	{
		/** @var \Kalnoy\Nestedset\QueryBuilder $query */
		$query = PostCategory::select('id', 'name')->withDepth();
		if ($except)
		{
			$query->whereNotDescendantOf($except)->where('id', '<>', $except->id);
		}
		return $this->makeOptions($query->get());
    }
    
    function output(){
        $nodes = PostCategory::get()->toTree();
        $traverse = function ($categories, $prefix = '-') use (&$traverse) {
            $html ="";
            foreach ($categories as $category) {
                $html ='<option value="'.$category->id.'">'.$prefix.' '.$category->name.'</option>';
                $this->f.= $html;
                $traverse($category->children, $prefix.'-');
            }
            return $this->f;
        };

        return $traverse($nodes);
    }
    function output2($id){
        $nodes = PostCategory::get()->toTree();
        $traverse = function ($categories, $prefix = '-',$id) use (&$traverse) {
            $html ="";
            $info = PostCategory::find($id);
            if($info->parent){
                $pid = $info->parent->id;
            }
            else{
                $pid = 0;
            }
            //print_r($pid);
            foreach ($categories as $category) {
                $select = ($category->id==$pid) ? 'selected' : '';
                $html ='<option value="'.$category->id.'" '.$select.'>'.$prefix.' '.$category->name.'</option>';
                $this->f.= $html;
                $traverse($category->children, $prefix.'-',$id);
            }
            return $this->f;
        };

        return $traverse($nodes,'-',$id);
    }
    public function findCategory($name, $withTrashed = false)
    {
        $q = new PostCategory;
        $q = $withTrashed ? $q->withTrashed() : $q->newQuery();
        return $q->whereName($name)->first();
    }

    function check_slug(){
        $slug  = isset($_POST['slug']) ? trim($_POST['slug']) : '';
        $dem = 0;
        $check = PostCategory::where('slug', '=', $slug)->exists();

        $check = intval($check);

        if($check == 1){
            $dem=0;
            do {
                $dem++;
                $slug = $slug . $dem;
                $check = PostCategory::where('slug', '=', $slug)->exists();
                $check = intval($check);
                
            } while ($check==0);
        }
        
        return response()->json($check);
    }

    function list_categories(){
        $categories = PostCategory::orderBy('id','desc')->get();
        $newarray = array();
        foreach ($categories as $key => $category) {
            $parent_cate = PostCategory::find($category->parent_id);
            array_push(
                $newarray, 
                array(
                    '<a class="openModal" data-toggle="modal" data-target="#actionmodal" data-action="edit" data-id="'.$category->id.'">'.$category->id.'</a>', 
                    '<a class="openModal" data-toggle="modal" data-target="#actionmodal" data-action="edit" data-id="'.$category->id.'">'.$category->name.'</a>', 
                    $category->slug,
                    count($parent_cate) ? trim($parent_cate->name) : 'Thư mục gốc',
                    $category->created_at->toDateTimeString(),
                    ($category->valid==1) ? '<span class="label label-info">active</span>' : '<span class="label label-danger">inactive</span>',
                    '<a class="openModal" data-toggle="modal" data-target="#actionmodal" data-action="edit" data-id="'.$category->id.'">SỬA</a>'
                    )
                );
        }
        $f = array('data'=>$newarray);
        return response()->json($f);
    }

    public function pre($list,$exit=true){
        echo "<pre>";
        print_r($list);
        
        if($exit){
            die();
        }
    }

    
}
