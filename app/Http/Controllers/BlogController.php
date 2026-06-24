<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // direct blog list
    public function list()
    {

        // for search

        // if(!is_null(request('searchKey'))){

        // }

        $data = Blog::select('id', 'title', 'image')
        ->when(request('searchKey') , function($query){
            // $query->orWhere('title' , 'like' , '%'.request('searchKey').'%');
            // $query->orWhere('description' , 'like' , '%'.request('searchKey').'%');
            // $query->orWhere('owner_name' , 'like' , '%'.request('searchKey').'%');

            $query->whereAny(['title' , 'description' , 'owner_name'] , 'like' , '%'.request('searchKey').'%');

        })
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('blog.list', compact('data'));

    }

    // blog create
    public function create(Request $request)
    {
        $this->checkValidation($request, 'create');

        $data = $this->blogDataCreate($request);

        if ($request->hasFile('image')) {
            $fileName = uniqid() . $request->file("image")->getClientOriginalName();
            $request->file('image')->move(public_path() . '/blogImages/', $fileName);
            $data['image'] = $fileName;
        }

        Blog::create($data);

        return back()->with(['status' => 'Blog created success....']);

    }

    // update data
    public function update(Request $request, $id)
    {

        $request['id'] = $id;
        // dd($request->oldImage);
        $this->checkValidation($request, 'update');

        $data = $this->blogDataCreate($request);

        if ($request->hasFile('image')) {
            //dd('choose');
            $oldImage = $request->oldImage; // get old image name

            unlink(public_path('blogImages/' . $oldImage)); // delete old image

            $fileName = uniqid() . $request->file("image")->getClientOriginalName();
            $request->file('image')->move(public_path() . '/blogImages/', $fileName);
            $data['image'] = $fileName;

        }

        // dd($data->toArray());
        Blog::where('id' , $id)
                ->update($data);

        // dd($request->all());

        return to_route('blog#list');

    }

    // get request data
    private function blogDataCreate($request)
    {
        return [
            'title'       => $request->title,
            'description' => $request->description,
            'owner_name'  => $request->ownerName,
        ];
    }

    // check validation
    private function checkValidation($request, $action)
    {
        $rule = [
            'title'       => 'required|min:5|max:99|unique:blogs,title,' . $request->id,
            'description' => 'required|min:5',
            //'image' => 'required|file|mimes:jpg,jpeg,png,svg',
            'ownerName'   => 'required|min:5|max:49',
        ];

        $rule['image'] = $action == 'create' ? 'required|file|mimes:jpg,jpeg,png,svg' : 'file|mimes:jpg,jpeg,png,svg';

        $message = [
            'title.required'       => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'description.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'image.required'       => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'ownerName.required'   => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
        ];

        $request->validate($rule, $message);
    }

    //delete data
    public function delete($id)
    {
        //unlink(public_path('blogImages/' . $imageName));

        // dd($id);
        $imageName = Blog::where('id', $id)
            ->value('image');

        // dd($imageName);

        if (file_exists(public_path('blogImages/' . $imageName))) {
            unlink(public_path('blogImages/' . $imageName));
        }

        Blog::where('id', $id)
            ->delete();

        return back();
    }

    // edit data

    public function edit($id)
    {
        $data = Blog::where('id', $id)
            ->first();

        // dd($data->toArray());
        return view('blog.edit', compact('data'));
    }

}
